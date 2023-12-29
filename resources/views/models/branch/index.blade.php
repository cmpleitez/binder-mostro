@extends('forestLayout')
@section('content')
<div class="card shadow-sm">
    <div class="card-header badge-circle-light-primary">
        <div class="card-group">
            <div class="row align-items-center">
                <div class="col-md-1">{!! createBranchControl() !!}</div>
                <div class="col-md-11 text-uppercase">@lang('Branches')</div>
            </div>
        </div>
    </div>
    <div class="card-content">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead>
                    <tr>
                        <th class="col-1 text-center">@lang('ID')</th>
                        <th class="col-9">@lang('BRANCH')</th>
                        <th class="col-2 text-center">TABLERO</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($branches as $branch)
                        <tr>
                            <td class="col-1 text-center">{{$branch->id}}</td>
                            <td class="col-9">{{$branch->branch}}</td>
                            <td class="col-2 d-flex align-items-sm-stretch">{!! branchControlPanel( $branch->id ) !!}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <div class="card-footer">
        <div>
            {{ $branches->appends(request()->input())->links() }}
        </div>
    </div>
</div>
@endsection