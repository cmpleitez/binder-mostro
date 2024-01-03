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
                        <th >@lang('OFFER')</th>
                        <th >@lang('CHARGE')</th>
                        <th class="text-center">TABLERO</th>
                    </tr>
                </thead>
                <tbody>
                	@foreach($offers as $offer)
                        <tr>
                            <td class="text-center">{{$offer->id}}</td>
                            <td >{{$offer->offer}}</td>
                            <td >{{ localMoneyFormat($offer->charge) }}</td>
                            <td class="table-panel">
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