@extends('forestLayout')
@section('content')
<div class="card">
	<div class="card-header">
		<h4 class="card-title">CAJAS REGISTRADORAS</h4>
	    	<p class="card-text">Se muestran las cajas registradoras pendientes y cerradas del periodo especificado.</p>
	</div>
	<div class="card-content ">
		<div class="card-body pb-1">
			<form method="GET" action ="{{Route('cashbox.history')}}">
				@csrf
				<div class="row">
					<div class="col-md-4 text-left">
						<fieldset class="form-group position-relative has-icon-left">
						    <input type="text" class="form-control dateranges" placeholder="Select Date" name="periodo" value="{{ $periodo }}">
						    <div class="form-control-position">
						        <i class="bx bx-calendar-check"></i>
						    </div>
						</fieldset>
					</div>
					<div class="col-md-8 text-right">
						<fieldset class="form-group">
                   				<button type="submit" class="btn btn-light-primary">Consultar</button>
     					</fieldset>
					</div>
				</div>
			</form>
		</div>
	</div>
</div>

<!--ini work-->
<div class="row match-height">
   <div class="col-12">
       <div class="card-deck-wrapper">
           <div class="card-deck">
               <div class="row no-gutters">
                   @foreach($cashboxes as $cashbox)
                   <div class="col-lg-4 mb-1">
                       <div class="card shadow-sm" style="
                       		<?php
                       			if ($cashboxes->count()<=1) { echo 'min-width: 300px; margin-right:1px';}
                       		?>">
	                        <div class="card-header">
                              	<h1 class="card-title text-center">CAJA {{$cashbox->id}}</h1>
								<p class="card-text">OPERADOR: {{$cashbox->name}}</p>
	                        </div>
                           	<div class="card-content">
                                <div class="card-body">
                              		<div class="row">
										@foreach($cashbox->square as $square)
											@if( $square )
												<div class="col-lg-6">
													{!! cashBoxHistoryControlPanel( $cashbox->id, $square ) !!}
												</div>
						            			@endif
										@endforeach
                  					</div>
                               </div>
                           </div>
                       </div>
                   </div>
                   @endforeach
               </div>
           </div>
       </div>
   </div>
</div>

<div class="mt-1 ml-1">
   {{ $cashboxes->links() }}
</div>
<!--end work-->
@endsection	