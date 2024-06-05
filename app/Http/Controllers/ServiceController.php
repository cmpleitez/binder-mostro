<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;

use App\Service;
use App\service_type;

class ServiceController extends Controller
{
    public function index()
    {
        $services = Service::with('service_type')->orderBy('service_type_id', 'asc')->paginate(25);
        $data['services'] = $services;
        return view('models.service.index', $data);
    }

    
    public function create()
    {
        $service_types = service_type::where('active', true)->get();
        return view('models.service.create', compact('service_types'));
    }

    public function store( Request $request )
    {
        $request->validate([
            'service'           => 'required|min:4|max:255|unique:services',
            'pic'               => 'max:3070|mimes:jpeg,png,jpg,gif',
            'route'             => 'nullable|min:1|max:128',
            'cost'                 => 'required',
            'charge'            => 'required',
            'menu'              => 'nullable|in:on,off',
            'tax_exempt'        => 'nullable|in:on,off',
            'service_type_id'   => 'required|min:1',
            'billable'        => 'in:on,off',
        ]);
        $service = new Service();
        $service->route  = $request->route;
        $service->cost  = str_replace ( "," , "" , $request->cost);
        $service->charge  = str_replace ( "," , "" , $request->charge);
        if ($service->cost  > $service->charge) {
            toastr()->warning('El precio debe ser mayor o igual al costo', "REGLA TÉCNICA", ['timeOut' => 50000 ]);
            return back();
        }
        $service->service_type_id = $request->service_type_id;
        if ($request->menu == 'on') {
            $service->menu = true;
        } elseif( $request->menu == null ) {
            $service->menu = false;
        }
        if ( $request->tax_exempt == 'on' ) {
            $service->tax_exempt = true;
        } elseif( $request->tax_exempt == null ) {
            $service->tax_exempt = false;
        }
        if ( $request->billable == 'on' ) {
            $service->billable = true;
        } elseif( $request->billable == null ) {
            $service->billable = false;
        }
        $service->service = $request->service;

        //Guardando el archivo mapa de bits
        if (!$service->save()) {
            toastr()->warning("Falló el intento de cear el servicio", $service->service, [ 'timeOut' => 30000 ]);
            return back();
        };
        if ($request->hasfile('pic')) {

            $nombre_archivo = $service->id.'.'.$request->file('pic')->extension(); //Estableciendo ruta
            $path_file_name = Storage::putFileAs('public/services', $request->file('pic'), $nombre_archivo);
            $service->pic = $path_file_name;
            $service->save();

            $image = Image::make(Storage::get($path_file_name)); //Redimencionando mapa de bits
            $image->fit(200, 200, function ($constraint) {
                $constraint->upsize();
            })->encode();
            Storage::put($path_file_name, (string) $image);
            toastr()->info("Imagen guardada correctamente", $service->service, [ 'timeOut' => 20000 ]);

        };
        toastr()->success("Producto/Servicio creado efectivamente", $service->service, [ 'timeOut' => 10000 ]);
        return redirect()->route('service');
    }

    public function update(Request $request, Service $service)
    {
        $request->validate([
            'icon'              => 'required',
            'pic' => 'nullable|max:3070|mimes:jpeg,png,jpg,gif',
            'route' => 'nullable|min:1|max:128',
            'cost' => 'required',
            'charge' => 'required',
            'menu'  => 'nullable|in:on,off',
            'tax_exempt' => 'nullable|in:on,off',
            'service_type_id' => 'required|min:1',
            'billable'        => 'in:on,off',
        ]);
        if ($service->cost > $service->charge) {
            toastr()->warning('El precio debe ser mayor o igual al costo', "REGLA TÉCNICA", ['timeOut' => 50000 ]);
            return back();
        }
        $service->service_type_id = $request->service_type_id;
        $service->route     = $request->route;
        $service->icon     = $request->icon;
        $service->cost  = str_replace ( "," , "" , $request->cost);
        $service->charge  =  str_replace ( "," , "" , $request->charge);
        if ($request->menu == 'on') {
            $service->menu = true;
        } elseif( $request->menu == null ) {
            $service->menu = false;
        }
        if ( $request->tax_exempt == 'on' ) {
            $service->tax_exempt = true;
        } elseif( $request->tax_exempt == null ) {
            $service->tax_exempt = false;
        }
        if ( $request->billable == 'on' ) {
            $service->billable = true;
        } elseif( $request->billable == null ) {
            $service->billable = false;
        }
        if (!$service->save()) {
            toastr()->warning("Falló el intento de actualizar el servicio", $service->service, [ 'timeOut' => 30000 ]);
            return back();
        };

        if ($request->hasfile('pic')) {
            $nombre_archivo = $service->id.'.'.$request->file('pic')->extension(); //Estableciendo ruta
            $path_file_name = Storage::putFileAs('public/services', $request->file('pic'), $nombre_archivo);
            $service->pic = $path_file_name;
            $service->save();
            $image = Image::make(Storage::get($path_file_name)); //Redimencionando mapa de bits
            $image->fit(200, 200, function ($constraint) {
                $constraint->upsize();
            })->encode();
            Storage::put($path_file_name, (string) $image);
            toastr()->success("Imagen actualizada correctamente", $service->service, [ 'timeOut' => 20000 ]);
        };
        toastr()->info("El servicio ha sido actualizado", $service->service, [ 'timeOut' => 20000 ]);
        return redirect()->route('service');
    }

    public function edit(Service $service)
    {
        $service_types = service_type::get();
        return view('models.service.edit', compact('service', 'service_types'));
    }

    public function search( Request $request ) {
        $services = Service::Search($request->search)->orderBy('service_type_id', 'asc')->paginate(5);
        return view('models.service.index', compact('services'));
    }

    public function Undo(Service $service)
    {
        if ($service->active) {
            $service->active = 0;
        } else {
            $service->active = 1;
        }
        if ($service->save()) {
            toastr()->warning("El estado del servicio ha sido revertido efectivamente", $service->service, [ 'timeOut' => 30000 ]);
            return redirect()->route('service');
        };
        toastr()->warning("Falló el intento de revertir el estado del servicio", $service->service, [ 'timeOut' => 30000 ]);
        return back();
    }
}
