@extends('forestLayout')
@section('content')
<div class="card shadow-sm h-100 d-flex justify-content-center">
    <div class="card-header badge-circle-light-primary mb-1">
        <div class="card-title">
            <div class="row " >CATÁLOGO DE PRODUCTOS/SERVICIOS</div>
        </div>
    </div>
    <div class="card-content">
        <div class="card-body">
            <form method="POST" action="{{Route('service.update', ['service_id'=>$service->id] )}}" enctype="multipart/form-data">
                @csrf @method('PATCH')

                <!--FORMULARIO-->
                <div class="row">
                    <div class="col-md-4">

                        <!--Imágen-->
                        <div class="row mb-1">
                            @if ( Storage::url($service->pic) !== '/storage/' )
                                <img class="card-img-top img-fluid" src="{{Storage::url($service->pic)}}" alt="Imagen del servicio" />
                            @else
                                <img class="card-img-top img-fluid" src="{{ asset('/img/producto.png') }}" alt="Imagen del servicio" />
                            @endif
                        </div>
                        <!--data-->
                        <div class="row">
                            <!--Name-->
                            <div class="col-8 text-justify ">
                                <div class="form-group">{{$service->service}}</div>
                            </div>
                            <!--Pill status-->
                            <div class="col-4 text-right">
                                @if ($service->active)
                                    <h6 class="badge badge-pill badge-circle-primary pill-fluid-font-size-1">@lang('Active')</h6>
                                @else
                                    <h6 class="badge badge-pill badge-circle-danger pill-fluid-font-size-1">@lang('Inactive')</h6>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="col-md-8 pl-2 pr-2 pt-1">

                        <!--Service type-->
                        <div class="form-row">
                            <div class="form-group col-12">
                                <label for="basicSelect">Servicio/Producto</label>
                                <select class="form-control" id="basicSelect" name="service_type_id">
                                    @foreach($service_types as $service_type)
                                        @if($service->service_type_id==$service_type->id )
                                            <option  selected value="{{ $service_type->id }}" >{{$service_type->type}}</option>
                                        @else
                                            <option value="{{ $service_type->id }}" >{{$service_type->type}}</option>
                                        @endif
                                    @endforeach
                                </select>
                                @error('service_type_id')
                                    <span class="badge badge-light-danger relative-font-size">{{ $errors->first('service_type_id') }}</span>
                                @enderror
                            </div>
                        </div>

                        <!--Route-->
                        <div class="form-row">
                            <div class="form-group col-12">
                                <label for="route">Ruta</label>
                                <input type="text" class="form-control" id="basicInput" placeholder="/route" name="route" value="{{ old('route', $service->route) }}">
                                @error('route')
                                    <span class="badge badge-light-danger relative-font-size">{{ $errors->first('route') }}</span>
                                @enderror
                            </div>
                        </div>

                        <!--Icono-->
                        <div class="form-row">
                            <div class="form-group col-12">
                                <label for="route">Icono</label>
                                <input type="text" class="form-control" id="basicInput" placeholder="/route" name="icon" value="{{ old('icon', $service->icon) }}">
                                @error('route')
                                    <span class="badge badge-light-danger relative-font-size">{{ $errors->first('icon') }}</span>
                                @enderror
                            </div>
                        </div>

                        <!--Image browse-->
                        <div class="form-row">
                            <div class="form-group col-12">
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" id="inputGroupFile01" name="pic" value="{{old( 'pic', $service->pic )}}">
                                    <label class="custom-file-label" for="inputGroupFile01">Actualizar imagen</label>
                                    @error('pic')
                                        <span class="badge badge-light-danger relative-font-size">{{ $errors->first('pic') }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!--Cost-->
                        <div class="form-row">
                            <div class="form-group col-12">
                                {{ Form::label('cost', 'Costo', ['class' => 'control-label']) }}
                                {{ Form::text('cost', number_format($service->cost, 6), array_merge(['class' => 'form-control', 'placeholder'=>'USD $ 0.000000'])) }}
                                @error('cost')
                                    <span class="badge badge-light-warning">{{ $errors->first('cost') }}</span>
                                @enderror
                            </div>
                        </div>

                        <!--Charge-->
                        <div class="form-row">
                            <div class="form-group col-12">
                                {{ Form::label('charge', 'Precio', ['class' => 'control-label']) }}
                                {{ Form::text('charge', number_format($service->charge, 6) , array_merge(['class' => 'form-control', 'placeholder'=>'USD $ 0.000000'])) }}
                                @error('charge')
                                    <span class="badge badge-light-warning">{{ $errors->first('charge') }}</span>
                                @enderror
                            </div>
                        </div>

                        <!--Checkboxes-->
                        <div class="form-row">
                            <div class="form-group col-2">
                                <div class="checkbox form-group">
                                    @if (old('menu', $service->menu))
                                        <input type="checkbox" class="checkbox-input" id="checkbox1" name="menu" checked>
                                    @else
                                        <input type="checkbox" class="checkbox-input" id="checkbox1" name="menu">
                                    @endif
                                    <label for="checkbox1">@lang('Menú')</label>
                                    @error('menu')
                                        <span class="badge badge-light-danger relative-font-size">{{ $errors->first('menu') }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group col-2">
                                <div class="checkbox form-group">
                                    <div class="checkbox">
                                        @if(old('menu', $service->tax_exempt))
                                            <input type="checkbox" class="checkbox-input" id="checkbox2" name="tax_exempt" checked>
                                        @else
                                            <input type="checkbox" class="checkbox-input" id="checkbox2" name="tax_exempt">
                                        @endif
                                        <label for="checkbox2">@lang('Tax-exempt')</label>
                                        @error('tax_exempt')
                                            <span class="badge badge-light-danger relative-font-size">{{ $errors->first('tax_exempt') }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="form-group col-2">
                                <div class="checkbox form-group">
                                    <div class="checkbox">
                                        @if(old('menu', $service->billable))
                                            <input type="checkbox" class="checkbox-input" id="checkbox3" name="billable" checked>
                                        @else
                                            <input type="checkbox" class="checkbox-input" id="checkbox3" name="billable">
                                        @endif
                                        <label for="checkbox3">Facturable</label>
                                        @error('billable')
                                            <span class="badge badge-light-danger relative-font-size">{{ $errors->first('billable') }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>

                <!--TABLERO-->
                <div class="row float-right">
                    <div class="col-md-12 pr-2">
                        <div class="form-row">
                            <div class="form-group">
                                <div class="checkbox form-group">
                                    <button type="submit" class="btn btn-primary">@lang('Update')</i></button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    var numberMask = IMask(charge, { //CHARGE
        mask: Number,
        scale: 2,
        thousandsSeparator: ',',
        padFractionalZeros: false,
        normalizeZeros: true,
        radix: '.',
        mapToRadix: ['.'],
        min: -999999,
        max: 999999
    });

    var numberMask = IMask(cost, { //COST
        mask: Number,
        scale: 2,
        thousandsSeparator: ',',
        padFractionalZeros: false,
        normalizeZeros: true,
        radix: '.',
        mapToRadix: ['.'],
        min: -999999,
        max: 999999
    });
});
</script>

@endsection