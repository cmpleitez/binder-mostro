@extends('forestLayout')
@section('content')
<div class="card shadow-sm">
    <div class="card-header badge-circle-light-primary">
        <div class="card-group">
            <div class="row align-items-center">
                <div class="col-2">{!! createBranchControl() !!}</div>
                <div class="col-10 text-uppercase">@lang('Branches')</div>
            </div>
        </div>
    </div>
    <div class="card-content">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead>
                    <tr>
                        <th class="text-center">@lang('ID')</th>
                        <th class="text-left">@lang('BRANCH')</th>
                        <th class="text-center">TABLERO</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($branches as $branch)
                        <tr>
                            <td class="text-center">{{$branch->id}}</td>
                            <td class="text-left">{{$branch->branch}}</td>
                            <td class="table-panel">{!! branchControlPanel( $branch->id ) !!}</td>
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