<?php
namespace App\Http\Controllers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use DB;

use App\User;
use App\Role;
use App\role_user;
use App\Cashbox;
use App\Area;
use App\Branch;

class UserController extends Controller
{
    public function index()
    {
        $users = User::where('branch_id', auth()->user()->branch_id)->where('id', '<>', 1)->orderBy('name')->paginate(10);
        return view('models.user.index', compact('users'));
    }

    public function search(Request $request)
    {
        $users = User::where('branch_id', auth()->user()->branch_id)->where('id', '<>', 1)->Search($request->search)->orderBy('name')->paginate(10);
        return view('models.user.index', compact('users'));
    }

    public function create()
    {
        $data['branches'] =  Branch::select(['id', 'branch'])->orderBy('branch')->get();
        $data['areas'] =  Area::select(['id', 'area'])->orderBy('area')->get();
        return view('models.user.create', $data);
    }

    public function edit(User $user)
    {
        $data['user'] =  $user;
        $data['branches'] =  Branch::select(['id', 'branch'])->orderBy('branch')->get();
        $data['areas'] =  Area::select(['id', 'area'])->orderBy('area')->get();
        return view('models.user.edit', $data);
    }

    protected function store(request $request)
    {
        $request->validate([
            'dui'                           => 'nullable',
            'phone_number'     =>'nullable',
            'nit'                            =>'nullable',
            'nrc'                           =>'nullable',
            'name'                      => 'required|string|min:4|max:255',
            'email'                      => 'required',
            'branch_id'              => 'required',
            'area_id'                  => 'required',
            'password'              => 'required|min:4|confirmed',
        ]);
        DB::beginTransaction();
        try {
            $user = new User();
            if (!empty($request->dui)) {
                $user->dui  = $request->unmasked_dui;
            }
            if (!empty($request->phone_number)) {
                $user->phone_number  = $request->unmasked_phone_number;
            }
            if (!empty($request->nit)) {
                $user->nit  = $request->unmasked_nit;
            }
            if (!empty($request->nrc)) {
                $user->nrc  = $request->unmasked_nrc;
            }
            $user->name  = $request->name;
            $user->email  = $request->email;
            $user->branch_id  = $request->branch_id;
            $user->area_id  = $request->area_id;
            $user->password  = Hash::make($request->password);
            $user->autoservicio  = 0;
            if (!$user->save()) {
                toastr()->warning("Falló el intento de crear el usuario", $user->name, [ 'timeOut' => 30000 ]);
                return back();
            };
            DB::commit();
            toastr()->success("El usuario ha sido creado");
            return redirect()->route('user');
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

    public function update(Request $request, User $user)
    {
        $request->validate([
            'dui'                           => 'nullable|numeric|digits:9',
            'phone_number'     => 'nullable|numeric|digits_between:8,10',
            'nit'                            => 'nullable|numeric|digits:14',
            'nrc'                           => 'nullable|numeric|digits_between:1,7',
            'name'                      => 'required|string',
            'branch_id'              => 'required',
            'area_id'                  => 'required',
        ]);
        $user->dui  = $request->dui;
        $user->phone_number  = $request->phone_number;
        $user->nit  = $request->nit;
        $user->nrc  = $request->nrc;
        $user->branch_id  = $request->branch_id;
        $user->area_id  = $request->area_id;
        if ($user->save()) {
            toastr()->success("Usuario actualizado");
            return redirect()->route('user', 0);
        };
        toastr()->warning("Falló el intento de actualizar el usuario", $user->name, [ 'timeOut' => 30000 ]);
        return back();
    }

    public function undo( User $user ) {
        if ($user->active) {
            $user->active = 0;
        } else {
            $user->active = 1;
        }
        if($user->save()){
            toastr()->warning("El estado del usuario ha sido revertido", $user->name, [ 'timeOut' => 30000 ]);
            return back();
        }
        toastr()->warning("Falló el intento de revertir el estado del usuario", $user->name, [ 'timeOut' => 30000 ]);
        return back();
    }

    public function bind(User $user)
    {
        $user_id = $user->id;
        $roles = Role::where('active', true)->orderBy('id')->get();
        foreach ($roles as $key=>$role) {
            $role_id = $role->id;
            $enrolled = User::whereHas('Role', function($query) use($user_id, $role_id){
                $query->where(['role_id'=>$role_id, 'active'=>true ]);
            })->where(['id'=>$user_id, 'active'=>true])->count();
            if ($enrolled>0) {
                $roles[$key] = array_add($role,'enrolled', '1');
            } else {
                $roles[$key] = array_add($role,'enrolled', '0');
            }
        }
        return view('models.user.bind', compact('user', 'roles'));
    }

    public function set(Request $request, User $user)
    {
        DB::beginTransaction();
        try {
            $roles = Role::where('active', true)->get();
            foreach ($roles as $role) {
                if ($request["$role->id"]=="on") { //Si fué solicitado
                    if (!$user->role->where('id', $role->id)->first()) {
                        $role_user                  = new role_user();
                        $role_user->user_id = $user->id;
                        $role_user->role_id = $role->id;
                        $role_user->save();
                    }
                } else { //Si no fue solicitado significa que se solicita remover el enrolamiento
                    if ($user->role->where('id', $role->id)->first()) {
                        $role_user = role_user::where('user_id', $user->id)->where('role_id', $role->id)->first();
                        $role_user->delete();
                    }
                }
            }
            DB::commit();
            toastr()->info("Perfil del usuario actualizado con éxito", $user->name, [ 'timeOut' => 10000 ]);
            return redirect()->route('user', 0);
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