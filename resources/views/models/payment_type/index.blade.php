@extends('forestLayout')
@section('content')
<div class="card shadow-sm">
    <div class="card-header badge-circle-light-primary">
        <div class="card-group">
            <div class="row">
                <div class="col-md-1">{!! createPaymentTypeControl() !!}</div>
                <div class="col-md-11  text-uppercase">@lang('Payment types')</div>
            </div>
        </div>
    </div>
    <div class="card-content">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead>
                    <tr>
                        <th>@lang('ID')</th>
                        <th>@lang('PAYMENT')</th>
                        <th class="text-center">@lang('TYPE')</th>
                        <th class="text-center">TABLERO</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($payment_types as $payment_type)
                        <tr>
                            <td class="text-bold-500">{{$payment_type->id}}</td>
                            <td>{{$payment_type->type}}</td>
                            @if($payment_type->cashbox_in==1)
                                <td class="text-center">
                                    <h6 class="badge badge-pill badge-circle-light-primary text-truncate">@lang('Cashbox in')</h6>
                                </td>
                            @else
                                <td class="text-center">
                                    <h6 class="badge badge-pill badge-circle-light-secondary text-truncate">@lang('Cashbox out')</h6>
                                </td>
                            @endif
                            <td>
                                <div class="row d-flex justify-content-center">
                                    {!! paymentTypeControlPanel($payment_type) !!}
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <div class="card-footer">
        <div class="">
            {{ $payment_types->onEachSide(1)->links() }}
        </div>
    </div>
</div>
@endsection