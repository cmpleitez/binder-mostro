@extends('forestLayout')
@section('content')
<div class="card">
	<form method="POST" action="{{ Route('sale.save-invoice') }}" enctype="multipart/form-data">
		@csrf
		<div class="row">
			<div class="col-md-3  text-left">FACTURA</div>
			<div class="col-md-6">
				<div class="card-group float-right col-md-8">
					<div class="form-group">
						<div class="custom-file">
							<input type="file" class="custom-file-input" id="inputGroupFile01" name="voucher">
							<label class="custom-file-label" for="inputGroupFile01">Seleccione el comprobante</label>
							<span class="badge badge-light-danger">{{ $errors->first('voucher') }}</span>
						</div>
					</div>
				</div>
			</div>
			<div class="col-md-3 text-right">
				<a href="#" type="button" class="btn btn-primary round" disabled>Enviar</a>
				@if (isset($offers_items))
					@foreach( $offers_items as $group )
						@foreach ($group as $key => $item)
							<input type="hidden" name="item_id[]" value="{{$item['item_id']}}">
						@endforeach
					@endforeach
				@endif
				@if (isset($product_items))
					@foreach( $product_items as $key => $item )
						<input type="hidden" name="item_id[]" value="{{$item['item_id']}}">
					@endforeach
				@endif
				<input type="hidden" name="payment_type_id" value="{{$order['payment_type_id']}}">
				<button type="submit" class="btn btn-primary round">FACTURAR</button>
			</div>
		</div>
	</form>
</div>
<embed class="height-700" src="{{Storage::url('public/invoice.pdf')}}" type="application/pdf" width="100%" height="100%">
@endsection