@extends('forestLayout')
@section('content')
    <!-- Hoverable rows start -->
    <div id="table-hover-row">
        <div class="card shadow-sm">
            <div class="card-header badge-circle-light-primary">
                <div class="card-group float-left col-md-8">
                    <div class="row">
                        <div class="col-md-1 mr-1">{!! createUserControl() !!}</div>
                    </div>
                </div>
                <div class="card-group float-right col-md-4">
                    <form method="GET" action="{{ Route('user.search') }}">
                        <div class="input-group">
                            <input type="text" class="form-control rounded-right form-control-md autocomplete" id="basicInput" placeholder="@lang('Look for, wrriten the names')" name="search" value="{{request()->input('search')}}">
                            <div class="input-group-append">
                                <button class="btn btn-primary" type="submit">
                                    <i class="bx bx-search"></i>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="card-content">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead>
                            <tr>
                                <th>@lang('DUI')</th>
                                <th>@lang('NAME')</th>
                                <th>@lang('EMAIL')</th>
                                <th>@lang('PHONE NUMBER')</th>
                                <th>@lang('NIT')</th>
                                <th>@lang('NRC')</th>
                                <th class="text-center">@lang('TABLERO')</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($users as $user)
                                <tr>
                                    <td>{{$user->dui}}</td>
                                    <td>{{$user->name}}</td>
                                    <td>{{$user->email}}</td>
                                    <td>{{$user->phone_number}}</td>
                                    <td>{{$user->nit}}</td>
                                    <td>{{$user->nrc}}</td>
                                    <td class="d-flex justify-content-center">
                                        {!! userControlPanel($user) !!}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card-footer">
                <div class="">
                    {{ $users->appends(request()->input())->links() }}
                </div>
            </div>
        </div>
    </div>
    <!-- Hoverable rows end -->
@endsection