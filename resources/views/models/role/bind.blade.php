@extends('forestLayout')
@section('content')
    <!-- Collapsible and Refresh Action starts -->
    <div class="row">
        <div class="col-md-12 col-sm-12">
            <div class="card shadow-sm">
                <div class="card-header">
                    <h4 class="card-title">{{$role->role}}</h4>
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
        <div class="col-md-12 col-sm-12">
            <div class="card shadow-sm">
                <div class="card-content collapse show">
                    <div class="card-body">
                        <!-- start: form -->
                        <form method="POST" action="{{Route('role.set', $role->id)}}">
                            @csrf

                            <!-- Widgets Statistics start -->
                            <div class="row">
                                <div class="col-12 mt-1 mb-2">
                                    <h4>@lang('Services')</h4>
                                    <hr>
                                </div>
                            </div>
                            <div class="row">
                                @foreach($services as $service)
                                    <div class="col-xl-2 col-md-4 col-sm-6">
                                        <div class="card text-center">
                                            <div class="card-content">
                                                <div class="card-body">
                                                    @if($service->service_type_id==1)
                                                        <div class="badge-circle badge-circle-lg badge-circle-light-warning mx-auto my-1">
                                                            <i class="{!! $service->service_type->icon !!}"></i>
                                                        </div>
                                                    @endif
                                                    @if($service->service_type_id==2)
                                                        <div class="badge-circle badge-circle-lg badge-circle-light-primary mx-auto my-1">
                                                            <i class="{!! $service->service_type->icon !!}"></i>
                                                        </div>
                                                    @endif
                                                    @if($service->service_type_id==3)
                                                        <div class="badge-circle badge-circle-lg badge-circle-light-primary mx-auto my-1">
                                                            <i class="{!! $service->service_type->icon !!}"></i>
                                                        </div>
                                                    @endif
                                                    <p class="text-left">{{$service->id}} | {{$service->service}}</p>
                                                    <div class="checkbox checkbox-primary checkbox-glow">
                                                        @if ($service->enrolled==1)
                                                            <input type="checkbox" id="checkboxGlow{{$service->id}}" name="{{$service->id}}" checked>
                                                        @else
                                                            <input type="checkbox" id="checkboxGlow{{$service->id}}" name="{{$service->id}}">
                                                        @endif
                                                        <label for="checkboxGlow{{$service->id}}"></label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            <!-- Widgets Statistics End -->
                            <div class="col-sm-12 d-flex justify-content-end">
                                <button type="submit" class="btn btn-primary mr-1 mb-1">@lang('Submit')</button>
                                <button type="reset" class="btn btn-light-secondary mr-1 mb-1">@lang('Reset')</button>
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