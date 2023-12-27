@extends('forestLayout')
@section('content')
<div class="col-12">
    <div class="card shadow-sm h-100 d-flex justify-content-center">
        <div class="card-header badge-circle-light-primary mb-2">
            <div class="card-title">
               <div class="row ">CATÁLOGO DE PRODUCTOS/SERVICIOS</div>
            </div>
        </div>
        <div class="card-content">
            <div class="card-body">
                <form method="POST" action="{{Route('service.store')}}" enctype="multipart/form-data">
                    @csrf
                    <div class="form-row mb-1">

                        <!--SERVICE-->
                        <div class="col-md-12">
                            <div class="form-group">
                                {{ Form::textarea('service', old('service'), array_merge( ['class'=>'form-control char-textarea',  'id'=>'textarea-counter', 'rows'=>3,  'placeholder'=>'Nombre del producto/servicio', 'name'=>'service', 'maxlength'=>100, 'autofocus'])) }}
                                <small class="counter-value float-right"><span class="char-count">0</span> / 100 </small>
                                @error('service')
                                    <span class="badge badge-light-danger relative-font-size">{{ $errors->first('service') }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="form-row">

                        <!--ROUTE-->
                        <div class="col-md-6">
                            <div class="form-group">
                                <input type="text" class="form-control" id="basicInput" placeholder="/route" name="route" value="{{ old('route') }}">
                                @error('route')
                                    <span class="badge badge-light-danger relative-font-size">{{ $errors->first('route') }}</span>
                                @enderror
                            </div>
                        </div>

                        <!--IMAGE-->
                        <div class="col-md-6">
                            <div class="form-group">
                                <div class="custom-file">
                                        <input type="file" class="custom-file-input" id="inputGroupFile01" name="pic" value="{{ old('pic') }}">
                                        <label class="custom-file-label" for="inputGroupFile01">@lang("Choose file")</label>
                                        @error('pic')
                                            <span class="badge badge-light-danger relative-font-size">{{ $errors->first('pic') }}</span>
                                        @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-row">

                        <!--SERVICE TYPE-->
                        <div class="col-md-6 pb-1">
                            <select class="form-control" id="basicSelect" name="service_type_id">
                                @foreach($service_types as $service_type)
                                    @if($service_type->id==old('service_type_id'))
                                        <option selected value="{{ $service_type->id }}" >{{$service_type->type}}</option>
                                    @else
                                        <option value="{{ $service_type->id }}">{{$service_type->type}}</option>
                                    @endif
                                @endforeach
                            </select>
                            @error('service_type_id')
                                <span class="badge badge-light-danger relative-font-size">{{ $errors->first('service_type_id') }}</span>
                            @enderror
                        </div>

                        <!--CHECKBOX MENU-->
                        <div class="col-md-2">
                            <div class="checkbox form-group">
                                @if (old('menu'))
                                    <input type="checkbox" class="checkbox-input" id="checkbox1" name="menu" checked>
                                @else
                                    <input type="checkbox" class="checkbox-input" id="checkbox1" name="menu">
                                @endif
                                <label for="checkbox1">@lang('Menú')</label>
                                <span class="badge badge-light-danger relative-font-size">{{ $errors->first('menu') }}</span>
                            </div>
                        </div>

                        <!--CHECKBOX TAX-->
                        <div class="col-md-2">
                            <div class="form-group">
                                <div class="checkbox">
                                    @if (old('tax_exempt'))
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

                        <!--CHECKBOX BILLABLE-->
                        <div class="col-md-2">
                            <div class="form-group">
                                <div class="checkbox">
                                    @if (old('billable'))
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
                    <div class="form-row">

                        <!--COST-->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="cost">Costo</label>
                                <input type="numeric" class="form-control" id="cost" placeholder="$ USD 0.00" name="cost" value="{{ old('cost') }}">
                                @error('cost')
                                    <span class="badge badge-light-danger relative-font-size">{{ $errors->first('cost') }}</span>
                                @enderror
                            </div>
                        </div>

                        <!--CHARGE-->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="basicInput">@lang('Charge')</label>
                                <input type="numeric" class="form-control" id="charge" placeholder="$ USD 0.00" name="charge" value="{{ old('charge') }}">
                                @error('charge')
                                    <span class="badge badge-light-danger relative-font-size">{{ $errors->first('charge') }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- TABLERO DE CONTROL -->
                    <div align="right">
                        <button type="submit" class="btn btn-primary">@lang('Create')</i></button>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
            var numberMask = IMask(cost, { //COST
            mask: Number,
            scale: 2,
            thousandsSeparator: ',',
            padFractionalZeros: false,  // if true, then pads zeros at end to the length of scale
            normalizeZeros: true,  // appends or removes zeros at ends
            radix: '.',  // fractional delimiter
            mapToRadix: ['.'],  // symbols to process as radix
            // additional number interval options (e.g.)
            min: -999999,
            max: 999999
        });

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
    });
</script>
@endsection