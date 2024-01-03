@extends('forestLayout')
@section('content')
    @include('models/slices/cart_product_search')
    <section id="decks">
        <div class="row match-height">
            <div class="col-12">
                <div class="card-deck-wrapper">
                    <div class="card-deck">
                        <div class="row no-gutters">
                            @foreach ($services as $service)
                                <div
                                    class="@php if ($services->count() == 1 ) { echo 'col-md-4 col-sm-6 mb-sm-1 width-800'; } 
                    elseif ($services->count()==2) { echo 'col-md-3 col-sm-6 width-500'; } 
                    elseif ($services->count()>=3) { echo 'col-md-3 col-sm-6 col-lg-2'; } @endphp">
                                    <div class="card height-490 mb-3">
                                        <div class="card-content">
                                            <form method="POST"
                                                action="{{ Route('cart.product-store', ['client_id' => $client->id, 'service_id' => $service->id]) }}">
                                                @csrf

                                                <!-- Inventario -->
                                                <span
                                                    class="badge badge-circle badge-circle-lg badge-circle-quantity badge-up">
                                                    @if (!$service->stock)
                                                        0
                                                    @else
                                                        {{ $service->stock->stock_quantity }}
                                                    @endif
                                                </span>

                                                <!-- Imagen -->
                                                @if (Storage::exists($service->pic))
                                                    <img class="card-img-top img-fluid"
                                                        src="{{ Storage::url($service->pic) }}"
                                                        alt="Imagen del producto/servicio" />
                                                @else
                                                    @if ($service->service_type_id == 2)
                                                        <img class="card-img-top img-fluid"
                                                            src="{{ asset('/img/servicio.png') }}"
                                                            alt="Imagen del servicio" />
                                                    @elseif ($service->service_type_id == 3)
                                                        <img class="card-img-top img-fluid"
                                                            src="{{ asset('/img/servicio.png') }}"
                                                            alt="Imagen del servicio" />
                                                    @elseif ($service->service_type_id == 4)
                                                        <img class="card-img-top img-fluid"
                                                            src="{{ asset('/img/producto.png') }}"
                                                            alt="Imagen del producto" />
                                                    @endif
                                                @endif

                                                <!-- ITEM ID -->
                                                <div class="col-12 text-left"
                                                    style="background-color: #ff960c42; padding-left:4%; font-size:0.70rem">
                                                    @if ($service->updated_at !== null)
                                                        <p class="text-left text-truncate">
                                                            PRODUCTO # {{ $service->id }}
                                                            {{ $service->updated_at->diffForHumans() }}
                                                        </p>
                                                    @else
                                                        <p class="text-left text-truncate">ITEM-ID: {{ $service->id }}</p>
                                                    @endif
                                                </div>

                                                <div class="card-body" style="padding: 5%">

                                                    <!-- Precio -->
                                                    <p class="card-text text-center text-wrap" style="font-weight: 700;">
                                                        {!! localMoneyFormat($service->charge) !!}
                                                    </p>

                                                    <!-- Producto -->
                                                    <p class="card-text text-height-3">
                                                        {{ $service->service }}
                                                    </p>

                                                    <!-- Detalle -->
                                                    <textarea data-length=255 class="form-control" id="basicTextarea" rows="3" placeholder="@lang('Requisition detail')"
                                                        name="supply_detail" style="resize: none; padding:3%; font-size:0.9rem; margin-bottom: 0.7em"></textarea>

                                                    <!-- Unidades -->
                                                    <input type="number"
                                                        class="touchspin-color touchspin-min-max form-control"
                                                        name="supply_quantity" value="1">

                                                </div>

                                                <!-- Tablero -->
                                                <div class="card-footer d-flex justify-content-center m-0 p-1">
                                                    {!! ProductsControlPanel() !!}
                                                </div>

                                            </form>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    {{ $services->appends(request()->input())->links() }}
                </div>
            </div>
        </div>
    </section>
@endsection

@section('catalog-switch')
    <a class="nav-link"
        href="{{ Route('cart.catalog-switch', ['client' => $client, 'target_root' => request()->route()->action['as']]) }}"
        data-toggle="tooltip" data-placement="top" title="Cambiar entre catálogos">
        <div class="livicon-evo"
            data-options=" name: swap-horizontal.svg; style: solid; size: 2.8rem; solidColor: #ffc13a; solidColorAction: #dff30c; colorsOnHover: custom; keepStrokeWidthOnResize: true ">
        </div>
    </a>
@endsection

@section('orden')
    @if (isset($cart))
        <a class="nav-link" href="{{ route('cart.check', ['client' => $client, 'cart' => $cart]) }}">
            <div class="livicon-evo"
                data-options=" name: shoppingcart-in.svg; style: solid; size: 3.5rem; solidColor: #ffc13a; solidColorAction: #dff30c; colorsOnHover: custom; keepStrokeWidthOnResize: true ">
            </div>
        </a>
    @endif
@endsection

@section('cliente')
    {!! ClientControlPanel($client->name) !!}
@endsection
