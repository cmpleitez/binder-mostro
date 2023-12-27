@extends('forestLayout')
@section('content')
<div class="card shadow-sm">
    <div class="card-header badge-circle-light-primary">
        <div class="card-group">
            <div class="row">
                <div class="col-md-1 centrar">{!! createOfferControl() !!}</div>
                <div class="col-md-11  text-uppercase">@lang('Offers')</div>
            </div>
        </div>
    </div>
    <div class="card-content">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead>
                    <tr>
                        <th>@lang('ID')</th>
                        <th>@lang('OFFER')</th>
                        <th>@lang('CHARGE')</th>
                        <th class="text-center">TABLERO</th>
                    </tr>
                </thead>
                <tbody>
                	@foreach($offers as $offer)
                        <tr>
                            <td class="col-md-1 col-sm-1">{{$offer->id}}</td>
                            <td class="col-md-7">{{$offer->offer}}</td>
                            <td class="col-md-2">{{ localMoneyFormat($offer->charge) }}</td>
                            <td class="col-md-2">
                                <div class="row d-flex justify-content-center">{!! offerControlPanel($offer) !!}</div>
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