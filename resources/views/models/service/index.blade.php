@extends('forestLayout')
@section('content')
<div class="card shadow-sm">
    <div class="card-header badge-circle-light-primary" style="padding:15px">
        <div class="card-group float-left col-md-2 col-2" style="padding:0;">
            {!! createServiceControl() !!}
        </div>
        <div class="card-group float-right col-md-10 col-10" style="padding:0;">
            @include('models/slices/service_search')
        </div>
    </div>
    <div class="card-content">
        <!-- table hover -->
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead>
                    <tr>
                        <th class="text-center">@lang('ID')</th>                    
                        <th>@lang('SERVICE')</th>
                        <th>@lang('TYPE')</th>
                        <th class="text-center">TABLERO</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($services as $service)
                        <tr>
                            <td class="text-center">{{$service->id}}</td>
                            <td>{{$service->service}}</td>
                            <td>{{$service->service_type->type}}</td>
                            <td class="table-panel">
                                {!! serviceControlPanel($service) !!}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <div class="card-footer">
        <div class="">
            {{ $services->appends(request()->input())->links() }}
        </div>
    </div>
</div>
@endsection