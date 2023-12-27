@extends('forestLayout')
@section('content')
<section class="invoice-view-wrapper">
    <div class="row">
        <!-- invoice view page -->
        <div class="col-xl-9 col-md-8 col-12">
            <div class="card">
                <div class="card-content">
                    <div class="card-body pb-0 mx-25">
                        <!-- header section -->
                        <div class="row">
                            <div class="col-xl-4 col-md-12">
                                <small class="invoice-number mr-50 text-muted">System ID {{$order['order_id']}}</small>
                            </div>
                            <div class="col-xl-8 col-md-12">
                                <div class="d-flex align-items-center justify-content-xl-end flex-wrap">
                                    <div>
                                        <small class="text-muted">Fecha de creación: {{$order['created_at']}}</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- logo and title -->
                        <div class="row my-3">
                            <div class="col-6">
                                <h4 class="text-primary">Factura</h4>
                                <span>Binder App</span>
                            </div>
                            <div class="col-6 d-flex justify-content-end">
                                <img src="../../../app-assets/images/logo/logoWh.png" alt="logo" height="50" width=auto>
                            </div>
                        </div>
                        <hr>
                        <!-- invoice address and contact -->
                        <div class="row invoice-info">
                            <div class="col-6 mt-1">
                                <div class="mb-1">
                                    <span>CLIENTE: {{$order['name']}}</span>
                                </div>
                                <div class="mb-1">
                                    <span>EMAIL: {{$order['email']}}</span>
                                </div>
                                <div class="mb-1">
                                    <span>TELÉFONO: {{$order['phone_number']}}</span>
                                </div>
                            </div>
                            <div class="col-6 mt-1 text-right">
                                <div class="mb-1">
                                    <span>NIT: {{$order['nit']}}</span>
                                </div>
                                <div class="mb-1">
                                    <span>NRC: {{$order['nrc']}}</span>
                                </div>
                                <div class="mb-1">
                                    <span>DUI: {{$order['dui']}}</span>
                                </div>
                            </div>
                        </div>
                        <hr>
                    </div>
                    <!-- product details table-->
                    <div class="invoice-product-details table-responsive mx-md-25">
                        <table class="table table-borderless mb-0">
                            <thead>
                                <tr class="border-0 text-center">
                                    <th scope="col">ID</th>
                                    <th scope="col">UNIDADES</th>
                                    <th scope="col" class="text-left">ITEM</th>
                                    <th scope="col">PRECIO</th>
                                    <th scope="col" class="text-right">VALOR</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!--PRODUCTS-->
                                @if( isset($product_items) )
                                    @foreach ($product_items as  $product_item)
                                        <tr>
                                            <td class="text-center">{{$product_item['item_id']}}</td>
                                            <td class="text-center">{{$product_item['quantity']}}</td>
                                            <td>{{$product_item['request']}}</td>
                                            <td class="text-center">{!! localMoneyFormat($product_item['charge']) !!}</td>
                                            <td class="text-primary text-right font-weight-bold">{{$product_item['value']}}</td>
                                        </tr>
                                    @endforeach
                                @endif

                                <!--OFFERS-->
                                @if( isset($offer_items) )
                                      @foreach( $offer_items as $offer_item )
                                          <tr>
                                              <td class="text-center">{{$offer_item->id}}</td>
                                              <td class="text-center">{{$offer_item->quantity}}</td>
                                              <td>{{$offer_item->request}}</td>
                                              <td class="text-center">{!! localMoneyFormat($offer_item->charge) !!}</td>
                                              <td class="text-primary text-right font-weight-bold">{!! localMoneyFormat($offer_item->value) !!}</td>
                                          </tr>
                                      @endforeach
                                @endif
                            </tbody>
                        </table>
                    </div>

                    <!-- invoice subtotal -->
                    <div class="card-body pt-0 mx-25">
                        <hr>
                        <div class="row">
                            <div class="col-4 col-sm-6 mt-75">
                                <p>Thanks for your business.</p>
                            </div>
                            <div class="col-8 col-sm-6 d-flex justify-content-end mt-75">
                                <div class="invoice-subtotal">
                                    <div class="invoice-calc d-flex justify-content-between">
                                        <span class="invoice-title">Subtotal</span>
                                        <span class="invoice-value">{{ $order['amount'] }}</span>
                                    </div>
                                    <div class="invoice-calc d-flex justify-content-between">
                                        <span class="invoice-title">Descuento</span>
                                        <span class="invoice-value">- $ 09.60</span>
                                    </div>
                                    <div class="invoice-calc d-flex justify-content-between">
                                        <span class="invoice-title">Tax</span>
                                        <span class="invoice-value">13%</span>
                                    </div>
                                    <hr>
                                    <div class="invoice-calc d-flex justify-content-between">
                                        <span class="invoice-title">Total (USD)</span>
                                        <span class="invoice-value">{{ $order['amount'] }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-4 col-12">
            <div class="card invoice-action-wrapper shadow">
                <div class="card-body">
                    {!! dataInvoiceControlPanel( $cart->id ) !!}
                </div>
            </div>
        </div>
    </div>
</section>
@endsection