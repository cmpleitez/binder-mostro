<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use DB;

use App\Cart;
use App\Offer;
use App\Requisition;
use App\requisition_user;
use App\User;
use App\Service;
use App\Stock;
use App\Branch;

class TaskController extends Controller
{
    public function index() { //$requisition_user = Tareas o incidencias
        $tasks = requisition_user::whereHas('user', function($q1) {
            $q1->where('user_id', auth()->user()->id);
        })->whereHas('requisition.cart', function($q2) {
            $q2->where('purchased', true);
        })->whereHas('requisition.service', function($q3){
            $q3->where('service_type_id', 2)->orWhere('service_type_id', 3);
        })->where('processed', false)->with('user')->with('requisition.cart')->with('requisition.offer')->with('requisition.service')->orderBy('requisition_id', 'asc')->take(50)->paginate(10);
        $tasks_quantity = $tasks->count();
        if ($tasks_quantity==0) {
            toastr()->info(__("You still dont have tasks"));
            return redirect()->route('cart.offers', Auth()->user()->id);
        } elseif($tasks_quantity>0) {
            foreach ($tasks as $key => $task) {
                $cart_id = $task->requisition->cart->id;
                $last_processed = requisition_user::whereHas('requisition', function($query1) use ($cart_id){
                    $query1->where('cart_id', $cart_id);
                })->whereHas('requisition.service', function($query2){
                    $query2->where('service_type_id', 2)->orWhere('service_type_id', 3);
                })->where(['active'=>true, 'processed'=>true])->with('requisition.service')->orderBy('updated_at', 'desc')->first();
                if ($last_processed) {
                    $tasks[$key] = array_add($task,'last_processed', $last_processed->requisition->service->service);
                    $tasks[$key] = array_add($task,'last_inspected', $last_processed->inspected);
                } else {
                    $tasks[$key] = array_add($task,'last_processed', 'Recibido');
                    $tasks[$key] = array_add($task,'last_inspected', 0);
                }
            }
            return view('models.requisition.index', compact('tasks', 'tasks_quantity'));
        }
    }


    public function taskManager()
    {
        $incidences = requisition_user::whereHas('requisition.service', function($q1){
            $q1->where('service_type_id','!=', 1);
        })->orderby('id', 'asc')->get();
        return view('models.requisition.manager', compact('incidences'));
    }

    public function do($service_id, $requisitions_user_id, $requisitions_user_quantity)
    {
        //VALIDATION
        if ($requisitions_user_quantity==0) {
            toastr()->warning(__("Operator still dont has tasks to do"), [ 'timeOut' => 5000 ]);
            return redirect()->route('cart.offers', auth()->user()->id);
        }
        
        //PROCESSING
        $requisition_user = requisition_user::find($requisitions_user_id);
        $requisition_user->processed = 1;
        if ($requisition_user->save()){} else {
            toastr()->warning("Falló el intento de reportar la actividad", [ 'timeOut' => 5000 ]);
        };
        
        //RESULTADO
        toastr()->info("Actividad reportada correctamente");
        return back();
    }

    public function undo($task_id, $requisition_user_quantity) {
        //VALIDATION
        if ($requisition_user_quantity==0) {
            toastr()->warning(__("Operator still dont has tasks to do"), [ 'timeOut' => 5000 ]);
            return redirect()->route('forestHome');
        };
        
        //PROCESSING
        $task = requisition_user::find($task_id);
        if ($task->active) {
            $task->active = 0;
            if (!$task->save()) {
                toastr()->warning("Falló el intento de anular la actividad");
                return back();
            };
        } elseif( !$task->active ) {
            $task->active = 1;
            if (!$task->save()) {
                toastr()->warning("Falló el intento de reactivar la actividad");
                return back();
            };
        };
        
        //RESULTADO
        if ($task->active) {
            toastr()->info("El estado de la actividad fue re-activado");
        } else {
            toastr()->info("El estado de la actividad fue anulado");
        }
        return back();
    }

    public function reDo(requisition_user $task) {
        //PROCESO
        $requisition_user = new requisition_user();
        $requisition_user->user_id = $task->user_id;
        $requisition_user->requisition_id = $task->requisition_id;
        if(!$requisition_user->save()){
            toastr()->info("Falló el intento de efectuar un re-proceso", "RE-PROCESO", [ 'timeOut' => 5000 ]);
            return back();
        }
        
        //RESULTADO
        toastr()->info("Se ha delegado el re-proceso efectivamente", "RE-PROCESO", [ 'timeOut' => 2000 ]);
        return back();
    }

    public function taskInspect(requisition_user $task, $requisition_quantity){
        //VALIDANDO
        if ($requisition_quantity==0) {
            return redirect()->route('cart.offers', auth()->user()->id)->with('success', 'Operator still dont has tasks to do');
        }

        //PROCESO
        if ( $task->inspected ) {
            $task->inspected = 0;
        } else {
            $task->inspected = 1;
        }
        if( !$task->save() ){
            toastr()->warning("Falló el intento de marcar la actividad como revisada", "REVISIÓN", [ 'timeOut' => 5000 ]);
            return back();
        }
        $requisition_quantity--;
        if ($requisition_quantity==0) {
            return redirect()->route('cart.offers', auth()->user()->id)->with('success', 'Ha finalizado la revisión de las actividades para el operador seleccionado');
        }

        //RESULTADO
        if ( $task->inspected ) {
            toastr()->info("Se marcó la actividad como revisada", "REVISIÓN", [ 'timeOut' => 5000 ]);
        } else {
            toastr()->info("Se marcó la actividad como pendiente de revisar", "REVISIÓN", [ 'timeOut' => 5000 ]);
        }
        return back();
    }
}