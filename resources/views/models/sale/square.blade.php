@extends('forestLayout')
@section('content')
<div class="card">

    <!--BEGIN: HEADER DEL CIERRE DE CAJA-->
    <div class="card-header pt-2 pb-3 pr-0 pl-0" align="center">
        <div class="col-md-2 float-left pb-1 text-bold-500"
            style="background-color: rgb(255, 222, 222); color: black; text-align: center;">
            <span class="text-center">SESIÓN {{$square->id}}</span>
            <div class="font-small-2">{{$square->created_at}}</div>
        </div>
        <div class="col-md-2 float-right pb-1 pt-0"
            style="background-color: rgb(255, 222, 222); color: black; text-align: center;">
            <p class="font-large-4">{{$cashbox_id}}</p></div>
        <div class="col-md-3 font-medium-5" style="font-family: sans-serif; ">CAJA</div>
    </div>
    <!--END: HEADER DEL CIERRE DE CAJA-->

    <!--BEGIN: CUERPO DEL CIERRE DE CAJA-->
    <div class="card-content" style="background-color: rgb(242, 244, 244);">
        <div class="card-body d-flex align-items-between flex-wrap p-0 mt-2">
            @foreach($payment_types as $payment_type)
                @if($data[$payment_type->id]->count())

                    <!--BEGIN: CONTAINER TIPO DE PAGO-->
                    <div class="col-12 mt-1 mb-1 p-0 shadow-md" align="center" style="
                        <?php if($payment_type->cashbox_in==1) 
                            { echo 'background-color: rgba(223, 236, 255, 1.0)';}
                        else 
                            {echo 'background-color: rgba(255, 239, 239, 1.0)';} 
                        ?>
                    ">

                        <!--BEGIN: HEADER DEL TIPO DE PAGO-->
                        <div class="card-header p-1 " style="
                            <?php if($payment_type->cashbox_in==1)
                                { echo 'background-color: rgba(210, 228, 255, 1.0)';} 
                            else 
                                {echo 'background-color: rgba(255, 223, 223, 1.0)';} 
                            ?>
                        ">
                            <h5>{{$payment_type->type}}</h4>
                        </div>
                        <!--END: HEADER DEL TIPO DE PAGO-->

                        <!--BEGIN: CUERPO DEL TIPO DE PAGO-->
                        <div class="row m-0">
                            @foreach($data[$payment_type->id] as $item) <!--DATOS-->
                                <!--CONTAINER DE LA ORDEN-->
                                <div class="badge col-xl-2 col-lg-2 col-md-3 col-sm-6 col-xs-12 bg-white pt-1 m-1" style="color: black;">
                                    <span class="badge badge-circle badge-circle-md badge-up" style="font-size: small;
                                    <?php if($payment_type->cashbox_in==1)
                                        { echo 'background-color: rgb(86 152 227)';} 
                                    else 
                                        {echo 'background-color: rgb(181, 126, 126)';} 
                                    ?>
                                    ">{{$item->id}}</span>

                                    <!--DATA DE LA ORDEN-->
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
                                        <div class="row ml-0 mr-auto">
                                            {!! invoicedControlPanel( $item->id ) !!}
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <!--END: CUERPO DEL TIPO DE PAGO-->

                        <!--BEGIN: FOOTER DEL TIPO DE PAGO-->
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
                        <!--END: FOOTER DEL TIPO DE PAGO-->

                    </div>
                    <!--END: CONTAINER TIPO DE PAGO-->
                @endif
            @endforeach
        </div>

        <!--BEGIN: FOOTER DEL CIERRE DE CAJA-->
        <div class="card-footer d-flex justify-content-between  mt-3" style="background-color: rgba(83, 124, 173, 1.0);">
            <div class="col-md-4 float-left" style="color: whitesmoke;">
                <form method="POST" action="{{Route('cashbox.close')}}">
                    @csrf @method('PATCH')
                    <fieldset class="form-group">
                        <input type="password" class="form-control" id="basicInput" placeholder="clave de autorización" name="clave" value="{{ old('clave') }}">
                        <span class="badge badge-light-danger">{{ $errors->first('clave') }}</span>
                    </fieldset>
                    <fieldset class="form-group">
                        <button type="submit" class="btn btn-light-warning">Cerrar caja</button>
                    </fieldset>
                </form>
            </div>
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
        <!--END: FOOTER DEL CIERRE DE CAJA-->
    </div>
    <!--END: CUERPO DEL CIERRE DE CAJA-->
</div>

<!-- BEGIN: Sweet Alert JS functions Customization-->
<script type="text/javascript">
    function confirmar( $ruta ){
        Swal.fire({
          title: 'Con seguridad decides anular la factura ?',
          text: "Recuerda que debes anular además la factura de papel para mantener la coherencia de la información, éste proceso es irreversible !",
          type: 'question',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Si, anular la factura!',
          confirmButtonClass: 'btn btn-danger',
          cancelButtonClass: 'btn btn-success ml-1',
          buttonsStyling: false,
        }).then(function (result) {
          if (result.value) {
            window.location.replace( $ruta );
          }
          else if (result.dismiss === Swal.DismissReason.cancel) {
            Swal.fire({
              title: 'Accción detenida',
              text: 'La factura está a salvo',
              type: 'success',
              confirmButtonClass: 'btn btn-success',
            })
          }
        })
    }
</script>
<!-- END: Sweet Alert JS-->
@endsection