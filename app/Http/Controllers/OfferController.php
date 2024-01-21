<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use DB;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

use App\Offer;
use App\Service;
use App\offer_service;

class OfferController extends Controller
{
    public function index()
    {
        $offers = Offer::where('id', '<>', 1)->orderBy('updated_at', 'desc')->paginate(10);
        return view('models.offer.index', compact('offers'));
    }

    public function create()
    {
        return view('models.offer.create');
    }

    public function edit(Offer $offer)
    {
        return view('models.offer.edit', ['offer' => $offer]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'pic'       => 'max:3070|mimes:jpeg,png,jpg,gif',
            'offer'     => 'required|min:4|max:255|unique:offers',
            'charge'    => 'required',
        ]);
        $offer = new Offer();
        $offer->offer = $request->offer;
        $offer->charge = str_replace ( "," , "" , $request->charge);
        if (!$offer->save()) {
            toastr()->error("Ocurrió un error cuando se intentaba crear la oferta", $offer->offer, [ 'timeOut' => 30000 ]);
            return back();
        };
        if ($request->hasfile('pic')) {
            $nombre_archivo = $offer->id.'.'.$request->file('pic')->extension(); //Estableciendo ruta
            $path_file_name = Storage::putFileAs('public/offers', $request->file('pic'), $nombre_archivo);
            $offer->pic = $path_file_name;
            $offer->save();
            $image = Image::make(Storage::get($path_file_name)); //Redimencionando mapa de bits
            $image->fit(300, 300, function ($constraint) {
                $constraint->upsize();
            })->encode();
            Storage::put($path_file_name, (string) $image);
            toastr()->info("Imagen de la oferta ha sido guardada correctamente", $offer->offer, [ 'timeOut' => 20000 ]);
        };
        toastr()->success("Oferta ha sido creada efectivamente", $offer->offer, [ 'timeOut' => 10000 ]);
        return redirect()->route('offer');
    }

    public function update(Request $request, Offer $offer)
    {
        $request->validate([
            'pic'       => 'nullable|max:3070|mimes:jpeg,png,jpg,gif',
            'charge'    => 'required',
        ]);
        $offer->charge = str_replace ( "," , "" , $request->charge);
        if (!$offer->save()) {
            toastr()->error("Ocurrió un error cuando se intentaba actualizar la oferta", $offer->offer, [ 'timeOut' => 30000 ]);
            return back();
        };
        if ($request->hasfile('pic')) {
            $nombre_archivo = $offer->id.'.'.$request->file('pic')->extension(); //Estableciendo ruta
            $path_file_name = Storage::putFileAs('public/offers', $request->file('pic'), $nombre_archivo);
            $offer->pic = $path_file_name;
            $offer->save();

            $image = Image::make(Storage::get($path_file_name)); //Redimencionando mapa de bits
            $image->fit(300, 300, function ($constraint) {
                $constraint->upsize();
            })->encode();
            Storage::put($path_file_name, (string) $image);
            toastr()->success("Imagen de la oferta ha sido actualizada correctamente", $offer->offer, [ 'timeOut' => 20000 ]);
        };
        toastr()->info("La oferta ha sido actualizada efectivamente");
        return redirect()->route('offer');
   }

    public function bind(Offer $offer)
    {
        $offer_id = $offer->id;
        $services = Service::orWhere('service_type_id', 3)->orWhere('service_type_id', 4)->where('active', true)->with('service_type')->with('stock')->orderBy('service_type_id', 'desc')->paginate(24);
        foreach ($services as $key=>$service) {
            $service_id = $service->id;
            $enrolled = Offer::whereHas('service', function($query) use($offer_id, $service_id){
                $query->where(['service_id'=>$service_id, 'active'=>true]);
            })->where(['id'=>$offer_id, 'active'=>true])->count();
            if ($enrolled>0) {
                $services[$key] = array_add($service,'enrolled', '1');
            } else {
                $services[$key] = array_add($service,'enrolled', '0');
            }
        }
        return view('models.offer.bind', compact('offer', 'services'));
    }

    public function undo(Offer $offer)
    {
        if ($offer->active) {
            $offer->active = 0;
        } else {
            $offer->active = 1;
        }
        if($offer->save()){
            toastr()->warning("El estado de la oferta ha sido revertido efectivamente", $offer->offer, [ 'timeOut' => 10000 ]);
            return back();
        }
        toastr()->warning("Falló el intento de revertir el estado de la oferta", $offer->offer, [ 'timeOut' => 30000 ]);
        return back();
    }

    public function set(Request $request, Offer $offer) {
        DB::beginTransaction();
        try {
            $services = Service::where('active', true)->where('service_type_id', '!=', 1)->get();
            foreach ($services as $service) {
                if ($request["$service->id"]=="on") { //Verificar si fue solicitado por el operador
                    if ($service->service_type_id == 2 and $service->role[0]->user->count()==0) {  //Verificar si se trata de un servicio que aún no ha sido enrolado al menos a un operador
                        alert($service->service, "El servicio aún no ha sido asignado a un operador. El resto de servicios que comparten ésta misma condición han sido ignorados", 'warning');
                        return back();
                    }
                    if (!$offer->service->where('id', $service->id)->count()>0) {
                        $offer_service             = new offer_service();
                        $offer_service->offer_id   = $offer->id;
                        $offer_service->service_id = $service->id;
                        $offer_service->save();
                    }
                } else { //Si no fue solicitado significa que se solicita remover el enrolamiento
                    if ($offer->service->where('id', $service->id)->first()) {
                        $offer_service = offer_service::where('offer_id', $offer->id)->where('service_id', $service->id)->first();
                        $offer_service->delete();
                    }
                }
            }
            DB::commit();
            toastr()->info("Los items que integran la oferta han sido establecidos efectivamente", $offer->offer, [ 'timeOut' => 10000 ]);
            return redirect()->route('offer');
        } catch (\Exception $e) {
            DB::rollback();
            toastr()->error("Ocurrió un error inesperado por favor reporte al área técnica", "Error", [ 'timeOut' => 30000 ]);
            return back();
        } catch (\Throwable $e) {
            DB::rollback();
            toastr()->error("Ocurrió un error inesperado por favor reporte al área técnica", "Error", [ 'timeOut' => 30000 ]);
            return back();
        } catch (\ModelNotFoundException $exception) {
            DB::rollback();
            toastr()->error("Ocurrió un error inesperado por favor reporte al área técnica", "Error", [ 'timeOut' => 30000 ]);
            return back();
        }
    }
}
