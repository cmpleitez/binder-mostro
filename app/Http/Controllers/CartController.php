<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;

use App\User;
use App\Offer;
use App\Cart;
use App\Requisition;
use App\requisition_user;
use App\Option;
use App\Service;
use App\Stock;
use App\branch_service;
use App\role;
use App\roleService;

use DB;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class CartController extends Controller
{
    public function voucher( Request $request, Cart $cart )
    {
        //VALIDATION
        $request->validate([
            'voucher' => 'required|min:25|max:3070',
        ]);

        //PROCESSING
        if ($request->hasfile('voucher')) {
            $cart->voucher = $request->file('voucher')->store('public/voucher');
        }

        //RESULTS
        if (!$cart->save()) {
            toastr()->warning("Falló el intento de adjuntar el comprobante a la compra/venta");
            return back();
        };

        //SETTING IMAGE STANDART
        if (!$request->hasfile('voucher')) {
            toastr()->warning("Falló el intento de renderizar la imagen a los estándares del sistema");
            return back();
        };
        $image = Image::make(Storage::get($cart->voucher));
        $image->widen(800)->encode();
        Storage::put($cart->voucher, (string) $image);
        toastr()->success("El comprobante ha sido adjuntado efectivamente");
        return back();
    }

    public function supplyingSearch( Request $request ) {
        $services = Service::where('active', true)->Where('service_type_id', 2)->orwhere('service_type_id', 3)->Search($request->search)->orderBy('service_type_id', 'desc')->with('stock')->paginate(10);
        return view("models.cart.stock_supplying", compact('services'));
    }

    public function StockSupply(Request $request, Service $service) {
        DB::beginTransaction();
        try {
            //REGISTRANDO
            $supply = branch_service::where('branch_id', auth()->user()->branch_id)->where('service_id', $service->id)->where('active', true)->orderBy('id', 'desc')->first();
            if (!$supply) {
                $new_stock_quantity = $request->supply_quantity;
            } else {
                $new_stock_quantity = $supply->stock_quantity + $request->supply_quantity;
            }
            $branch_service                                      = new branch_service();
            $branch_service->branch_id                 = auth()->user()->branch_id;
            $branch_service->service_id                 = $service->id;
            $branch_service->cost                           = $service->cost;
            $branch_service->supplied_quantity  = $request->supply_quantity;
            $branch_service->stock_quantity        = $new_stock_quantity;
            $branch_service->income                     = true;
            $branch_service->save();

            //ABASTECIENDO
            $stock = Stock::where('branch_id', auth()->user()->branch_id)->where('service_id', $service->id)->first();
            if(!$stock) {
                $stock = new Stock();
                $stock->branch_id = auth()->user()->branch_id;
                $stock->service_id = $service->id;
            }
            $stock->stock_quantity = $new_stock_quantity;
            $stock->save();

            //ASEGURANDO
            DB::commit();
            toastr()->success("El producto ha sido abastecido", $service->service, [ 'timeOut' => 20000 ]);
            return back();
         } catch (\Exception $e) {
            DB::rollback();
            toastr()->error("Ocurrió un error inesperado por favor reporte al área técnica", "Error", [ 'timeOut' => 30000 ]);
            return back();
        } catch (\Throwable $e) {
            DB::rollback();
            toastr()->error("Ocurrió un error inesperado por favor reporte al área técnica", "Error", [ 'timeOut' => 30000 ]);
            return back();
        } catch (\ModelNotFoundException $exception) {
            DB::rollback();
            toastr()->error("Ocurrió un error inesperado por favor reporte al área técnica", "Error", [ 'timeOut' => 30000 ]);
            return back();
        }
    }

    public function StockSupplying() {
        $services = Service::where('active', true)->where('service_type_id', 2)->orwhere('service_type_id', 3)->orwhere('service_type_id', 4)->orderBy('service_type_id', 'desc')->with('stock')->paginate(12);
        return view('models.cart.stock_supplying', compact('services'));
    }

    public function check(User $client, Cart $cart)
    {
        $cart_id = $cart->id;
        $orders_total = 0;
        $offers = Offer::whereHas('requisition', function($query) use ($cart_id) {
            $query->where('cart_id', $cart_id);
        })->where('active', true)->orderBy('updated_at', 'desc')->get();
        foreach ($offers as $key=>$offer) {
            $requisition = Requisition::where('cart_id', $cart_id)->where('offer_id', $offer->id)->first();
            if ($offer->id==1) {
                $offer->charge = Requisition::where(['cart_id'=>$cart_id, 'offer_id'=>1])->where('service_id', '!=',  88)->sum('requisition_amount');
                $orders[$key] = array_add($offer, 'order_quantity', 1);
            } else {
                $orders[$key] = array_add($offer, 'order_quantity', $requisition->supply_quantity);
            }
            $orders[$key] = array_add($offer, 'offer_id', $offer->id);
            $orders[$key] = array_add($offer, 'order_detail', $requisition->supply_detail);
            $order_value = $offer->charge * $offer->order_quantity;
            $orders_total += $order_value;
        }
        $orders = collect($orders);
        return view('models.cart.check', compact('client', 'cart', 'orders', 'orders_total'));
    }
    
    public function purchase(Cart $cart)
    {
        DB::beginTransaction();
        try {
            //READDING VARIABLES
            $cart_id = $cart->id;
            $first_requisition = Requisition::whereHas('cart', function($q1) use($cart_id){
                $q1->where('cart_id', $cart_id);
            })->first();

            //ASSIGNING TASKS (RANDOM MODE)
            $requisitions = Requisition::whereHas('service', function($q){
                $q->where('service_type_id', 2)->orWhere('service_type_id', 3);
            })->where('cart_id', $cart_id)->get();
            foreach ( $requisitions as $requisition ) {
                $service_id = $requisition->service_id;
                $owner_operators= User::whereHas('role.service', function($q2) use ($service_id) { //Readding owner operators
                    $q2->where('service_id', $service_id);
                })->where('id','<>', 1)->get();
                if ( $owner_operators->count()>0 ) { //Assigning task to owner operator
                    $choosen_operator = $owner_operators->random();
                    $requisition_user = new requisition_user();
                    $requisition_user->user_id = $choosen_operator->id;
                    $requisition_user->requisition_id = $requisition->id;
                    $requisition_user->branch_id = $choosen_operator->branch_id;
                    $requisition_user->area_id = $choosen_operator->area_id;
                    if(!$requisition_user->save()){
                        toastr()->warning("Falló el intento de asignar servicios de paga al operador propietario", strtoupper($requisition->offer->offer).": ".$requisition->service->service, [ 'timeOut' => 30000 ]);
                        return back();
                    }
                    $choosen_operators[] = $choosen_operator;
                } else {
                    toastr()->warning( __("None user is assigned for service"), strtoupper($requisition->offer->offer).": ".$requisition->service->service, [ 'timeOut' => 30000 ]);
                    return back();
                }
            }

            //INVENTORY UPDATTING
            $requisitions = Requisition::whereHas('cart', function($query1) use($cart_id) {
                $query1->where('cart_id', $cart_id);
            })->get();
            foreach ($requisitions as $requisition) {
                $service = Service::find($requisition->service_id);
                if ($service->service_type_id!=1) {
                    $offer =  Offer::find($requisition->offer_id);
                    if ( !itemInventory( $requisition->supply_quantity, $offer, $service, 'purchase', $requisition->supply_quantity ) ) {
                         return back();
                    };
                    $stock = Stock::where('service_id', $requisition->service_id)->with('service')->first();
                    $nuevo_stock = $stock->stock_quantity - $requisition->supply_quantity;
                    $stock->stock_quantity = $nuevo_stock;
                    $stock->save();
                }
            }
            
            //UPDATTING PURCHASED STATUS
            $cart->purchased = 1;
            if(!$cart->save()){
                toastr()->warning("Falló el intento de efectuar la compra", 'ID orden: '.$cart->id, [ 'timeOut' => 10000 ]);
                return back();
            }

            //COMMIT
            DB::commit();
            toastr()->info( "Compra realizada efectivamente");
            return redirect()->route('cart.offers', auth()->user()->id);

        } catch (\Exception $e) {
            DB::rollback();
            toastr()->error("Ocurrió un error inesperado por favor reporte al área técnica", "Error", [ 'timeOut' => 30000 ]);
            return back();
        } catch (\Throwable $e) {
            DB::rollback();
            toastr()->error("Ocurrió un error inesperado por favor reporte al área técnica", "Error", [ 'timeOut' => 30000 ]);
            return back();
        } catch (\ModelNotFoundException $exception) {
            DB::rollback();
            toastr()->error("Ocurrió un error inesperado por favor reporte al área técnica", "Error", [ 'timeOut' => 30000 ]);
            return back();
        }
    }

    public function offers(User $client) {
        $cart = Cart::where('client_id', $client->id)->where('purchased', 0)->first();
        $offers = Offer::has('service')->where('id', '>', 1)->where('active', true)->with('service')->paginate(16);
        $ruta = request()->route()->action['as'];
        return view('models.cart.offers', compact('client', 'cart', 'offers', 'ruta'));
    }

    public function products(User $client) {
        $cart = Cart::where('client_id', $client->id)->where('purchased', 0)->first();
        $services = Service::where('service_type_id', 3)->orWhere('service_type_id', 4)->where('active', true)->orderBy('service', 'asc')->paginate(12);
        $ruta = request()->route()->action['as'];
        return view('models.cart.products', compact('client', 'cart', 'services', 'ruta'));
    }

    public function catalogSwitch( User $client, $target_root ) {
        if ($target_root=='cart.offers') {
            return redirect()->route('cart.products', $client->id);
        }
        if ($target_root=='cart.products' or $target_root=='cart.product-search') {
            return redirect()->route('cart.offers', $client->id);
        }
    }

    public function productSearch( Request $request, User $client ) {
        $cart = Cart::where('client_id', $client->id)->where('purchased', 0)->first();
        $services = Service::where('active', true)->where('service_type_id', 3)->orWhere('service_type_id', 4)->Search($request->search)->with('stock')->orderBy('service', 'desc')->paginate(12);
        $ruta = $ruta = request()->route()->action['as'];
        return view('models.cart.products', compact('client', 'cart', 'services', 'ruta'));
    }

    public function offerCheck(Cart $cart, $offer_id) {
        $client_id = $cart->client_id;
        $orders = Requisition::where('cart_id', $cart->id)->where('offer_id', $offer_id)->whereHas('service', function($query1){
            $query1->where('active', true)->Where('service_type_id', '>=', 3);
        })->with('service')->get();
        return view('models.cart.offer_check', compact('orders', 'client_id'));
    }

    public function offerStore(Request $request, $client_id, $offer_id)
    {
        //VALIDATION
        $validatedData = $request->validate([ //Datos ingresados
            'supply_quantity'  => 'required|gte:1',
            'supply_detail' => 'max:255'
        ]);
        $offer = Offer::find($offer_id); //Inventario
        $offer_products = Offer::find($offer_id)->service()->where('active', true)->get();
        if (!$offer_products) {
            toastr()->warning("Aún no ha enrolado servicios a la oferta o los servicios enrolados han sido dados de baja", "Oferta ID:".$offer_id, [ 'timeOut' => 30000 ]);
            return back();
        }
        foreach ($offer_products as $item) {
            if ($item->service_type_id!=1) {
                $requisition = Requisition::where('service_id', $item->id)->whereHas('cart', function($query) use($client_id) {
                    $query->where('client_id', $client_id)->where('purchased', false);
                })->first();
                if($requisition) {
                    $into_cart_quantity = $requisition->supply_quantity;
                } else {
                    $into_cart_quantity = 0;
                }
                if ( !itemInventory( $request->supply_quantity, $offer, $item, 'storing', $into_cart_quantity ) ) {
                     return back();
                };
            }
        }

        //PROCESSING
        DB::beginTransaction();
        try {

            //CART HEADDING
            $cart = cart_headding_processing($client_id); //Cart Headding
            
            //CART REQUISITION
            $cart_requisition_exists = Requisition::where('cart_id', $cart->id)->where('offer_id', $offer_id)->count();
            $offer = Offer::whereHas('service', function($query) {
                $query->where('active', true);
            })->with('service')->where(['id'=>$offer_id, 'active'=>true])->first();

            if ($cart_requisition_exists>0) { //Requisition update
                $requisition = Requisition::where('cart_id', $cart->id)->where('offer_id', $offer_id)->with('service')->get();
                foreach ($requisition as $key => $supply) {
                    if (!empty($request->supply_detail) and $request->supply_detail!=null){
                        if ($supply->supply_detail!=null) {
                            $supply->supply_detail .= '; ';
                        }
                        $supply->supply_detail .= $request->supply_detail;
                    }
                    $supply->supply_quantity += $request->supply_quantity;
                    if ($supply->service->service_type_id==3 or $supply->service->service_type_id==4) {
                        $supply->requisition_amount = $supply->supply_quantity * $supply->requisition_charge;
                    }
                    if(!$supply->save()){
                        toastr()->warning( "Falló el intento de modificar el item", $service->service, [ 'timeOut' => 30000 ]);
                        return back();
                    }
                };

            } elseif( $cart_requisition_exists==0 ) { //Requisition create
                foreach ($offer->service as $service) {
                    $requisition                        = new requisition();
                    $requisition->cart_id               = $cart->id;
                    $requisition->service_id            = $service->id;
                    $requisition->offer_id              = $offer->id;
                    $requisition->supply_detail         = $request->supply_detail;
                    $requisition->supply_quantity       = $request->supply_quantity;
                    $requisition->supply_cost           = $service->cost;
                    $requisition->supply_charge         = $service->charge;
                    $requisition->requisition_charge    = $offer->charge;
                    $requisition->requisition_amount    = $offer->charge * $request->supply_quantity;
                    if(!$requisition->save()){
                        toastr()->warning( "Falló el intento de agregar el item al carrito", $service->service, [ 'timeOut' => 30000 ]);
                        return back();
                    }
                }
            }

            //CART FOOTER
            $user_message = cart_summary_processing($cart->id);

            //COMITTING
            DB::commit();
            return back();
        } catch (\Exception $e) {
            DB::rollback();
            toastr()->error("Ocurrió un error inesperado por favor reporte al área técnica", "Error", [ 'timeOut' => 30000 ]);
        } catch (\Throwable $e) {
            DB::rollback();
            toastr()->error("Ocurrió un error inesperado por favor reporte al área técnica", "Error", [ 'timeOut' => 30000 ]);
        } catch (\ModelNotFoundException $exception) {
            DB::rollback();
            toastr()->error("Ocurrió un error inesperado por favor reporte al área técnica", "Error", [ 'timeOut' => 30000 ]);
        }
    }

    public function productStore(Request $request, $client_id, Service $service )
    {
        //VALIDATION
        $validatedData = $request->validate([ //Ingreso de datos
            'supply_quantity'  => 'required|gte:1',
            'supply_detail'    => 'nullable|min:4|string',
        ]);
        $offer = Offer::find(1); //Inventario
        $requisition = Requisition::where('service_id', $service->id)->whereHas('cart', function($query) use($client_id) {
            $query->where('client_id', $client_id)->where('purchased', false);
        })->first();
        if($requisition) {
            $into_cart_quantity = $requisition->supply_quantity;
        } else {
            $into_cart_quantity = 0;
        }
        if ( !itemInventory( $request->supply_quantity, $offer, $service, 'storing', $into_cart_quantity ) ) {
             return back();
        };

        //PROCESSING
        DB::beginTransaction();
        try {
            //CART HEADDING
            $cart = cart_headding_processing($client_id);

            //CUSTOM REQUISITION CREATE/UPDATE
            $requisition_supply_exists = Requisition::where('cart_id', $cart->id)->where('offer_id', 1)->where('service_id', $service->id)->count();
            if ($requisition_supply_exists > 0) { //UPDATE
                $requisition_supply = Requisition::where('cart_id', $cart->id)->where('offer_id', 1)->where('service_id', $service->id)->first();
                $requisition_supply->supply_quantity = $requisition_supply->supply_quantity + $request->supply_quantity;
                if (isset($request->supply_detail)){
                    $requisition_supply->supply_detail = $requisition_supply->supply_detail.'; '. $request->supply_detail;
                }
                $requisition_supply->requisition_charge = $requisition_supply->supply_charge * $requisition_supply->supply_quantity;
                $requisition_supply->requisition_amount = $requisition_supply->supply_charge * $requisition_supply->supply_quantity;
                $requisition_supply->save();
            } elseif($requisition_supply_exists==0) { //CREATE
                $requisition = Requisition::create([
                    'cart_id'               => $cart->id,
                    'service_id'            => $service->id,
                    'offer_id'              => 1,
                    'supply_detail'         => $request->supply_detail,
                    'supply_quantity'       => $request->supply_quantity,
                    'supply_cost'           => $service->cost,
                    'supply_charge'         => $service->charge,
                    'requisition_charge'    => $request->supply_quantity * $service->charge,
                    'requisition_amount'    => $request->supply_quantity * $service->charge, //Se usa service por ser el primer registro
                ]);
            }
            //CART SUMMARY
            cart_summary_processing($cart->id);
            DB::commit();
            return back();
        } catch (\Exception $e) {
            DB::rollback();
            toastr()->error("Ocurrió un error inesperado por favor reporte al área técnica", "Error", [ 'timeOut' => 30000 ]);
        } catch (\Throwable $e) {
            DB::rollback();
            toastr()->error("Ocurrió un error inesperado por favor reporte al área técnica", "Error", [ 'timeOut' => 30000 ]);
        }catch (\ModelNotFoundException $exception) {
            DB::rollback();
            toastr()->error("Ocurrió un error inesperado por favor reporte al área técnica", "Error", [ 'timeOut' => 30000 ]);
        }
    }

    public function offerUpdate(Request $request, $cart_id, $offer_id) {
        //VALIDATION
        $validatedData = $request->validate([ //Ingreso de datos
            'order_quantity'  => 'required|gte:1',
            'order_detail'      => 'nullable|min:4'
        ]);
        //PROCESSING
        DB::beginTransaction();
        try {
            $requisition = Requisition::where('cart_id', $cart_id)->where('offer_id', $offer_id)->get();
            $offer = Offer::find($offer_id);
            foreach ($requisition as $supply) {
                $service =  Service::find($supply->service_id);
                if ( $service->service_type_id==2 or $service->service_type_id==3 ) {
                    if ( !itemInventory( $request->order_quantity, $offer, $service, 'updatting', $supply->supply_quantity ) ) {
                        toastr()->warning( "Las unidades solicitadas rebasan el disponible", $supply->offer->offer, [ 'timeOut' => 30000 ] );
                         return back();
                    };
                }
                $supply->supply_quantity = $request->order_quantity;
                $supply->supply_detail = $request->supply_detail;
                $supply->requisition_amount = $supply->requisition_charge * $request->order_quantity;
                if (!$supply->save()){
                    toastr()->warning( "Falló el inento de modificar la oferta solicitada", $supply->offer->offer, [ 'timeOut' => 30000 ] );
                    return back();
                };
            };
            cart_summary_processing($cart_id); //Cart summary
            DB::commit(); //Resultado
            toastr()->success("item actualizada");
            return back();
        } catch (\Exception $e) {
            DB::rollback();
            toastr()->error("Ocurrió un error inesperado por favor reporte al área técnica", "Error", [ 'timeOut' => 30000 ]);
            return back();
        } catch (\Throwable $e) {
            DB::rollback();
            toastr()->error("Ocurrió un error inesperado por favor reporte al área técnica", "Error", [ 'timeOut' => 30000 ]);
            return back();
        }catch (\ModelNotFoundException $exception) {
            DB::rollback();
            toastr()->error("Ocurrió un error inesperado por favor reporte al área técnica", "Error", [ 'timeOut' => 30000 ]);
            return back();
        }
    }

      public function productUpdate(Request $request, $supply_id) {
        //VALIDATION
        $validatedData = $request->validate([ //Ingreso de datos
            'supply_quantity'  => 'required|gte:1',
        ]);
        $requisition = Requisition::findOrFail($supply_id)->first();
        $offer = Offer::find(1);  //Validación del Inventario
        $service =  Service::find($requisition->service_id);
        if ($service->service_type_id==2 or $service->service_type_id==3) {
            if ( !itemInventory( $request->supply_quantity, $offer, $service, 'updatting', $requisition->supply_quantity ) ) {
                 return back();
            };
        }

        //PROCESSING
        DB::beginTransaction();
        try {
            //CART DETAIL
            $supply = Requisition::find($supply_id);
            $supply->supply_quantity = $request->supply_quantity;
            $supply->supply_detail = $request->supply_detail;
            $supply->requisition_charge = $supply->supply_charge * $request->supply_quantity;
            $supply->requisition_amount = $supply->requisition_charge;
            $supply->save();
            //CART SUMMARY
            $user_message = cart_summary_processing($supply->cart_id);
            DB::commit();
            //USER MESSAGE
            return back()->with('secondary', $user_message);
        } catch (\Exception $e) {
            DB::rollback();
            toastr()->error("Ocurrió un error inesperado por favor reporte al área técnica", "Error", [ 'timeOut' => 30000 ]);
            return back();
        } catch (\Throwable $e) {
            DB::rollback();
            toastr()->error("Ocurrió un error inesperado por favor reporte al área técnica", "Error", [ 'timeOut' => 30000 ]);
            return back();
        }catch (\ModelNotFoundException $exception) {
            DB::rollback();
            toastr()->error("Ocurrió un error inesperado por favor reporte al área técnica", "Error", [ 'timeOut' => 30000 ]);
            return back();
        }
    }

    public function offerUndo( $client_id, $cart_id, $offer_id ) {
        $requisition = Requisition::where('cart_id', $cart_id)->where('offer_id', $offer_id)->get();
        DB::beginTransaction();
        try {
            //UNDOING ITEM
            foreach ($requisition as $supply) {
                $supply->delete();
            }
            //UNDOING CART
            $cart_requisition_exists = Requisition::where('cart_id', $cart_id)->count();
            if ($cart_requisition_exists == 0) {
                $cart = Cart::find($cart_id);
                $cart->delete();
            }
            //RESULTS
            DB::commit();
            if ($cart_requisition_exists == 0) {
                toastr()->warning(__("The whole cart has been succefully deleted"), "CARRETILLA Nº".$cart_id, [ 'timeOut' => 20000 ]);
                return redirect()->route('cart.offers', ['client_id'=>auth()->user()->id]);
            } else {
                toastr()->warning(__("Offer/Product and its services has been succefully deleted"), "OFERTA/PRODUCTO Nº".$offer_id, [ 'timeOut' => 20000 ]);
                return back();
            };
        } catch (\Exception $e) {
            DB::rollback();
            toastr()->error("Ocurrió un error inesperado por favor reporte al área técnica", "Error", [ 'timeOut' => 30000 ]);
            return back();
        } catch (\Throwable $e) {
            DB::rollback();
            toastr()->error("Ocurrió un error inesperado por favor reporte al área técnica", "Error", [ 'timeOut' => 30000 ]);
            return back();
        }catch (\ModelNotFoundException $exception) {
            DB::rollback();
            toastr()->error("Ocurrió un error inesperado por favor reporte al área técnica", "Error", [ 'timeOut' => 30000 ]);
            return back();
        }
    }

    public function productUndo( $client_id, Cart $cart, $requisition_id ) {
        //PROCESSING
        DB::beginTransaction();
        try {
            //UNDOING SUPPLY
            $item_product = Requisition::find($requisition_id);
            $item_product->delete();

            //UNDOING CART
            $item_account = Requisition::where('cart_id', $cart->id)->count();
            if ( $item_account == 0 ) {
                $cart->delete();
            }

            //RESULTADO
            DB::commit();
            if ( $item_account == 0 ) {
                toastr()->success(__("Offer/Product and its items has been succefully deleted"), "ITEM Nº".$requisition_id, [ 'timeOut' => 20000 ]);
                return redirect()->route('cart.offers', $client_id);
            } else {
                toastr()->success(__("Product/Service has been succefully deleted"), "ITEM Nº".$requisition_id, [ 'timeOut' => 20000 ]);
                return back();
            }
        } catch (\Exception $e) {
            DB::rollback();
            toastr()->error("Ocurrió un error inesperado por favor reporte al área técnica", "Error", [ 'timeOut' => 30000 ]);
            return back();
        } catch (\Throwable $e) {
            DB::rollback();
            toastr()->error("Ocurrió un error inesperado por favor reporte al área técnica", "Error", [ 'timeOut' => 30000 ]);
            return back();
        } catch (\ModelNotFoundException $exception) {
            DB::rollback();
            toastr()->error("Ocurrió un error inesperado por favor reporte al área técnica", "Error", [ 'timeOut' => 30000 ]);
            return back();
        }
    }
}