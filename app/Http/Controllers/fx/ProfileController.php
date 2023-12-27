<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use DB;

class ProfileController extends Controller
{
    public function update(Request $request, $user_id)
    {
        $operador = User::findorFail($user_id);
        $roles = Role::where('active', 1)->get();
        $cantidad_roles = $roles->count();
        DB::beginTransaction();
        try {
            for ($x = 1; $x <= $cantidad_roles; $x++) {
                if (isset($request->enrolled[$x])) {
                    if ($request->enrolled[$x]=='on') {
                        //Role adding
                        $enrolled = Role::whereHas('Profile', function ($query) use ($user_id, $x) {
                            $query->where('role_id', $x)->where('user_id','=',$user_id);
                        })->count();
                        if ($enrolled>0) {
                        } else {
                            Profile::create([
                                'user_id' => $user_id,
                                'role_id' => $x,
                            ]);
                        }
                    } else {
                        //Role removing
                        $enrolled = Role::whereHas('Profile', function ($query) use ($user_id, $x) {
                            $query->where('role_id', $x)->where('user_id','=',$user_id);
                        })->count();
                        if ($enrolled>0) {
                            $Profile = Profile::where('user_id', $user_id)->where('role_id', $x)->first();
                            $Profile->delete();
                        }
                    }
                } else {
                    //Role removing
                    $enrolled = Role::whereHas('Profile', function ($query) use ($user_id, $x) {
                        $query->where('role_id', $x)->where('user_id','=',$user_id);
                    })->count();
                    if ($enrolled>0) {
                        $Profile = Profile::where('user_id', $user_id)->where('role_id', $x)->first();
                        $Profile->delete();
                    }
                }
            }
            DB::commit();
            toastr()->success("El perfil del usuario ha sido actualizado", $operador->name, [ 'timeOut' => 10000 ]);
            return back();
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
