@extends('forestLayout')
@section('content')
    <div class="row">
    	@foreach ($applicants as $key => $applicant)
	        <div class="col-xl-4 col-sm-6 col-12">
	            <div class="card shadow-sm">
	                <div class="card-content">
	                    <div class="row no-gutters">
	                        <div class="col-md-12 col-lg-4">
	                            <img src="../../../app-assets/images/banner/banner-35.jpg" alt="element 01" class="h-100 w-100 rounded-left">
	                        </div>
	                        <div class="col-md-12 col-lg-8">
	                            <div class="card-body">
	                                <span><i class="bx font-size-large align-middle mr-50"></i>{{ $applicant->name }}</span>
	                                @if ($applicant->autoservicio==1)
	                                	<p>@lang('CUSTOM')</p>
	                                @else
                                		<p>@lang('OPERATOR')</p>
                                	@endif
									<!--ini-->
									<ul class="list-inline">
									    <li>
									        <div class="badge-circle badge-circle-lg badge-circle-secondary mr-1 mb-1">
									            <a class="font-large-1" href="{{ route('user.hired', ['applicant_id' => $applicant->id, 'autoservicio' => 0]) }}">
									            	<i class="bx bxs-user-circle font-large-1" style="color:#FFFFFF"></i>
									            </a>
									        </div>
									    </li>
									    <li>
									        <div class="badge-circle badge-circle-lg badge-circle-warning mr-1 mb-1">
									            <a class="font-large-1" href="{{ route('user.hired', ['applicant_id' => $applicant->id, 'autoservicio' => 1]) }}">
									            	<i class="bx bx-log-out-circle bx-flip-horizontal font-large-1" style="color:#FFFFFF"></i>
									            </a>
									        </div>
									    </li>
									</ul>
									<!--fin-->
	                            </div>
	                        </div>
	                    </div>
	                </div>
	            </div>
	        </div>
		@endforeach
    </div>
@endsection