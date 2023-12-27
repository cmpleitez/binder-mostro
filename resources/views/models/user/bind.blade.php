@extends('forestLayout')
@section('content')
    <!-- Collapsible and Refresh Action starts -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">{{$user->name}}</h4>
                    <a class="heading-elements-toggle">
                        <i class="bx bx-dots-vertical font-medium-3"></i>
                    </a>
                    <div class="heading-elements">
                        <ul class="list-inline mb-0">
                            <li>
                                <a data-action="collapse">
                                    <i class="bx bx-chevron-down"></i>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="card-content collapse show">
                    <div class="card-body">
                        @lang('Detail')
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Collapsible and Refresh Action Ends -->

    <!-- Collapsible and Refresh Action starts -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-content collapse show">
                    <div class="card-body">
                        <!-- start: form -->
                        <form method="POST" action="{{Route('user.set', $user->id)}}">
                            @csrf

                            <!-- Widgets Statistics start -->
                            <div class="row">
                                <div class="col-12 mt-1 mb-2">
                                    <h4>{{'Roles'}}</h4>
                                    <hr>
                                </div>
                            </div>
                            <div class="row">
                                @foreach($roles as $role)
                                    <div class="col-xl-2 col-md-4 col-sm-6">
                                        <div class="card text-center">
                                            <div class="card-content">
                                                <div class="card-body">
                                                    <div class="badge-circle badge-circle-lg badge-circle-light-info mx-auto my-1">
                                                        <i class="bx bx-extension font-large-1"></i>
                                                    </div>
                                                    <p class="text-muted mb-0 line-ellipsis">{{$role->role}}</p>
                                                    <div class="checkbox checkbox-primary checkbox-glow">
                                                        @if ($role->enrolled==1)
                                                            <input type="checkbox" id="checkboxGlow{{$role->id}}" name="{{$role->id}}"checked>
                                                        @else
                                                            <input type="checkbox" id="checkboxGlow{{$role->id}}" name="{{$role->id}}">
                                                        @endif
                                                        <label for="checkboxGlow{{$role->id}}"></label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            <!-- Widgets Statistics End -->
                            <div class="col-12" align="right">
                                <button type="submit" class="btn btn-primary ml-1 mb-1">@lang('Submit')</button>
                                <button type="reset" class="btn btn-primary ml-1 mb-1">@lang('Reset')</button>
                            </div>
                        </form>
                        <!-- end: form -->
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Collapsible and Refresh Action Ends -->
@endsection