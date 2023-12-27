<form method="GET" action="{{ Route('service.search') }}">
	<div class="input-group">

		<input type="text" class="form-control rounded-right form-control-md autocomplete" id="basicInput" placeholder="Producto / Servicio" name="search" value="{{request()->input('search')}}">

		<div class="input-group-append">
			<button class="btn btn-primary" type="submit">
				<i class="bx bx-search"></i>
			</button>
		</div>
	</div>
</form>
