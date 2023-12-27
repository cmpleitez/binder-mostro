@extends('forestLayout')
@section('content')
<section class="row">
    <div class="col-12">
        <div class="card shadow-sm disable-rounded-right mb-0 p-2 h-100 d-flex justify-content-center">
            <div class="card-header pb-1">
                <div class="card-title">
                    <h4 class="text-center mb-2">@lang('Sign up')</h4>
                </div>
                <div class="text-center">
                    <h6>@lang('Please enter your details to sign up ir order to get support from our Work Team!')</h6>
                </div>
            </div>
            <div class="card-content">
                <div class="card-body">
                    <form method="POST" action="{{Route('user.store')}}">
                        @csrf
                        <div class="form-row">
                            <!-- DUI and PHONE NUMBER -->
                            <div class="form-group col-md-6 mb-50">
                                <label class="text-bold-600" for="dui">DUI</label>
                                <input type="text" id="unmasked_dui" name="unmasked_dui" hidden>
                                <input type="text" class="form-control" id="dui" placeholder="00000000-0" name="dui" value="{{ old('dui') }}">
                                <span class="badge badge-light-danger">{{ $errors->first('dui') }}</span>
                            </div>
                            <div class="form-group col-md-6 mb-50">
                                <label class="text-bold-600" for="phone_number">@lang('Phone Number')</label>
                                <input type="text" id="unmasked_phone_number" name="unmasked_phone_number" hidden>
                                <input type="text" class="form-control" id="phone_number" placeholder="0000-0000" name="phone_number" value="{{ old('phone_number') }}">
                                <span class="badge badge-light-danger">{{ $errors->first('phone_number') }}</span>
                            </div>
                        </div>

                        <!-- NAME -->
                        <div class="form-group mb-50">
                            <label class="text-bold-600" for="name">@lang('Name')</label>
                            <input type="text" class="form-control" id="name" placeholder="@lang('First name and second name')" name="name" value="{{ old('name') }}">
                            <span class="badge badge-light-danger">{{ $errors->first('name') }}</span>
                        </div>

                        <!-- EMAIL ADDRESS -->
                        <div class="form-group mb-50">
                            <label class="text-bold-600" for="exampleInputEmail1">@lang('Email address')</label>
                            <input type="email" class="form-control" id="masked_email" placeholder="usuario@servidor.extension" name="email" value="{{ old('email') }}">
                            <span class="badge badge-light-danger">{{ $errors->first('email') }}</span>
                        </div>

                        <!-- NIT and NRC -->
                        <div class="form-row">
                            <div class="form-group col-md-6 mb-50">
                                <label class="text-bold-600" for="nit">NIT</label>
                                <input type="text" id="unmasked_nit" name="unmasked_nit" hidden>
                                <input type="text" class="form-control" id="nit" placeholder="0000-000000-000-0" name="nit" value="{{ old('nit') }}">
                                <span class="badge badge-light-danger">{{ $errors->first('nit') }}</span>
                            </div>
                            <div class="form-group col-md-6 mb-50">
                                <label class="text-bold-600" for="nrc">NRC</label>
                                <input type="text" id="unmasked_nrc" name="unmasked_nrc" hidden>
                                <input type="text" class="form-control" id="nrc" placeholder="0000-0" name="nrc" value="{{ old('nrc') }}">
                                <span class="badge badge-light-danger">{{ $errors->first('nrc') }}</span>
                            </div>
                        </div>

                        <!-- SUCURSAL Y AREA -->
                        <div class="form-row">
                            <div class="form-group col-md-6 mb-50">
                                <label class="text-bold-600" for="branch_id">SUCURSAL</label>
                                <select class="form-control" id="branch_id" name="branch_id">
                                    @foreach($branches as $branch)
                                        @if($branch->id==old('branch_id'))
                                            <option selected value="{{ $branch->id }}" >{{$branch->branch}}</option>
                                        @else
                                            <option value="{{ $branch->id }}">{{$branch->branch}}</option>
                                        @endif
                                    @endforeach
                                </select>
                                @error('branch_id')
                                    <span class="badge badge-light-danger relative-font-size">{{ $errors->first('branch_id') }}</span>
                                @enderror
                            </div>
                            <div class="form-group col-md-6 mb-50">
                                <label class="text-bold-600" for="area_id">AREA</label>
                                <select class="form-control" id="area_id" name="area_id">
                                    @foreach($areas as $area)
                                        @if($area->id==old('area_id'))
                                            <option selected value="{{ $area->id }}" >{{$area->area}}</option>
                                        @else
                                            <option value="{{ $area->id }}">{{$area->area}}</option>
                                        @endif
                                    @endforeach
                                </select>
                                @error('area_id')
                                    <span class="badge badge-light-danger relative-font-size">{{ $errors->first('area_id') }}</span>
                                @enderror
                            </div>
                        </div>

                        <!-- PASSWORD -->
                        <div class="form-row">
                            <div class="form-group col-md-6 mb-50">
                                <label class="text-bold-600" for="exampleInputPassword1">@lang('Password')</label>
                                <input type="password" class="form-control" id="exampleInputPassword1" placeholder="@lang('Password')" name="password">
                                <span class="badge badge-light-danger">{{ $errors->first('password') }}</span>
                            </div>
                            <div class="form-group col-md-6 mb-50">
                                <label class="text-bold-600" for="password_confirmation">@lang('Password confirmation')</label>
                                <input type="password" class="form-control" id="password_confirmation" placeholder="@lang('Password confirmation')" name="password_confirmation">
                                <span class="badge badge-light-danger">{{ $errors->first('password_confirmation') }}</span>
                            </div>
                        </div>

                        <!-- SUBMIT -->
                        <div align="right">
                            <button type="submit" class="btn btn-primary">@lang('SIGN UP')</i></button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

