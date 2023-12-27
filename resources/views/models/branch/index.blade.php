@extends('forestLayout')
@section('content')
<div class="card shadow-sm">
    <div class="card-header badge-circle-light-primary">
        <div class="card-group">
            <div class="row">
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
                        <th>@lang('ID')</th>
                        <th>@lang('BRANCH')</th>
                        <th class="text-center">TABLERO</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($branches as $branch)
                        <tr>
                            <td class="col-md-2 col-sm-2">{{$branch->id}}</td>
                            <td class="col-md-7">{{$branch->branch}}</td>
                            <td class="col-md-3"><div class="row d-flex justify-content-center">
                                {!! branchControlPanel( $branch->id ) !!}
                            </div></td>
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