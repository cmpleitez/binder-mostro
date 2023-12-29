@extends('forestLayout')
@section('content')
<div class="card shadow-sm">
    <div class="card-header badge-circle-light-primary">
        <div class="card-group">
            <div class="row align-items-center">
                <div class="col-2">{!! createOfferControl() !!}</div>
                <div class="col-10 text-uppercase">@lang('Offers')</div>
            </div>
        </div>
    </div>
    <div class="card-content">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead>
                    <tr>
                        <th class="text-center col-1">@lang('ID')</th>
                        <th class="col-6">@lang('OFFER')</th>
                        <th class="col-2">@lang('CHARGE')</th>
                        <th class="col-3 text-center">TABLERO</th>
                    </tr>
                </thead>
                <tbody>
                	@foreach($offers as $offer)
                        <tr>
                            <td class="col-1 text-center">{{$offer->id}}</td>
                            <td class="col-6">{{$offer->offer}}</td>
                            <td class="col-2">{{ localMoneyFormat($offer->charge) }}</td>
                            <td class="col-3 d-flex align-items-sm-stretch">
                                {!! offerControlPanel($offer) !!}
                            </td>
                        </tr>
                	@endforeach
                </tbody>
            </table>
        </div>
    </div>
    <div class="card-footer">
        <div class="">
            {{ $offers->appends(request()->input())->links() }}
        </div>
    </div>
</div>
@endsection