<script type="text/javascript">
    document.addEventListener("DOMContentLoaded", function () {
        //DUI
        var dui = IMask(
            document.getElementById('dui'), {
                mask: '########-#',
                definitions: {
                    '#': /[\d]/,
                },
                lazy: true,
        }).on('accept', function(){
            document.getElementById('dui').className = 'form-control is-invalid';
        }).on('complete', function() {
            document.getElementById('dui').className = 'form-control is-valid';
            document.getElementById('unmasked_dui').value = dui.unmaskedValue;
        });

        //PHONE NUMBER
        var phone_number = IMask(
            document.getElementById('phone_number'), {
                mask: '####-####',
                definitions: {
                    '#': /[\d]/,
                },
                lazy: true,
        }).on('accept', function(){
            document.getElementById('phone_number').className = 'form-control is-invalid';
        }).on('complete', function() {
            document.getElementById('phone_number').className = 'form-control is-valid';
            document.getElementById('unmasked_phone_number').value = phone_number.unmaskedValue;
        });

        //NIT
        var nit = IMask(
            document.getElementById('nit'), {
                mask: '####-######-###-#',
                definitions: {
                    '#': /[\d]/,
                },
                lazy: true,
        }).on('accept', function(){
            document.getElementById('nit').className = 'form-control is-invalid';
        }).on('complete', function() {
            document.getElementById('nit').className = 'form-control is-valid';
            document.getElementById('unmasked_nit').value = nit.unmaskedValue;
        });

        //NRC
        var nrc = IMask(
            document.getElementById('nrc'), {
                mask: '####-#',
                definitions: {
                    '#': /[\d]/,
                },
                lazy: true,
        }).on('accept', function(){
            document.getElementById('nrc').className = 'form-control is-invalid';
        }).on('complete', function() {
            document.getElementById('nrc').className = 'form-control is-valid';
            document.getElementById('unmasked_nrc').value = nrc.unmaskedValue;
        });
    });
</script>
@endsection
