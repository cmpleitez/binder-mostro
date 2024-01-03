@extends('forestLayout')
@section('content')
<section id="decks">
    
    <div class="row match-height">
        <div class="col-12">
            <div class="card-deck-wrapper">
                <div class="card-deck">
                    <div class="row no-gutters">
                        @foreach ( $orders as $item )
                            <div
                                class="@php if ($orders->count() == 1 ) { echo 'col-md-4 col-sm-6 mb-sm-1 width-800'; } 
                elseif ($orders->count()==2) { echo 'col-md-3 col-sm-6 width-500'; } 
                elseif ($orders->count()>=3) { echo 'col-md-3 col-sm-6'; } @endphp">
                                <div class="card height-490 mt-3">
                                    <div class="card-content">
                                        <form method="POST" action="{{ Route('cart.product-update', ['supply_id'=>$item->id]) }}">
                                            @csrf

                                            <!-- Unidades -->
                                            <span
                                                class="badge badge-circle badge-circle-lg badge-circle-quantity badge-up">
                                                {{ $item->supply_quantity }}
                                            </span>

                                            <!-- Imagen -->
                                            @if ( Storage::exists( $item->service->pic ) )
                                                <img class="card-img-top img-fluid" src="{{Storage::url($item->service->pic)}}" alt="Imagen del item" />
                                            @else
                                                <img class="card-img-top img-fluid" src="{{ asset('/img/producto.png') }}" alt="Imagen del item" />
                                            @endif

                                            <!-- ITEM ID -->
                                            <div class="col-12 text-left"
                                                style="background-color: #ff960c42; padding-left:4%; font-size:0.70rem">
                                                @if ($item->updated_at !== null)
                                                    <p class="text-left text-truncate">ITEM # {{$item->id}}, {{$item->updated_at->diffForHumans()}}</p>
                                                @else
                                                    <p class="text-left text-truncate">ITEM # {{$item->id}}</p>
                                                @endif
                                            </div>

                                            <div class="card-body" style="padding: 5%">

                                                <!-- Precio -->
                                                <p class="card-text text-center text-wrap" style="font-weight: 700;">
                                                    {!! localMoneyFormat($item->supply_charge) !!}
                                                </p>

                                                <!-- Producto -->
                                                <p class="card-text text-height-3">
                                                    {{$item->service->service}}
                                                </p>

                                                <!-- Detalle -->
                                                @if ($item->offer_id !== 1)
                                                    <textarea data-length=255 class="form-control" id="basicTextarea" rows="3" placeholder="@lang('Requisition detail')"
                                                        name="supply_detail" style="resize: none; padding:3%; font-size:0.9rem; margin-bottom: 0.7em">{{old( 'supply_detail', $item->supply_detail )}}</textarea>
                                                @endif

                                                <!-- Unidades -->
                                                @if ($item->offer_id !== 1)
                                                    <input type="number" class="touchspin-color touchspin-min-max form-control" name="supply_quantity" value="{{old( 'supply_quantity', $item->supply_quantity )}}">
                                                @endif
                                            </div>

                                            <div class="card-footer d-flex justify-content-between m-0 p-1">
                                                @if($item->offer_id==1)
                                                    <div class="tablero-iconos">
                                                        <button type="submit" class="badge-circle  badge-circle-lg bg-primary bg-lighten-1 bx bxs-save font-large-1 border-0"></button>
                                                    </div>
                                                    <div class="tablero-iconos">
                                                        <a href="{{Route( 'cart.product-undo', ['client_id'=>$client_id, 'cart_id' => $item->cart_id, 'requisition_id' =>$item->id] )}}" class="badge-circle badge-circle-light-warning badge-circle-lg bx bx-x font-large-1"></a>
                                                    </div>
                                                @endif
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
@endsection


