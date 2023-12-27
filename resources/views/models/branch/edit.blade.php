@extends('forestLayout')
@section('content')
<div class="card shadow-sm">
    <div class="card-header badge-circle-light-primary">
        <div class="card-title">
            <h4 class="text-center m-0">@lang('Branches maintenance')</h4>
        </div>
        <div class="text-center">
            <h6></h6>
        </div>
    </div>
    <form method="POST" action="{{Route('branch.update', $branch)}}" enctype="multipart/form-data">
        <div class="card-content">
            <div class="card-body">
                @csrf @method('PATCH')
                <div class="row">
                    <div class="col-12 p-1">
                        @if ( Storage::url($branch->pic) !== '/storage/' )
                            <img class="card-img-top img-fluid" src="{{Storage::url($branch->pic)}}" alt="Imagen del servicio" />
                        @else
                            <img class="card-img-top img-fluid height-100 width-600" src="{{ asset('/img/servicio.png') }}" alt="Imagen del servicio" />
                        @endif
                    </div>
                </div>
                <div class="form-row d-flex justify-content-between">
                    <div class="form-group col-md-6">
                        <label class="text-bold-600" for="phonenumber">@lang('Phone Number')</label>
                        <input type="number" class="form-control" id="phonenumber" placeholder="@lang('N digits without dashes')" name="phone_number" value="{{ old('phone_number', $branch->phone_number) }}">
                        <span class="badge badge-light-danger">{{ $errors->first('phone_number') }}</span>
                    </div>
                    <div class="form-group col-md-6 mt-2 ">
                        <div class="custom-file">
                            <input type="file" class="custom-file-input" id="inputGroupFile01" name="pic" value="{{old( 'pic', $branch->pic )}}">
                            <label class="custom-file-label" for="inputGroupFile01">Actualizar imagen</label>
                            @error('pic')
                                <span class="badge badge-light-danger relative-font-size">{{ $errors->first('pic') }}</span>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-footer d-flex justify-content-end">
            <button type="submit" class="btn btn-primary">@lang('Update')</i></button>
        </div>
    </form>
</div>
@endsection