@extends('forestLayout')
@section('content')
<form method="POST" action="{{Route('offer.store')}}" enctype="multipart/form-data">
    @csrf
    <div class="card-deck mb-1 m-0">
        <div class="card col-lg-12 col-md-12 col-sm-12 m-0 rounded-0">
            <div class="card-body">
                <h4 class="card-title">
                    @lang('Offer create')
                </h4>

                <!--OFFER-->
                <div class="form-group">
                    <textarea data-length=100 class="form-control char-textarea" id="textarea-counter" rows="3" placeholder="@lang('Offer detail')" name="offer" maxlength="100">{{ old('offer') }}</textarea>
                    <label for="textarea-counter"></label>
                    <small class="counter-value float-right"><span class="char-count">0</span> / 100 </small>
                    <span class="badge badge-light-danger">{{ $errors->first('offer') }}</span>
                </div>

                <!--PICTURE-->
                <div class="form-group">
                    <div class="custom-file">
                        <input type="file" class="custom-file-input" id="inputGroupFile01" name="pic">
                        <label class="custom-file-label" for="inputGroupFile01">@lang("Choose file")</label>
                        <span class="badge badge-light-danger">{{ $errors->first('pic') }}</span>
                    </div>
                </div>

                <!--CHARGE-->
                <div class="form-group">
                    <label class="text-bold-600" for="charge">@lang('Charge')</label>
                    <input type="numeric" class="form-control" id="charge" placeholder="$ USD 0.00" name="charge" value="{{ old('charge') }}">
                    <span class="badge badge-light-danger">{{ $errors->first('charge') }}</span>
                </div>

                <!--TABLERO DE CONTROL-->
                <div class="form-group" align="right">
                    <button type="submit" class="btn btn-primary">@lang('Create')</i></button>
                </div>

            </div>
        </div>
    </div>
</form>

<script type="text/javascript">
    document.addEventListener('DOMContentLoaded', function() {
        var numberMask = IMask(charge, { //CHARGE
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
    });
</script>
@endsection