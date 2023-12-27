@extends('forestLayout')
@section('content')
<div class="card shadow-sm">
    <div class="card-header badge-circle-light-primary">
        <div class="card-group float-left col-md-6">
            <div class="row">
                <div class="col-md-1 mr-1">{!! createServiceControl() !!}</div>
                <div class="col-md-10">PRODUCTOS / SERVICIOS</div>
            </div>
        </div>
        <div class="card-group float-right col-md-6">
            @include('models/slices/service_search')
        </div>
    </div>
    <div class="card-content">
        <div class="card-body">
            <div class="row p-1">
            </div>
        </div>

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
                            <td style="max-width: 300px">{{$service->service}}</td>
                            <td>{{$service->service_type->type}}</td>
                            <td>
                                <div class="row d-flex justify-content-center">{!! serviceControlPanel($service) !!}</div>
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