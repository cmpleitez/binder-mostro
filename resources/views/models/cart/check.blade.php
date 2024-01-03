@extends('forestLayout')
@section('content')
    <section id="decks">
        <div class="row match-height">
            <div class="col-12">
                <div class="card-deck-wrapper">
                    <div class="card-deck">
                        <div class="row no-gutters">
                            @foreach ($orders as $key => $order)
                                <div
                                    class="@php if ($orders->count() == 1 ) { echo 'col-md-4 col-sm-6 mb-sm-1 width-800'; } 
                    elseif ($orders->count()==2) { echo 'col-md-3 col-sm-6 width-500'; } 
                    elseif ($orders->count()>=3) { echo 'col-md-3 col-sm-6'; } @endphp">
                                    <div class="card height-490 mt-3 d-flex justify-content-end ">
                                        <div class="card-content">
                                            <form method="POST"
                                                action="{{ Route('cart.offer-update', ['cart_id' => $cart->id, 'order_id' => $order->id]) }}">
                                                @csrf

                                                <!-- Inventario -->
                                                @if ($order->offer_id !== 1)
                                                    <span
                                                        class="badge badge-circle badge-circle-lg badge-circle-quantity badge-up">
                                                        @if ($order->id == 1)
                                                            1
                                                        @else
                                                            {{ $order->order_quantity }}
                                                        @endif
                                                    </span>
                                                @endif

                                                <!-- Imagen -->
                                                <a
                                                    href="{{ Route('cart.offer-check', ['cart_id' => $cart->id, 'offer_id' => $order->id]) }}">

                                                    @if (Storage::url($order->pic) !== '/storage/')
                                                        <img class="card-img-top img-fluid"
                                                            src="{{ Storage::url($order->pic) }}"
                                                            alt="Imagen de la oferta" />
                                                    @else
                                                        <img class="card-img-top img-fluid"
                                                            src="{{ asset('/img/producto.png') }}"
                                                            alt="Imagen de la oferta" />
                                                    @endif
                                                </a>

                                                <!-- ORDER ID -->
                                                <div class="col-12 text-left"
                                                    style="background-color: #ff960c42; padding-left:4%; font-size:0.70rem">
                                                    @if ($order->updated_at !== null)
                                                        <p class="text-left text-truncate">ORDER # {{ $order->id }},
                                                            {{ $order->updated_at->diffForHumans() }}</p>
                                                    @else
                                                        <p class="text-left text-truncate">ORDER # {{ $order->id }}</p>
                                                    @endif
                                                </div>

                                                <div class="card-body" style="padding: 5%">

                                                    <!-- Precio -->
                                                    <p class="card-text text-center text-wrap" style="font-weight: 700;">
                                                        {!! localMoneyFormat($order->charge) !!}
                                                    </p>

                                                    <!-- Producto -->
                                                    <p class="card-text text-height-3">
                                                        {{ $order->offer }}
                                                    </p>

                                                    <!-- Detalle -->
                                                    @if ($order->offer_id !== 1)
                                                        <textarea data-length=255 class="form-control" id="basicTextarea" rows="3" placeholder="@lang('Requisition detail')"
                                                            name="supply_detail" style="resize: none; padding:3%; font-size:0.9rem; margin-bottom: 0.7em">{{ old('supply_detail', $order->supply_detail) }}</textarea>
                                                    @endif

                                                    <!-- Cantidad -->
                                                    @if ($order->offer_id !== 1)
                                                        <input type="number"
                                                            class="touchspin-color touchspin-min-max form-control"
                                                            name="order_quantity"
                                                            value="{{ old('order_quantity', $order->order_quantity) }}">
                                                    @endif
                                                </div>

                                                <div class="card-footer d-flex justify-content-between m-0 p-1">
                                                    @if ($order->offer_id !== 1)
                                                        <div class="tablero-iconos">
                                                            <button type="submit"
                                                                class="badge-circle bg-primary bg-lighten-1 badge-circle-lg bx bxs-save border-0 font-large-1"></button>
                                                        </div>
                                                    @endif
                                                    <div class="tablero-iconos">
                                                        <a href="{{ Route('cart.offer-check', ['cart_id' => $cart->id, 'offer_id' => $order->id]) }}"
                                                            class="badge-circle  badge-circle-lg bg-primary bg-lighten-1 bx bxs-collection font-large-1"></a>
                                                    </div>
                                                    <div class="tablero-iconos">
                                                        <a href="{{ Route('cart.offer-undo', ['client_id' => $client->id, 'cart_id' => $cart->id, 'order_id' => $order->id]) }}"
                                                            class="badge-circle badge-circle-light-warning badge-circle-lg bx bx-x font-large-1"></a>
                                                    </div>
                                                </div>

                                            </form>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Botones de correo y compra -->
    <div class="card mt-1">
        {{-- <div class="float-left">ORDEN # {{ $cart->id }}</div> --}}
        <div class="card-body d-flex justify-content-end p-1">
            {{-- @include('models.slices.offer_email')  --}}
            {!! cartCheckControlPanel($client, $cart) !!}
            <a href="{{ Route('cart.purchase', $cart) }}" class="btn btn-light-primary ml-1">
                <i class="bx bxs-dollar-circle"></i>
                @lang('Purchase')
            </a>
        </div>
    </div>
@endsection

@section('total')
    <li class="nav-item my-auto pr-1" style="color:rgb(255,255,255) !important;">TOTAL {!! localMoneyFormat($orders_total) !!}</li>
@endsection
