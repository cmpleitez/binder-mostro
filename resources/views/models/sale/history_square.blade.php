@extends('forestLayout')
@section('content')
<div class="card">
    <!--HEADER DEL CIERRE DE CAJA-->
    <div class="card-header pt-2 pb-3 pr-0 pl-0" align="center">
        <div class="col-md-2 float-left pb-1 text-bold-500"
            style=<?php 
                if ($square[0]->cart[0]->closed) {
                    echo '"background-color: rgb(136 233 233); color: black; text-align: center;"';
                } else {
                    echo '"background-color: rgb(255, 222, 222); color: black; text-align: center;"';
                };
            ?>>
            <span class="text-center">SESIÓN {{$square[0]->id}}</span>
            <div class="font-small-2">{{$square[0]->created_at}}</div>
        </div>
        <div class="col-md-2 float-right pb-1 pt-0"
            style=<?php 
                if ($square[0]->cart[0]->closed) {
                    echo '"background-color: rgb(136 233 233); color: black; text-align: center;"';
                } else {
                    echo '"background-color: rgb(255, 222, 222); color: black; text-align: center;"';
                };
            ?>>
            <p class="font-large-4">{{$cashbox_id}}</p></div>
        <div class="col-md-3" style="font-family: sans-serif; font-size: xx-large; ">CAJA</div>
    </div>

    <!--DATA DEL CIERRE DE CAJA-->
    <div class="card-content" style="background-color: rgb(242, 244, 244);">
        <div class="card-body d-flex align-items-between flex-wrap p-0 mt-2">
            @foreach($payment_types as $payment_type)
                @if($data[$payment_type->id]->count())

                    <!--CONTAINER TIPO DE PAGO-->
                    <div class="col-12 mt-1 mb-1 p-0 shadow-md" align="center" style="
                        <?php if($payment_type->cashbox_in==1) 
                            { echo 'background-color: rgba(223, 236, 255, 1.0)';}
                        else 
                            {echo 'background-color: rgba(255, 239, 239, 1.0)';} 
                        ?>
                    ">

                        <!--HEADER DEL TIPO DE PAGO-->
                        <div class="card-header p-1 " style="
                            <?php if($payment_type->cashbox_in==1)
                                { echo 'background-color: rgba(210, 228, 255, 1.0)';} 
                            else 
                                {echo 'background-color: rgba(255, 223, 223, 1.0)';} 
                            ?>
                        ">
                            <h5>{{$payment_type->type}}</h4>
                        </div>

                        <!--DATA DEL TIPO DE PAGO-->
                        <div class="row m-0">
                            @foreach($data[$payment_type->id] as $item) <!--DATOS-->

                                <!--CONTAINER DE LA FACTURA-->
                                <div class="badge col-xl-2 col-lg-2 col-md-3 col-sm-6 col-xs-12 bg-white pt-1 m-1" style="color: black;">
                                    <span class="badge badge-circle badge-circle-md badge-up" style="font-size: small;
                                    <?php if($payment_type->cashbox_in==1)
                                        { echo 'background-color: rgb(86 152 227)';}
                                    else 
                                        {echo 'background-color: rgb(181, 126, 126)';}
                                    ?>
                                    ">{{$item->id}}</span>

                                    <!--DATA DE LA FACTURA-->
                                    <div style="font-size: x-small;"> 
                                        <div class="row">
                                            <div class="pl-1 pr-1">
                                                MONTO {!! localMoneyFormat($item->amount) !!}
                                            </div>
                                            <div class="pl-1 pr-1">
                                                IMPUESTO {!! localMoneyFormat($item->tax) !!}
                                            </div>
                                            <div class="pl-1 pr-1">
                                                @if($boolean_tax_included)
                                                    SUBTOTAL {!! localMoneyFormat($item->amount) !!}
                                                @else
                                                    SUBTOTAL {!! localMoneyFormat($item->amount + $item->tax) !!}
                                                @endif
                                            </div>
                                        </div>
                                        <div class="row pt-1 ml-0 mr-auto">
                                            <div class="badge-circle badge-circle-light-primary badge-circle-md">
                                                <a href="{{ Route('cashbox.data-invoice', $item->id) }}">
                                                    <i class="livicon-evo" data-options="name: box.svg; style: solid; size: 25px; solidColor: #5A8DEE;"></i>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <!--FOOTER DEL TIPO DE PAGO-->
                        <div class="row card-footer m-0" style="text-align: center; 
                            <?php if($payment_type->cashbox_in==1)
                                { echo 'background-color: rgb(86 152 227)';} 
                            else 
                                {echo 'background-color: rgba(181, 126, 126, 1.0)';} 
                            ?>
                        ">
                            <div class="col-4">
                                <h6 style="color: whitesmoke;">
                                    MONTO {!! localMoneyFormat($data[$payment_type->id]->sum('amount')) !!}
                                </h6>
                            </div>
                            <div class="col-4">
                                <h6 style="color: whitesmoke;">
                                    IMPUESTO {!! localMoneyFormat($data[$payment_type->id]->sum('tax')) !!}
                                </h6>
                            </div>
                            <div class="col-4">
                                <h6 style="color: whitesmoke;">
                                    @if($boolean_tax_included)
                                        SUBTOTAL {!! localMoneyFormat($data[$payment_type->id]->sum('amount')) !!}
                                     @else
                                        SUBTOTAL {!! localMoneyFormat($data[$payment_type->id]->sum('amount') + $data[$payment_type->id]->sum('tax')) !!}
                                    @endif
                                </h6>
                            </div>
                        </div>
                    </div>
                @endif
            @endforeach        
        </div>

        <!--FOOTER DEL CIERRE DE CAJA-->
        <div class="card-footer d-flex justify-content-between  mt-3" style="background-color: rgba(83, 124, 173, 1.0);">
            <div class="col-md-8 float-right p-1 ml-auto" style="color: whitesmoke;">
                <div class="p-1" style="font-size: large; text-align: right;">
                    MONTO  {!! localMoneyFormat($total_monto) !!}
                </div>
                <div class="p-1" style="font-size: large; text-align: right;">
                    IMPUESTOS {!! localMoneyFormat($total_impuestos) !!}</div>
                <div class="p-1" style="font-size: large; text-align: right;">
                    @if($boolean_tax_included)
                        CIERRE {!! localMoneyFormat($total_cierre) !!}</div>
                    @else
                        CIERRE {!! localMoneyFormat($total_cierre+$total_impuestos) !!}</div>
                    @endif
                </div>
            </div>
        </div>

    </div>
</div>
@endsection