@extends('forestLayout')
@section('content')
    <!-- Hoverable rows start -->
    <div id="table-hover-row">
        <div class="card shadow-sm">
            <div class="card-header badge-circle-light-primary" style="padding:15px">
                <div class="card-group float-left col-md-2 col-2" style="padding:0;">
                    {!! createUserControl() !!}
                </div>
                <div class="card-group float-right col-md-10 col-10" style="padding:0;">
                    <form method="GET" action="{{ Route('user.search') }}">
                        <div class="input-group">
                            <input type="text" class="form-control rounded-right form-control-md autocomplete"
                                id="basicInput" placeholder="@lang('Look for, wrriten the names')" name="search"
                                value="{{ request()->input('search') }}">
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
                                <th class="text-center">@lang('DUI')</th>
                                <th class="">@lang('NAME')</th>
                                <th class="text-left">@lang('EMAIL')</th>
                                <th class="text-center">@lang('PHONE NUMBER')</th>
                                <th class="text-center">@lang('NIT')</th>
                                <th class="text-center">@lang('NRC')</th>
                                <th class="text-center">@lang('TABLERO')</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $user)
                                <tr>
                                    <td class="text-center">{{ $user->dui }}</td>
                                    <td class="text-left">{{ $user->name }}</td>
                                    <td class="text-left">{{ $user->email }}</td>
                                    <td class="text-center">{{ $user->phone_number }}</td>
                                    <td class="text-center">{{ $user->nit }}</td>
                                    <td class="text-center">{{ $user->nrc }}</td>
                                    <td class="table-panel">
                                        {!! userControlPanel($user) !!}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card-footer">
                <div class="table-panel d-flex justify-content-between">
                    {{ $users->appends(request()->input())->links() }}
                </div>
            </div>
        </div>
    </div>
    <!-- Hoverable rows end -->
@endsection
