@extends('forestLayout')
@section('content')
<!-- register section starts -->
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
                    <form method="POST" action="{{ Route('user.update', ['user'=>$user]) }}">
                        @csrf @method('PATCH')

                        <!-- DUI AND PHONE NUMBER -->
                        <div class="form-row">
                            <div class="form-group col-md-6 mb-50">
                                <label class="text-bold-600" for="dui">DUI</label>
                                <input type="number" class="form-control" id="dui" placeholder="@lang('9 Dígitos sin guiones')" name="dui" value="{{ old('dui', $user->dui) }}">
                                <span class="badge badge-light-danger">{{ $errors->first('dui') }}</span>
                            </div>
                            <div class="form-group col-md-6 mb-50">
                                <label class="text-bold-600" for="phonenumber">@lang('Phone Number')</label>
                                <input type="number" class="form-control" id="phonenumber" placeholder="@lang('N dígitos sin guiones')" name="phone_number" value="{{ old('phone_number', $user->phone_number) }}">
                                <span class="badge badge-light-danger">{{ $errors->first('phone_number') }}</span>
                            </div>
                        </div>

                        <!-- NAME -->
                        <div class="form-group mb-50">
                            <label class="text-bold-600" for="name">@lang('Name')</label>
                            <input type="text" class="form-control" id="name" placeholder="@lang('First name and second name')" name="name" value="{{ old('name', $user->name) }}">
                            <span class="badge badge-light-danger">{{ $errors->first('name') }}</span>
                        </div>

                        <!-- NIT AND NRC -->
                        <div class="form-row">
                            <div class="form-group col-md-6 mb-50">
                                <label class="text-bold-600" for="nit">NIT</label>
                                <input type="number" class="form-control" id="nit" placeholder="@lang('14 digits without dashes')" name="nit" value="{{ old('nit', $user->nit) }}">
                                <span class="badge badge-light-danger">{{ $errors->first('nit') }}</span>
                            </div>
                            <div class="form-group col-md-6 mb-50">
                                <label class="text-bold-600" for="nrc">NRC</label>
                                <input type="number" class="form-control" id="nrc" placeholder="@lang('From 1 to 7 digits without dashes')"name="nrc" value="{{ old('nrc', $user->nrc) }}">
                                <span class="badge badge-light-danger">{{ $errors->first('nrc') }}</span>
                            </div>
                        </div>

                        <!-- SUCURSAL Y AREA -->
                        <div class="form-row">
                            <div class="form-group col-md-6 mb-50">
                                <label class="text-bold-600" for="branch_id">SUCURSAL</label>
                                <select class="form-control" id="branch_id" name="branch_id">
                                    @foreach($branches as $branch)
                                        @if($user->branch_id==$branch->id)
                                            <option  selected value="{{ $branch->id }}" >{{$branch->branch}}</option>
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
                                        @if($user->area_id==$area->id)
                                            <option  selected value="{{ $area->id }}" >{{$area->area}}</option>
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

                        <!-- SUBMIT -->
                        <div align="right">
                            <button type="submit" class="btn btn-primary mt-1">@lang('Update')</i></button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- register section endss -->
@endsection