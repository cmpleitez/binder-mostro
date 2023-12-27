@extends('forestLayout')
@section('content')
<!-- register section starts -->
<section class="row">
    <div class="col-12">
        <div class="card shadow-sm disable-rounded-right mb-0 p-2 h-100 d-flex justify-content-center">
            <div class="card-header pb-1">
                <div class="card-title">
                    <h4 class="text-center mb-2">@lang('Branches maintenance')</h4>
                </div>
                <div class="text-center">
                    <h6></h6>
                </div>
            </div>
            <div class="card-content">
                <div class="card-body">
                    <form method="POST" action="{{Route('branch.store')}}" enctype="multipart/form-data">
                        @csrf

                        <div class="form-row">
                            <div class="col-md-12 mb-1">
                                <fieldset>
                                    <textarea data-length=255 class="form-control char-textarea" id="textarea-counter" rows="3" placeholder="@lang('Branch detail')" name="branch"></textarea>
                                    <label for="textarea-counter"></label>
                                    <small class="counter-value float-right"><span class="char-count">0</span> / 255 </small>
                                    @error('branch')
                                        <span class="badge badge-light-danger relative-font-size">{{ $errors->first('branch') }}</span>
                                    @enderror
                                </fieldset>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col-md-6 mb-1">
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
                            <div class="col-md-6 mb-1">
                                <fieldset>
                                    <div class="form-group">
                                        <input type="number" class="form-control" name="phone_number" placeholder="@lang('Phone number')" value="old('phone_number')">
                                        @error('phone_number')
                                            <span class="badge badge-light-danger relative-font-size">{{ $errors->first('phone_number') }}</span>
                                        @enderror
                                    </div>
                                </fieldset>
                            </div>
                        </div>

                        <!-- Submit -->
                        <div align="right">
                            <button type="submit" class="btn btn-primary">@lang('Create')</i></button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- register section ends -->
@endsection