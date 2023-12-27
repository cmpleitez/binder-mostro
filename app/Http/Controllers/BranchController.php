<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;
use App\Branch;

class BranchController extends Controller
{
    public function index()
    {
        $branches = Branch::orderBy('updated_at', 'desc')->paginate(10);
        return view('models.branch.index', compact('branches'));
    }

    public function create()
    {
        return view('models.branch.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'branch'                 => 'required|min:4|max:255|unique:branches',
            'pic'                        => 'max:3070|mimes:jpeg,png,jpg,gif',
            'phone_number' => 'required',
        ]);
        $branch = new Branch();
        $branch->branch  = $request->branch;
        $branch->phone_number  = $request->phone_number;
        if (!$branch->save()) {
            toastr()->warning("Falló el intento de crear la sucursal");
            return back();
        };
        if ($request->hasfile('pic')) {
            $nombre_archivo = $branch->id.'.'.$request->file('pic')->extension(); //Estableciendo ruta
            $path_file_name = Storage::putFileAs('public/branches', $request->file('pic'), $nombre_archivo);
            $branch->pic = $path_file_name;
            $branch->save();
            $image = Image::make(Storage::get($path_file_name));
            $image->fit(500, 100, function ($constraint) {
                $constraint->upsize();
            })->encode();
            Storage::put($path_file_name, (string) $image);
        };
        toastr()->success($branch->branch.' '.__('was created'), "SUCURSAL", ['timeOut'=>3000]);
        return redirect()->route('branch');
    }

    public function edit(Branch $branch)
    {
        return view('models.branch.edit', compact('branch'));
    }

    public function update(Request $request, Branch $branch)
    {
        $request->validate([
            'phone_number' => 'required',
            'pic' => 'nullable|max:3070|mimes:jpeg,png,jpg,gif',
        ]);
        $branch->phone_number  = $request->phone_number;
        if ( !$branch->save() ) {
            toastr()->warning("Falló el intento de actualizar el número de teléfono", "SUCURSAL", ['timeOut'=>4000]);
            return back();
        };
        if ($request->hasfile('pic')) {
            $nombre_archivo = $branch->id.'.'.$request->file('pic')->extension(); //Estableciendo ruta
            $path_file_name = Storage::putFileAs('public/branches', $request->file('pic'), $nombre_archivo);
            $branch->pic = $path_file_name;
            $branch->save();
            $image = Image::make(Storage::get($path_file_name)); //Redimencionando mapa de bits
            $image->fit(500, 100, function ($constraint) {
                $constraint->upsize();
            })->encode();
            Storage::put($path_file_name, (string) $image);
        };
        toastr()->success("Los datos de la sucursal han sido actualizados", $branch->branch, ['timeOut'=>3000]);
        return redirect()->route('branch');
    }

    public function undo( Branch $branch )
    {
        if ($branch->active) {
            $branch->active = 0;
        } else {
            $branch->active = 1;
        }
        if( !$branch->save() ){
            if ($branch->active) {
                toastr()->warning("Falló el intento de anulación", "SUCURSAL", ['timeOut'=>4000]);
            } else {
                toastr()->warning("Falló el intento de re-activación", "SUCURSAL", ['timeOut'=>4000]);
            }
            return back();
        }
        toastr()->warning("Éste cambio es fundamental para el funcionamiento general del sistema, para resolver cualquier 'clic' involuntario puede revertirlo dando otro 'clic' en el control de estado", "RECOMENDACIÓN", ['timeOut' => 30000, 'progressBar' => true]);
        if ($branch->active) {
            toastr()->info("Ha sido re-activada efectivamente", "SUCURSAL", ['timeOut'=>35000]);
        } else {
            toastr()->info("Ha sido anulada efectivamente", "SUCURSAL", ['timeOut'=>35000]);
        }
        return back();
    }
}
