@extends('forestLayout')
@section('content')
    <section id="decks">
        <div class="row match-height">
            <div class="col-12">
                <div class="font-medium-3 font-weight-bold mb-2">OFERTAS</div>
                <div class="card-deck-wrapper">
                    <div class="card-deck">
                        <div class="row no-gutters">
                            @foreach ($offers as $key => $offer)
                                <div
                                    class="@php if ($offers->count() == 1 ) { echo 'col-md-4 col-sm-6 mb-sm-1 width-800'; } 
                                elseif ($offers->count()==2) { echo 'col-md-3 col-sm-6 width-500'; } 
                                elseif ($offers->count()>=3) { echo 'col-md-3 col-sm-6 col-lg-2'; } @endphp">
                                    <div class="card height-490 mb-3">
                                        <div class="card-content">
                                            <form method="POST"
                                                action="{{ Route('cart.offer-store', ['client_id' => $client->id, 'offer_id' => $offer->id]) }}">
                                                @csrf

                                                <!-- Imagen -->
                                                @if (Storage::exists($offer->pic))
                                                    <img class="card-img-top img-fluid"
                                                        src="{{ Storage::url($offer->pic) }}" alt="Imagen de la oferta" />
                                                @else
                                                    <img class="card-img-top img-fluid"
                                                        src="{{ asset('/img/producto.png') }}" alt="Imagen de la oferta" />
                                                @endif

                                                <!-- OFFER ID -->
                                                <div class="col-12 text-left"
                                                    style="background-color: #ff960c42; padding-left:4%; font-size:0.70rem">
                                                    @if ($offer->updated_at !== null)
                                                        <p class="text-left text-truncate">OFFERTA # {{ $offer->id }},
                                                            {{ $offer->updated_at->diffForHumans() }}</p>
                                                    @else
                                                        <p class="text-left text-truncate">OFERTA # {{ $offer->id }}</p>
                                                    @endif
                                                </div>

                                                <div class="card-body" style="padding: 5%">

                                                    <!-- Precio -->
                                                    <p class="card-text text-center text-wrap" style="font-weight: 700;">
                                                        {!! localMoneyFormat($offer->charge) !!}
                                                    </p>

                                                    <!-- Oferta -->
                                                    <p class="card-text text-height-3">
                                                        {{ $offer->offer }}
                                                    </p>

                                                    <!-- Detalle -->
                                                    @if ($offer->offer_id !== 1)
                                                        <textarea data-length=255 class="form-control" id="basicTextarea" rows="3" placeholder="@lang('Requisition detail')"
                                                            name="supply_detail" style="resize: none; padding:3%; font-size:0.9rem; margin-bottom: 0.7em">{{ old('supply_detail', $offer->supply_detail) }}</textarea>
                                                    @endif

                                                    <!-- Cantidad -->
                                                    @if ($offer->offer_id !== 1)
                                                        <input type="number"
                                                            class="touchspin-color touchspin-min-max form-control"
                                                            name="supply_quantity" value="1"
                                                            value="{{ old('supply_quantity', $offer->supply_quantity) }}">
                                                    @endif
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

                    {{-- paginacion --}}
                    {{ $offers->appends(request()->input())->links() }}

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
