@extends('forestLayout')
@section('content')
<form method="POST" action="{{Route('payment-type.update', ['payment_type_id'=>$payment_type->id] )}}">
    @csrf @method('PATCH')
    <div class="card-deck mb-1 m-0">
        <!--begin: Long fields -->
        <div class="card col-lg-12 col-md-12 col-sm-12 m-0 rounded-0">
            <div class="card-body">
                <h4 class="card-title">
                    @lang('Payment type create')
                </h4>
                <div class="form-group">
                    <textarea data-length=255 class="form-control char-textarea" id="textarea-counter" rows="3" placeholder="@lang('Payment type detail')" name="type">{{ old('type', $payment_type->type) }}</textarea>
                    <label for="textarea-counter"></label>
                    <small class="counter-value float-right"><span class="char-count">0</span> / 255 </small>
                    <span class="badge badge-light-danger">{{ $errors->first('type') }}</span>
                </div>
                <fieldset class="form-group">
                    <div class="checkbox">
                        @if ($payment_type->cashbox_in == 1)
                            <input type="checkbox" class="checkbox-input" id="checkbox1" name="cashbox_in" checked>
                        @else
                            <input type="checkbox" class="checkbox-input" id="checkbox1" name="cashbox_in">
                        @endif
                        <label for="checkbox1">@lang('Incluido en caja')</label>
                        <span class="badge badge-light-danger">{{ $errors->first('cashbox_in') }}</span>
                    </div>
                </fieldset>
                <div class="form-group" align="right">
                    <button type="submit" class="btn btn-warning">@lang('Update')</i></button>
                </div>

            </div>
        </div>
        <!--end: Long fields -->
    </div>
</form>
@endsection