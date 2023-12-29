@extends('forestLayout')
@section('content')
<div class="card shadow-sm">
    <div class="card-header badge-circle-light-primary" style="padding:15px">
        <div class="row align-items-center">
            <div class="col-2">{!! createRoleControl() !!}</div>
            <div class="col-10">ROLES</div>
        </div>
        
    </div>
    <div class="card-content">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead>
                    <tr>
                        <th class="text-center">@lang('ID')</th>
                        <th>@lang('ROLE')</th>
                        <th class="text-center">TABLERO</th>
                    </tr>
                </thead>
                <tbody>
                	@foreach($roles as $role)
                        <tr>
                            <td class="col-md-1 text-center">{{$role->id}}</td>
                            <td class="col-md-8">{{$role->role}}</td>
                            <td class="col-md-3">
                                <div class="row d-flex justify-content-center">{!! roleControlPanel($role) !!}</div>
                            </td>
                        </tr>
                	@endforeach
                </tbody>
            </table>
        </div>
    </div>
    <div class="card-footer">
        <div class="">
            {{ $roles->appends(request()->input())->links() }}
        </div>
    </div>
</div>
@endsection