@extends('forestLayout')
@section('content')
<!-- register section starts -->
<section class="row">
    <div class="col-12">
        <div class="card shadow-sm disable-rounded-right mb-0 p-2 h-100 d-flex justify-content-center">
            <div class="card-header pb-1">
                <div class="card-title">
                    <h4 class="text-center mb-2">@lang('Roles support')</h4>
                </div>
                <div class="text-center">
                    <h6></h6>
                </div>
            </div>
            <div class="card-content">
                <div class="card-body">
                    <form method="POST" action="{{Route('role.store')}}">
                        @csrf
                        <div class="form-row">
                            <textarea data-length=255 class="form-control char-textarea" id="textarea-counter" rows="3" placeholder="@lang('Role details')" name="role">{{ old('role') }}</textarea>
                            <label for="textarea-counter"></label>
                            <small class="counter-value float-right"><span class="char-count">1</span> / 255 </small>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-12">
                                <label for="route">Icono</label>
                                <input type="text" class="form-control" id="basicInput" placeholder="Ejem. <i class='bx bx-chevron-right font-large-1'></i>" name="icon" value="{{ old('icon') }}" maxlength="255">
                                @error('route')
                                    <span class="badge badge-light-danger relative-font-size">{{ $errors->first('icon') }}</span>
                                @enderror
                            </div>
                        </div>
                        <div align="right">
                            <button type="submit" class="btn btn-primary">@lang('Create')</i></button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- register section endss -->

@endsection