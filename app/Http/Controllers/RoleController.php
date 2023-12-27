<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use DB;

use App\Role;
use App\Service;
use App\User;
use App\role_service;

class RoleController extends Controller
{
      public function index()
      {
            $roles = Role::orderBy('id', 'asc')->paginate(10);
            return view('models.role.index', compact('roles'));
      }

    public function create()
    {
        return view('models.role.create');
    }

    public function edit(Role $role)
    {
        //
    }

    public function store(Request $request)
    {
        $request->validate([
            'role'      => 'required|string|min:3|max:255|unique:roles',
        ]);
        $role = new Role();
        $role->role = $request->role;
        if ($role->save()) {
            toastr()->success("El rol ha sido creado efectivamente", $role->role, [ 'timeOut' => 10000 ]);
        } else {
            toastr()->warning("Ocurrió un error cuando se intentaba crear el rol", $role->role, [ 'timeOut' => 10000 ]);
            return back();
        };
        $datos = [ //Asignando servicios básicos
            [
                'role_id' => $role->id,
                'service_id' => 81,
            ],
            [
                'role_id' => $role->id,
                'service_id' => 84,
            ],
            [
                'role_id' => $role->id,
                'service_id' => 35,
            ],
            [
                'role_id' => $role->id,
                'service_id' => 33,
            ],
            [
                'role_id' => $role->id,
                'service_id' => 1,
            ],
            [
                'role_id' => $role->id,
                'service_id' => 28,
            ],
        ];
        foreach ($datos as $dato) {
            role_service::create($dato);
        }
        toastr()->info("Se asignaron los servicios básicos", $role->role, [ 'timeOut' => 10000 ]);
        return redirect()->route('role');
    }

    public function bind(Role $role)
    {
        $role_id = $role->id;
        $services = Service::where('active', true)->where('service_type_id', 1)->orWhere('service_type_id', 2)->orWhere('service_type_id', 3)->with('service_type')->orderBy('service_type_id', 'desc')->get();
        foreach ($services as $key=>$service) {
            $service_id = $service->id;
            $enrolled = Role::whereHas('service', function($query) use($service_id){
                $query->where(['service_id'=>$service_id, 'active'=>true]);
            })->where(['id'=>$role_id, 'active'=>true])->count();
            if ($enrolled>0) {
                $services[$key] = array_add($service,'enrolled', '1');
            } else {
                $services[$key] = array_add($service,'enrolled', '0');
            }
        }
        return view('models.role.bind', compact('role', 'services'));
    }

    public function undo(Role $role)
    {
        if ($role->active) {
            $role->active = 0;
        } else {
            $role->active = 1;
        }
        if($role->save()){
            toastr()->warning("El estado del rol ha sido revertido efectivamente", $role->role, [ 'timeOut' => 30000 ]);
            return back();
        }
        toastr()->warning("Falló el intento de revertir el estado del rol", $role->role, [ 'timeOut' => 30000 ]);
        return back();
    }

    public function set(Request $request, Role $role)
    {
        DB::beginTransaction();
        try {
            $services = Service::where('active', true)->get();
            foreach ($services as $service) {
                if ($request["$service->id"]=="on") { //Si fué solicitado
                    if (!$role->service->where('id', $service->id)->first()) {
                        $role_service                   = new role_service();
                        $role_service->service_id   = $service->id;
                        $role_service->role_id   = $role->id;
                        $role_service->save();
                    }
                } else { //Si no fue solicitado significa que se solicita remover el enrolamiento
                    if ($role->service->where('id', $service->id)->first()) {
                        $role_service = role_service::where('role_id', $role->id)->where('service_id', $service->id)->first();
                        $role_service->delete();
                    }
                }
            }
            DB::commit();
            toastr()->success("Se han establecido los servicios para el rol", $role->role, [ 'timeOut' => 10000 ]);
            return redirect('role');
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
