@extends('forestLayout')
@section('content')
<div class="card shadow-sm">
    <div class="card-header badge-circle-light-primary">
        <div class="card-group float-left col-md-8">
            <div class="col-md-12  text-uppercase">ORDEN</div>
        </div>
        <div class="card-group float-right col-md-4">
            @include('models/slices/invoice_search')
        </div>
    </div>
    <div class="card-content">
        <div class="card-body">
            <!--BEGIN: Formulario -->
            <form method="POST" action="{{ Route('sale.pdf-invoice', ['cart_id' => $cart->id ]) }}">
                @csrf
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead>
                            <tr class="text-center">
                                <th>@lang("SELECCIÓN")</th>
                                <th>@lang("ORDEN/ITEM")</th>
                                <th>@lang("TAREA")</th>
                                <th>@lang("UNIDADES")</th>
                                <th>PRECIO</th>
                                <th>@lang("MONTO")</th>
                                <th>@lang("CLIENTE")</th>
                                <th>@lang("TIPO")</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($items as $item)
                                <tr>
                                    <td class="text-center col-1">
                                        <div class="checkbox checkbox-light-primary checkbox-glow">
                                            @if ( $item->selected )
                                                <input type="checkbox" id="{{'checkboxGlow'}}{{$item->id}}"
                                                name = "item[]" value = " {{$item->id}} " checked>
                                            @else
                                                <input type="checkbox" id="{{'checkboxGlow'}}{{$item->id}}"
                                                name = "item[]" value = " {{$item->id}}" >
                                            @endif
                                            <label for="{{'checkboxGlow'}}{{$item->id}}"></label>
                                        </div>
                                    </td>
                                    <td class="text-center col-1">
                                        <div class="row badge badge-pill badge-light-primary">{{$item->cart_id}} / {{$item->id}}</div>
                                    </td>
                                    <td class="text-bold-500 text-center col-3">
                                        {{$item->service->service}}: <small class="text-muted">{{$item->supply_detail}}</small>
                                        <p class="" style="color: orange;">{{$item->offer->offer}}</p>
                                    </td>

                                    <td class="text-center col-1">
                                        {{$item->supply_quantity}}
                                    </td>

                                    <td class="text-center col-1">
                                        {{ localMoneyFormat($item->requisition_charge) }}
                                    </td>

                                    <td class="text-bold-500 text-center col-1">
                                        <span class="">{{ localMoneyFormat($item->requisition_amount) }}</span>
                                    </td>
                                    <td class="text-center col-2">
                                        <span class="invoice-customer">{{$item->cart->client->name}} </span>
                                        <p><small class="text-muted ">{{$item->created_at}}</small></p>
                                    </td>
                                    <td class="text-center col-2">
                                        @if ($item->service->service_type_id == 1)
                                            <span class="bullet bullet-danger bullet-sm"></span>
                                        @elseif($item->service->service_type_id==2)
                                            <span class="bullet bullet-warning bullet-sm"></span>
                                        @elseif($item->service->service_type_id==3)
                                            <span class="bullet bullet-success bullet-sm"></span>
                                        @elseif($item->service->service_type_id==4)
                                            <span class="bullet bullet-info bullet-sm"></span>
                                        @endif
                                        <small class="text-muted">{{$item->service->service_type->type}}</small>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <hr>

                <!--BEGIN: Tablero -->
                <div class="row ml-1 mr-1 mt-3">
                    <div class="card-group float-left col-md-8">
                        <ul class="list-unstyled mb-0">
                            @foreach($payment_types as $payment_type)
                                <li class="d-inline-block mr-2 mb-1">
                                    <fieldset>
                                        @if($payment_type->cashbox_in==1)
                                            <div class="radio radio-primary radio-glow">
                                                <input type="radio" id="{{$payment_type->id}}" name="payment_type_id" value="{{$payment_type->id}}"
                                                <?php if($payment_type->id==1) {
                                                    echo 'checked';
                                                }?>>
                                                <label for="{{$payment_type->id}}">{{$payment_type->type}}</label>
                                            </div>
                                        @else
                                            <div class="radio radio-warning radio-glow">
                                                <input type="radio" id="{{$payment_type->id}}" name="payment_type_id" value="{{$payment_type->id}}">
                                                <label for="{{$payment_type->id}}">{{$payment_type->type}}</label>
                                            </div>
                                        @endif
                                    </fieldset>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                    <div class="card-group float-left col-md-4 d-flex align-items-end">
                        <div class="row">
                            <div class="col-12">
                                <button type="submit" class="btn btn-outline-warning round">Vista previa</button>
                            </div>
                        </div>
                    </div>
                </div>
                <!--END: Tablero -->
            </form>
            <!--END: Formulario -->
        </div>
    </div>
    <div class="card-footer">
    </div>
</div>
@endsection