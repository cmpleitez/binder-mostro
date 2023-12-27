<div class="card bg-transparent">
	<div class="card-content">
		<form method="GET" action="{{ Route('cart.product-search', $client) }}">
			<div class="input-group">
				<input type="text" class="form-control rounded-right form-control-lg shadow-sm autocomplete" id="basicInput" placeholder="@lang('Look for, wrriten the names')" name="search" value="{{ request()->input('search') }}">
				<div class="input-group-append">
					<button class="btn btn-primary" type="submit">
						<i class="bx bx-search"></i>
					</button>
				</div>
			</div>
		</form>
	</div>
</div>