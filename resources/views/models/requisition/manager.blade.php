@extends('forestLayout')
@section('content')
<div class="card shadow-sm m-0">
    <div class="card-header badge-circle-light-secondary">
        <h4 class="card-title">GESTOR DE TAREAS</h4>
    </div>
    <div class="card-content">
        <div class="card-body">
        </div>
        <div class="table-responsive">
            <table class="table" style="color: #363a3e;">
                <thead>
                    <tr align="center">
                        <th>ORDEN</th>
                        <th class="text-left">TAREA</th>
                        <th>UNIDADES</th>
                        <th>AREA</th>
                        <th class="text-center">OPERADOR</th>
                        <th class="text-left">REPORTE</th>
                        <th class="text-left">ESTADO</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($incidences as $incidence)
                        <tr style="<?php
                            if($incidence->processed == 1 and $incidence->inspected == 1) {
                                echo "background-color: #00e53924";
                            } elseif($incidence->processed == 1 and $incidence->inspected == 0) {
                                echo "background-color: #ff95040a";
                            } elseif($incidence->processed == 0 and $incidence->inspected == 0) {
                                echo "background-color: #ff950417";
                            };
                        ?>">

                            <!--ID ORDEN-->
                            <td class="text-center col-1">
                                @if ($incidence->active)
                                <div class="badge badge-pill badge-light-primary pl-2 pr-2 pt-1 pb-1">
                                    {{ $incidence->requisition->cart->id }} | {{ $incidence->requisition->cart->client->name }}
                                </div>
                                @else
                                <div class="badge badge-pill badge-light-warning pl-2 pr-2 pt-1 pb-1">
                                    {{ $incidence->requisition->cart->id }} | {{ $incidence->requisition->cart->client->name }}
                                </div>
                                @endif
                            </td>

                            <!--TAREA-->
                            <td class="col-3">
                                @if($incidence->active)
                                    <div class="badge badge-pill badge-light-primary p-1 mr-1">
                                        {{$incidence->requisition->id}}
                                        <small class="text-muted">{{$incidence->id}}</small>
                                    </div>
                                    @if($incidence->requisition->supply_detail)
                                        {{$incidence->requisition->offer->offer}} -> <b>{{$incidence->requisition->service->service}}</b> -> {{$incidence->requisition->supply_detail}}
                                    @else
                                        {{$incidence->requisition->offer->offer}} -> <b>{{$incidence->requisition->service->service}}</b>
                                    @endif
                                @else
                                    <div class="badge badge-pill badge-light-danger p-1 mr-1">
                                        {{$incidence->requisition->id}}.{{$incidence->id}} @lang('nullify')
                                    </div>
                                @endif
                            </td>

                            <!--UNIDADES-->
                            <td class="text-center col-1">{{ $incidence->requisition->supply_quantity }}</td>

                            <!--AREA-->
                            <td class="text-center col-2" style="color: dark;">{{$incidence->area->area}}</td>

                            <!--OPERADOR-->
                            <td class="text-center col-2" style="color: dark;">{{ $incidence->user->name }}</td>

                            <!--REPORTE-->
                            <td class="text-left col-2">
                                @if ($incidence->processed==1)
                                    <span class="bullet bullet-warning bullet-sm"></span>
                                    <small class="text-muted">Procesado</small>
                                @else
                                    <span class="bullet bullet-danger bullet-sm"></span>
                                    <small class="text-muted">Pendiente</small>
                                @endif
                                <small class="text-muted">{{ $incidence->updated_at->diffForHumans() }}</small>
                            </td>

                            <!--ESTADO-->
                            <td class="text-left col-1" style="color: dark;">
                                @if( $incidence->processed==true and ($incidence->requisition->service->service_type_id==2 or $incidence->requisition->service->service_type_id==3) )
                                    <div class="badge badge-pill badge-light-success">
                                        <div class="float-left ">
                                            @if($incidence->inspected)
                                                <i class="bx bxs-check-circle font-size-medium"></i>
                                            @endif
                                        </div>
                                        <div class="float-right ">{{$incidence->requisition->service->service}}</div>
                                    </div>
                                @else
                                    <div class="badge badge-pill badge-light-warning">
                                        RECIBIDO
                                    </div>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection