@extends('forestLayout')
@section('content')

@include('models/slices/supplying_product_search')
<div class="row match-height">
    <div class="col-12">
        <div class="card-deck-wrapper">
            <div class="card-deck">
                <div class="row no-gutters">
                    @foreach ( $services as $service )
                        <div class="<?php
                                switch ($services->count()) {
                                  case 1:
                                    echo 'col-lg-8 col-md-4 col-sm-6';
                                    break;
                                  case 2:
                                    echo 'col-lg-4 col-md-4 col-sm-6';
                                    break;
                                  case 3:
                                    echo 'col-lg-3 col-md-4 col-sm-6';
                                    break;
                                  default :
                                    echo 'col-lg-2 col-md-4 col-sm-6';
                                }
                        ?> mb-2">
                        <div class="card">
                            <form method="POST" action="{{ Route('cart.stock-supply', $service) }}">
                                <div class="card-content">
                                    @csrf
                                    @if ( Storage::exists( $service->pic ) )
                                        <img class="card-img-top img-fluid" src="{{Storage::url($service->pic)}}" alt="Imagen del producto/servicio" />
                                    @else
                                        @if( $service->service_type_id == 2 )
                                            <img class="card-img-top img-fluid" src="{{ asset('/img/servicio.png') }}" alt="Imagen del producto/servicio" />
                                        @elseif ( $service->service_type_id == 3 )
                                            <img class="card-img-top img-fluid" src="{{ asset('/img/servicio.png') }}" alt="Imagen del producto/servicio" />
                                        @elseif ( $service->service_type_id == 4 )
                                            <img class="card-img-top img-fluid" src="{{ asset('/img/producto.png') }}" alt="Imagen del producto/servicio" />
                                        @endif
                                    @endif
                                    <!-- Charge -->
                                    <div class="col-12  text-center">{!! localMoneyFormat($service->charge) !!}</div>
                                    <!-- Service -->
                                    <div class="col-12 text-height-3  d-flex text-justify text-wrap text-truncate">
                                        {{ $service->service }}
                                    </div>
                                    <!-- Quantity -->
                                    <div class="col-12 ">
                                        <input type="number" class="touchspin-color touchspin-min-max form-control" name="supply_quantity" value="{{old('supply_quantity', 1)}}">
                                    </div>
                                </div>
                                <div class="card-footer text-center">
                                    <button type="submit" class="btn btn-primary shadow ">Abastecer</button>
                                </div>
                            </form>
                        </div>
                        <span class="badge badge-circle badge-circle-lg badge-circle-quantity badge-up">
                            @if (!$service->stock)
                                0
                            @else
                                {{ $service->stock->stock_quantity }}
                            @endif
                        </span>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
<div class="mt-1 ml-1">
    {{ $services->onEachSide(1)->links() }}
</div>
@endsection