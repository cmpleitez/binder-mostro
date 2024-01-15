<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Carbon\carbon;

use App\requisition_user;
use App\requisition;
use App\cart;

class ReportsController extends Controller
{
    Public function privateReports() {
        //LECTURA
        $date = carbon::now();
        $categoria_string = 'mes';
        $cantidad_periodos = 11;

        //PROCESO
        switch ( $categoria_string ) {
            case "dia":
                while ( $cantidad_periodos >= 0 ){
                    $date = carbon::now();
                    $periodo = $date->subDays( $cantidad_periodos );
                    $atenciones[] = requisition_user::where('active', true)->where('processed', true)->whereDay('created_at', $periodo->day)->count();
                    $anulaciones[] = requisition_user::where('active', false)->whereDay('created_at', $periodo->day)->count();
                    $sinreportar[] = requisition_user::where(['processed'=>false, 'active'=>true])->whereDay('created_at', $periodo->day)->whereHas('requisition.cart', function($query){
                            $query->where('purchased', true);
                    })->count();
                    $sinrevisar[] = requisition_user::where(['inspected'=>false])->whereDay('created_at', $periodo->day)->whereHas('requisition.cart', function($query){
                            $query->where('purchased', true);
                    })->count();

                    //PROCESOS
                    $repeticiones_periodo = 0;
                    $requisitions = Requisition::whereHas('user')->whereDay('created_at', $periodo->day)->orderBy('id')->where('active', true)->get();
                    foreach ($requisitions as $key => $requisition) {
                            $repeticiones = requisition_user::where('requisition_id', $requisition->id)->count();
                            $repeticiones_periodo += $repeticiones;
                    }
                    $procesos[]=$repeticiones_periodo;

                    //ETIQUETAS
                    $etiquetas[] = $periodo->locale('es')->dayName.'/'. $periodo->day;
                    $cantidad_periodos--;
                }
                break;
            case "mes":
                while ( $cantidad_periodos >= 0 ){
                    $date = carbon::now();
                    $periodo = $date->subMonths( $cantidad_periodos );
                    $atenciones[] = requisition_user::where('active', true)->where('processed', true)->whereMonth('created_at', $periodo->month)->count();
                    $anulaciones[] = requisition_user::where('active', false)->whereMonth('created_at', $periodo->month)->count();
                    $sinreportar[] = requisition_user::where(['processed'=>false, 'active'=>true])->whereMonth('created_at', $periodo->month)->whereHas('requisition.cart', function($query){
                            $query->where('purchased', true);
                    })->count();
                    $sinrevisar[] = requisition_user::where('inspected', false)->whereMonth('created_at', $periodo->month)->whereHas('requisition.cart', function($query){
                            $query->where('purchased', true);
                    })->count();

                    //PROCESOS
                    $repeticiones_periodo = 0;
                    $requisitions = Requisition::whereHas('user')->whereMonth('created_at', $periodo->month)->orderBy('id')->where('active', true)->get();
                    foreach ($requisitions as $requisition) {
                        $repeticiones = requisition_user::where('requisition_id', $requisition->id)->count();
                        $repeticiones_periodo += $repeticiones;
                    }
                    $procesos[]=$repeticiones_periodo;

                    //ETIQUETAS
                    $etiquetas[] = $periodo->monthName;
                    $cantidad_periodos--;
                }
                break;
        }

        //RESULTADO
        $data['etiquetas']      = $etiquetas;
        $data['atenciones']     = $atenciones;
        $data['procesos']       = $procesos;
        $data['anulaciones']    = $anulaciones;
        $data['sinreportar']    = $sinreportar;
        $data['sinrevisar']     = $sinrevisar;
        return view('models.reports.private_reports', $data);
    }

    Public function reporteVentas() {
        $data['ventas'] = requisition::where('active', true)->whereHas('cart', function($query){
            $query->where('purchased', true);
        })->with('cart')->with('offer')->with('service')->get();

        $data['total'] = requisition::where('active', true)->whereHas('cart', function($query){
            $query->where('purchased', true);
        })->sum('requisition_amount');
        return view('models.reports.ventas', $data);
    }
}
