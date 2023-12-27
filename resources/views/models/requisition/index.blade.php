@extends('forestLayout')
@section('content')
<div class="card shadow-sm">
    <div class="card-header badge-circle-light-primary">
        <div class="card-group">
            <div class="row">
                <div class="col-md-9 float-left  text-uppercase">@lang('Processing tasks')</div>
                <div class="col-md-3 text-right float-right ">
                    <div class="badge badge-pill bg-primary bg-lighten-1 shadow-sm">
                        Total {{$tasks->count()}} tasks
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="card-content">
        <div class="card-body" align="right">
        </div>
        <!-- table hover -->
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead>
                    <tr class="text-center">
                        <th>@lang('CART')</th>
                        <th>@lang('TASK')</th>
                        <th>CLIENTE</th>
                        <th>DETALLE</th>
                        <th>@lang('QUANTITY')</th>
                        <th class="text-center">TABLERO</th>
                        <th class="text-center">ESTADO</th>
                    </tr>
                </thead>
                <tbody>
                	@foreach($tasks as $task)
                        <tr class="text-center">
                            
                            <!--ORDER-->
                        	<td class="text-bold-500 col-1">
                                <div class="badge badge-pill bg-primary bg-lighten-1 pl-2 pr-2 pt-1 pb-1">
                                    {{$task->requisition->cart_id}}
                                </div>
                            </td>
                            
                            <!--TASK-->
                            <td class="col-1">
                                @if($task->active)
                                    <div class="badge badge-pill badge-light-primary p-1 mr-1">
                                        {{$task->requisition->id}}
                                        <small class="text-muted">{{$task->id}}</small>
                                    </div>
                                @else
                                    <div class="badge badge-pill badge-light-danger p-1 mr-1">
                                        {{$task->requisition->id}}.{{$task->id}} @lang('nullify')
                                    </div>
                                @endif
                            </td>

                            <!--CLIEN NAME-->
                            <td>{{$task->requisition->cart->client->name}}</td>

                            <!--DETAIL-->
                            <td class="text-justify col-3">
                                @if( $task->requisition->supply_detail )
                                    @if ( $task->requisition->offer->id == 1)
                                        <b>{{$task->requisition->service->service}}</b>: {{$task->requisition->supply_detail}}
                                    @else
                                        {{$task->requisition->offer->offer}} | <b>{{$task->requisition->service->service}}</b> : {{$task->requisition->supply_detail}}
                                    @endif
                                @else
                                    @if ( $task->requisition->offer->id == 1)
                                        <b>{{$task->requisition->service->service}}</b>
                                    @else
                                        {{$task->requisition->offer->offer}} | <b>{{$task->requisition->service->service}}</b>
                                    @endif
                                @endif
                            </td>

                            <!--QUANTITY-->
                            <td>{{$task->requisition->supply_quantity}}</td>

                            <!--CONTROL PANEL-->
                            <td class="col-1">
                                <div class="row d-flex justify-content-center">
                                    {!! taskControlPanel($task->requisition->service_id, $task, $tasks->count()) !!}
                                </div>
                            </td>

                            <!--ESTADO-->
                            <td class="col-2">
                                <div class="badge badge-pill badge-light-primary d-inline-flex align-items-center">
                                    @if ($task->last_inspected)
                                        <i class="bx bxs-check-circle font-size-medium mr-25" ></i>
                                    @endif
                                    <span>{{$task->last_processed}}</span>
                                </div>
                                <div>
                                    <small class="text-muted">{{$task->updated_at->diffForHumans()}}</small>
                                </div>
                            </td>

                        </tr>
                	@endforeach
                </tbody>
            </table>
        </div>
    </div>
    <div class="card-footer">
        <div class="">
            {{ $tasks->appends(request()->input())->links() }}
        </div>
    </div>
</div>
@endsection