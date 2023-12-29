<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Mail;
use App\Mail\mailSent;

use App\Role;
use App\Requisition;
use App\cart;
use App\requisition_user;
use Auth;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        //REGLAS DE ACCESO
        if (auth()->user()->active==0) { //Usario inactivo
            Auth::logout();
            toastr()->info("Su cuenta ha sido desactivada", $user->name, [ 'timeOut' => 20000 ]);
            return back();
        }

        //VENTANA DE BIENVENIDA PARA EL ROL
        $role = Role::whereHas('user', function($query) {
            $query->where('user_id', auth()->user()->id);
        })->first();
        $pending_requisitions = Requisition::whereHas('user', function($query) {  //Leyendo número de actividades
            $query->where(['user_id'=>auth()->user()->id, 'processed'=>false]);
        })->count();
        $pending_invoices = Requisition::whereHas('user', function($query){
            $query->where('user_id',auth()->user()->id);
        })->where('invoiced', false)->count();
        if (isset($role->id)) {
            if ($role->id==1) { //Ventas
                if ($pending_requisitions>0) {
                    return redirect()->route('task', auth()->user()->id);
                }
            } elseif($role->id==2) { //Cajero
                if ($pending_invoices>0) {
                    return redirect()->route('sale');
                }
            } elseif($role->id==3) { //Diseñador
                if ($pending_requisitions>0) {
                    return redirect()->route('task', auth()->user()->id);
                }
            } elseif($role->id==4) { //Ensamblador
                if ($pending_requisitions>0) {
                    return redirect()->route('task', auth()->user()->id);
                }
            } elseif($role->id==5) { //Gestor de calidad
                if ($pending_requisitions>0) {
                    return redirect()->route('task', auth()->user()->id);
                }
            } elseif($role->id==6) { //Bodeguero
                if ($pending_requisitions>0) {
                    return redirect()->route('task', auth()->user()->id);
                }
            } elseif($role->id==7) { //Motorista
                if ($pending_requisitions>0) {
                    return redirect()->route('task', auth()->user()->id);
                }
            } elseif($role->id==8) { //Administrador
                return redirect()->route('user');
            } elseif($role->id==9) { //Supervisor
                return redirect()->route('task', auth()->user()->id);
            }
            toastr()->info("Catálogo de Ofertas");
            return redirect()->route('cart.products', auth()->user()->id);
        } else {
            toastr()->info("El portal de compras para el público en general aún no está disponible");
            return redirect()->back();
        }
    }
}