@extends('forestLayout')
@section('content')
<div class="row">
	<div class="col-md-3 col-sm-6">
		<div class="card">
		    <div class="card-content">
		        <div class="card-body">
		            <h4 class="card-title text-center">Opción</h4>
		            <p class="card-text text-center">
						<a href="{{ route('cart.fill', 1) }}">
		                    <i class="bx bxs-briefcase-alt-2 font-large-5"></i>
		                </a>
		            </p>
		            <small class="text-muted">Defición.</small>
		        </div>
		    </div>
		</div>
	</div>
</div>
@endsection