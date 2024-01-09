<?php
//SETTINGS
App::setLocale('es');

//PUBLIC SERVICES
Auth::routes(['verify'=>true]);
Route::get('/', 'AuthController@auth')->name('auth');
Route::get('forestregister', 'AuthController@forestRegister')->name('forestregister');
Route::get('forestlogin', 'AuthController@forestLogin')->name('forestlogin');
Route::get('/home', 'HomeController@index')->name('home')->middleware('verified');

//ACCESS AUTHORIZE
Route::group(['middleware' => 'auth' ], function () {
	Route::group(['middleware' => 'service.access' ], function () {

		//SYSTEM OPTIONS MAINTENANCE
		Route::group(['prefix' => 'automation'], function () {
			Route::get('option', 'OptionController@option')->name('automation.option');
			Route::post('offer-send/{client}/{cart}', 'MailController@store')->name('automation.offer-send');
			Route::get('private-reports', 'ReportsController@privateReports')->name('automation.private-reports');
			Route::get('ventas', 'ReportsController@ventas')->name('automation.reporte-ventas');
		});

		//USER MAINTENANCE & BIND
		Route::group(['prefix' => 'user'], function () {
			Route::get('/', 'UserController@index')->name('user');
			Route::get('create', 'UserController@create')->name('user.create');
			Route::post('store', 'UserController@store')->name('user.store');
			Route::get('edit/{user}', 'UserController@edit')->name('user.edit');
			Route::patch('update/{user}', 'UserController@update')->name('user.update');
			Route::get('bind/{user}', 'UserController@bind')->name('user.bind');
			Route::post('set/{user}', 'UserController@set')->name('user.set');
			Route::get('search', 'UserController@search')->name('user.search');
			Route::get('undo/{user}', 'UserController@undo')->name('user.undo');
		});

		//ROLE MAINTENANCE & BIND
		Route::group(['prefix' => 'role'], function () {
			Route::get('/', 'RoleController@index')->name('role');
			Route::get('create', 'RoleController@create')->name('role.create');
			Route::get('edit/{role}', 'RoleController@edit')->name('role.edit');
			Route::post('store', 'RoleController@store')->name('role.store');
			Route::patch('update/{role}', 'RoleController@update')->name('role.update');
			Route::get('undo/{role}', 'RoleController@undo')->name('role.undo');
			Route::get('bind/{role}', 'RoleController@bind')->name('role.bind');
			Route::post('set/{role}', 'RoleController@set')->name('role.set');
		});
		
		//OFFER MAINTENANCE & BIND
		Route::group(['prefix' => 'offer'], function () {
			Route::get('/', 'OfferController@index')->name('offer');
			Route::get('create', 'OfferController@create')->name('offer.create');
			Route::get('edit/{offer}', 'OfferController@edit')->name('offer.edit');
			Route::post('store', 'OfferController@store')->name('offer.store');
			Route::patch('update/{offer}', 'OfferController@update')->name('offer.update');
			Route::get('undo/{offer}', 'OfferController@undo')->name('offer.undo');
			Route::get('bind/{offer}', 'OfferController@bind')->name('offer.bind');
			Route::post('set/{offer}', 'OfferController@set')->name('offer.set');
		});

		//SERVICE MAINTENANCE
		Route::group(['prefix' => 'service'], function () {
			Route::get('/', 'ServiceController@index')->name('service');
			Route::get('create', 'ServiceController@create')->name('service.create');
			Route::get('edit/{service}', 'ServiceController@edit')->name('service.edit');
			Route::post('store', 'ServiceController@store')->name('service.store');
			Route::patch('update/{service}', 'ServiceController@update')->name('service.update');
			Route::get('search', 'ServiceController@search')->name('service.search');
			Route::get('undo/{service}', 'ServiceController@undo')->name('service.undo');
		});

		//BRANCH MAINTENANCE
		Route::group(['prefix' => 'branch'], function () {
			Route::get('/', 'BranchController@index')->name('branch');
			Route::get('create', 'BranchController@create')->name('branch.create');
			Route::get('edit/{branch}', 'BranchController@edit')->name('branch.edit');
			Route::post('store', 'BranchController@store')->name('branch.store');
			Route::patch('update/{branch}', 'BranchController@update')->name('branch.update');
			Route::get('undo/{branch}', 'BranchController@undo')->name('branch.undo');
		});

		//PAYMENT TYPES MAINTENANCE
		Route::group(['prefix' => 'payment-type'], function () {
			Route::get('/', 'PaymentTypeController@index')->name('payment-type');
			Route::get('create', 'PaymentTypeController@create')->name('payment-type.create');
			Route::get('edit/{payment_type}', 'PaymentTypeController@edit')->name('payment-type.edit');
			Route::post('store', 'PaymentTypeController@store')->name('payment-type.store');
			Route::patch('update/{payment_type}', 'PaymentTypeController@update')->name('payment-type.update');
			Route::get('undo/{payment_type}', 'PaymentTypeController@undo')->name('payment-type.undo');
		});

		//INVENTORY IN/OUT TRANSACTIONS
		Route::group(['prefix' => 'cart'], function () {
			//Cart
			Route::get('purchase/{cart}', 'CartController@purchase')->name('cart.purchase');
			Route::get('check/{client}/{cart}', 'CartController@check')->name('cart.check');
			Route::post('voucher/{cart}', 'CartController@voucher')->name('cart.voucher');

			//Offers-products gallery switch
			Route::get('catalog-switch/{client}/{target_root}', 'CartController@catalogSwitch')->name('cart.catalog-switch');

			//Offers
			Route::get('offers/{client}', 'CartController@offers')->name('cart.offers');
			Route::post('offer-store/{client_id}/{offer_id}', 'CartController@offerStore')->name('cart.offer-store');
			Route::post('offer-update/{cart_id}/{offer_id}', 'CartController@offerUpdate')->name('cart.offer-update');
			Route::get('offer-check/{cart}/{offer_id}', 'CartController@offerCheck')->name('cart.offer-check');
			Route::get('offer-undo/{client_id}/{cart_id}/{offer_id}', 'CartController@offerUndo')->name('cart.offer-undo');

			//Products
			Route::get('products/{client}', 'CartController@products')->name('cart.products');
			Route::post('product-store/{client_id}/{service}', 'CartController@productStore')->name('cart.product-store');
			Route::post('product-update/{supply_id}', 'CartController@productUpdate')->name('cart.product-update');
			Route::get('product-search/{client}', 'CartController@productSearch')->name('cart.product-search');
			Route::get('product-undo/{client}/{cart}/{requisition_id}', 'CartController@productUndo')->name('cart.product-undo');
			Route::get('stock-supplying', 'CartController@StockSupplying')->name('cart.stock-supplying');
			Route::post('stock-supply/{service} ', 'CartController@StockSupply')->name('cart.stock-supply');
			Route::get('supplying-search', 'CartController@supplyingSearch')->name('cart.supplying-search');
		});

		//WORKFLOW TRANSACTIONS
		Route::group(['prefix' => 'task'], function () {
			Route::get('/', 'TaskController@index')->name('task');
			Route::get('manager', 'TaskController@taskManager')->name('task.manager');
			Route::get('inspect/{task}/{requisitions_user_quantity}', 'TaskController@taskInspect')->name('task.inspect');
			Route::get('do/{service_id}/{task_id}/{requisitions_user_quantity}', 'TaskController@do')->name('task.do');
			Route::get('undo/{task_id}/{requisitions_user_quantity}', 'TaskController@undo')->name('task.undo');
			Route::get('redo/{task}', 'TaskController@reDo')->name('task.redo');
		});

		//FACTURACIÓN
		Route::group(['prefix' => 'sale'], function() {
			Route::get('/', 'SaleController@index')->name('sale');
			Route::post('pdf-invoice/{cart}', 'SaleController@pdfInvoice')->name('sale.pdf-invoice');
			Route::post('save-invoice', 'SaleController@saveInvoice')->name('sale.save-invoice');
			Route::get('search/{cart}', 'SaleController@search')->name('sale.search');
		});

		//CAJA
		Route::group(['prefix' => 'cashbox'], function() {
			Route::patch('close', 'SaleController@close')->name('cashbox.close');
			Route::get('detail/{cashbox_id}/{square_id}', 'SaleController@detail')->name('cashbox.detail');
			Route::get('history', 'SaleController@history')->name('cashbox.history');
			Route::get('square', 'SaleController@square')->name('cashbox.square');
			Route::get('data-invoice/{cart}', 'SaleController@dataInvoice')->name('cashbox.data-invoice');
			Route::get('pdf-reprint/{cart}', 'SaleController@pdfReprint')->name('cashbox.pdf-reprint');
			Route::get('nullify-invoice/{cart}', 'SaleController@nullifyInvoice')->name('cashbox.nullify-invoice');
		});
	});
});

//DEMO
Route::get('demo', 'DemoController@demo')->name('demo');

//SQL LOG
DB::listen(function($sql) {
    Log::info($sql->sql);
    Log::info($sql->bindings);
    //Log::info($sql->time);
});


