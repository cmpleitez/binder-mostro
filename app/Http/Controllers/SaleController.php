<?php
namespace App\Http\Controllers;
use App\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Arr;
use DB;
use PDF;
use Illuminate\Support\Facades\Storage;

use App\Requisition;
use App\requisition_user;
use App\Cart;
use App\Payment_type;
use App\Square;
use App\Cashbox;
use App\Option;
use App\Service;
use App\Offer;
use App\User;
use App\Stock;

class SaleController extends Controller
{
    public function index()
    {
        $payment_types = Payment_type::where('active', true)->get();
        $cart = Cart::where("purchased", true)->where('invoiced', false)->orderBy("id", "asc")->first();
        if(!$cart) {
            toastr()->info("Aún no tienes ordenes pendientes de facturar");
            return back();
        }
        $cart_id = $cart->id;
        $items = requisition::whereHas('cart', function($query1) use($cart_id) {
            $query1->where(['cart_id'=>$cart_id, 'invoiced'=>false]);
        })->whereHas('service', function($query2) {
            $query2->where('billable', true);
        })->where('active', true)->with('user')->with('offer')->with('cart.client')->with('service.service_type')->orderby('id', 'asc')->get();
        $items_quantity =  $items->count();
        
        if ($items) {
            foreach ($items as $key => $item) {
                if ( $item->user->count()>0 ) { //Si la actividad ha sido procesada: ya que en el modelo se define el filtro processed = true and active = true
                    $items[$key] = array_add($item,'selected', true);
                } else {
                    $items[$key] = array_add($item,'selected', false);
                }
            }
            return view("models.sale.index", compact("items", "payment_types", "cart", "items_quantity"));
        } else {
            toastr()->info("Aún no tienes ordenes pendientes de facturar");
            return back();
        }
    }

    public function dataInvoice( Cart $cart ) {
        $cartHasItems = Requisition::where([ 'cart_id'=>$cart->id, 'active'=>true])->count();
        if ( $cartHasItems==0 ) {
            toastr()->warning('La factura solicitada no se encuentra disponible');
            return back();
        }
        $data =  invoiceItems( $cart, true );
        return view('models.sale.data_invoice', $data);
    }

    public function pdfReprint( Cart $cart ){
        //GATHERING INVOICE ITEMS
        $data =  invoiceItems( $cart, true );

        //CREATING PREVIEW
        Return PDF::loadView('models.sale.pdf_invoice', $data)->stream('previa.pdf');
    }

    public function pdfInvoice( Request $request, Cart $cart ) {
        //VALIDACIÓN
        if (!$request->item) {
            toastr()->warning("Aún no ha elegido items para facturar");
            return back();
        }

        //GATHERING OFFERS ITEMS
        foreach ($request->item as $key => $item_id) {
            $item = Requisition::where('id',$item_id)->whereHas('service', function($q1){
                $q1->where('billable', true);
            })->first();
            if ($item) {
                $offer = offer::find($item->offer_id);
                if ($item->offer_id !== 1) {
                    $offer_items[$key] = array_add($offer, 'item_id', $item->id);
                    $offer_items[$key] = array_add($offer, 'quantity', $item->supply_quantity);
                    if ($item->supply_detail) {
                        $offer_items[$key] = array_add($offer, 'request', $offer->offer.': '.$item->supply_detail);
                    } else {
                        $offer_items[$key] = array_add($offer, 'request', $offer->offer);
                    }
                    $offer_items[$key] = array_add($offer, 'charge', $item->requisition_charge);
                    $offer_items[$key] = array_add($offer, 'value', $item->supply_quantity * $item->requisition_charge);
                }
            }
        }
        if (isset($offer_items)) {
            $offer_items = collect($offer_items);
            $offer_items = $offer_items->groupBy('id');
            $data['offers_items'] =  $offer_items;
        }

        //GATHERING PRODUCTS ITEMS
        foreach ($request->item as $key => $item_id) {
            $item = Requisition::find( $item_id );
            $offer = offer::find($item->offer_id);
            if ($item->offer_id == 1) {
                if ($item->supply_detail) {
                    $item_request = $item->service->service.': '.$item->supply_detail;
                } else {
                    $item_request =  $item->service->service;
                }
                $product_items[] = [
                    'item_id'=>$item->id,
                    'offer_id'=>$item->offer_id,
                    'quantity' => $item->supply_quantity,
                    'request' =>  $item_request,
                    'charge' => $item->supply_charge,
                    'value' => $item->supply_quantity * $item->supply_charge,
                ];
            }
        }
        if (isset($product_items)) {
            $data['product_items'] = $product_items;
        }

        //GATHERING GENERAL DATA
        $requisition = Requisition::where('cart_id', $cart->id)->with('cart.client.branch')->first();
        $order = [
            'dui' => $requisition->cart->client->dui,
            'nrc' =>  $requisition->cart->client->nrc,
            'nit' => $requisition->cart->client->nit,
            'phone_number' => $requisition->cart->client->phone_number,
            'email' => $requisition->cart->client->email,
            'name' => $requisition->cart->client->name,
            'amount' => $requisition->cart->amount,
            'order_id'=>$requisition->cart->id,
            'branch' => $requisition->cart->client->branch->branch,
            'payment_type_id' => $request->payment_type_id,
            'created_at' => $requisition->cart->created_at,
        ];
        $data['order'] = $order;

        //CREATING PREVIEW
        
        //return view('models.sale.pdf_invoice', $data); //para depurar la vista

        $pdf_content = PDF::loadView('models.sale.pdf_invoice', $data)->output();
        Storage::disk('public')->put('invoice.pdf', $pdf_content);
        return view('models.sale.view_pdf_embebed', $data);
    }

    public function saveInvoice( Request $request ) {
        DB::beginTransaction();
        try {
            //ITEMS
            foreach($request->item_id as $item_id) {
                $requisition = Requisition::find($item_id);
                $requisition->invoiced = 1;
                if ($requisition->save()) {} else {
                    toastr()->warning("Ocurrió un error cuando intentaba facturar el item", "Item N°: ".$requisition->id, [ 'timeOut' => 30000 ]);
                    return back();
                }
            }

            //UPDATTING SQUARE ID
            $square = Square::where('user_id', auth()->user()->id)->whereHas('cart', function($query){
                $query->where('closed', false);
            })->first();
            if (!$square) {
                $square = new Square;
                $square->user_id = auth()->user()->id;
                if(!$square->save()){
                    return back()->with('warning', 'Falló el intento de crear un nuevo cuadre');
                }
            }

            //CART
            $cart = Cart::find($requisition->cart_id);
            $cart->invoiced = true;
            $cart->square_id = $square->id;
            $cart->payment_type_id = $request->payment_type_id;
            if (!$cart->save()) {
                toastr()->warning("Ocurrió un error cuando intentaba facturar la orden", "Orden N°: ".$cart->id, [ 'timeOut' => 30000 ]);
                return back();
            }

            //GUARDANDO
            DB::commit();
            toastr()->success("Proceso se completó efectivamente");
            $pending_invoices = Cart::where('invoiced', false)->count();
            if ($pending_invoices>0) {
                toastr()->info("Se mostrará la siguiente orden pendiente de facturar");
                return redirect()->route('sale');
            } else {
                toastr()->info("Ya no hay ordenes pendientes de facturar");
                return redirect()->route('cart.offers', auth()->user()->id);
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

    public function search(Request $request, Cart $cart) {
        $data_search = $request->search;
        $payment_types = Payment_type::where('active', true)->get();
        $items = requisition::search($data_search)->whereHas('cart', function($query1) {
            $query1->where('invoiced', false);
        })->whereHas('service', function($query2) {
            $query2->where('billable', true);
        })->where('active', true)->with('user')->with('offer')->with('cart.client')->with('service.service_type')->orderby('id', 'asc')->get();
        $items_quantity =  $items->count();
        if ($items_quantity>0) {
            foreach ($items as $key => $item) {
                if ( $item->user->count()>0 ) { //Si la actividad ha sido procesada: ya que en el modelo se define el filtro processed = true and active = true
                    $items[$key] = array_add($item,'selected', true);
                } else {
                    $items[$key] = array_add($item,'selected', false);
                }
            }
            return view("models.sale.index", compact("items", "payment_types", "cart", "items_quantity"));
        } else {
            toastr()->info("La factura que solicita aún no ha sido registrada o ya fué procesada");
            return back();
        }
    }

    public function square() {
        //LECTURA DE FACTURAS
        $payment_types = Payment_type::where('active', true)->get();
        $cashbox_id = auth()->user()->id;
        $square = Square::where('user_id', $cashbox_id)->whereHas('cart', function($query){
                $query->where('closed', false);
        })->first();
        if( $square ) { //Lectura de cajas pendientes
        } else {
            toastr()->info("No hay cajas pendientes de cerrar");
            return redirect()->route('cart.offers', auth()->user()->id);
        }
        $invoices = Cart::where(['invoiced'=>true, 'closed'=>false])->whereHas('requisition', function($query1){ //Lectura de facturas pendientes
                $query1->where(['active'=>true]);
        })->whereHas('square', function($query2){
            $query2->where('user_id', auth()->user()->id);
        })->with('requisition')->get();
        if($invoices) {
            $total_monto = $invoices->sum('amount');
            $total_impuestos = $invoices->sum('tax');
            $str_tax_included = Option::where('id', 2)->where('active', true)->first();
            $boolean_tax_included =  (boolean) $str_tax_included->value;
            if ($boolean_tax_included) {
                $total_cierre = $total_monto;
            } else {
                $total_cierre = $total_monto + $total_impuestos;
            }

            //AGRUPANGO FACTURAS SEGÚN TIPO DE PAGO
            foreach ($payment_types as $key => $payment_type) {
                $data[$payment_type->id] = $invoices->where('payment_type_id', $payment_type->id);
            }

            //RESULTADO A
            return view('models.sale.square', compact('data', 'payment_types', 'total_monto', 'total_impuestos', 'total_cierre', 'square', 'cashbox_id', 'boolean_tax_included'));
        } else {

            //RESULTADO B
            toastr()->info("Aún no hay facturas pendientes de cerrar");
            return redirect()->route('cart.offers', auth()->user()->id);
        }
    }

    public function detail( $cashbox_id, $square_id ) {
        $square = Square::where('id', $square_id)->with('cart')->get();
        $cashbox_id = auth()->user()->id;
        $payment_types = Payment_type::where('active', true)->get();
        $payment_types_plucked = $payment_types->pluck('id');
        $carts_history = Square::find($square_id)->cart()->where('invoiced', true)->whereIn('payment_type_id', $payment_types_plucked)->with('requisition')->get();
        if($carts_history->count()>0) {
            $total_monto = $carts_history->sum('amount');
            $total_impuestos = $carts_history->sum('tax');
            $str_tax_included = Option::where('id', 2)->where('active', true)->first();
            $boolean_tax_included =  (boolean) $str_tax_included->value;
            if ($boolean_tax_included) {
                $total_cierre = $total_monto;
            } else {
                $total_cierre = $total_monto + $total_impuestos;
            }
            foreach ($payment_types as $payment_type) {
                $carts_by_payment_type = $carts_history->where('payment_type_id', $payment_type->id);
                $data[$payment_type->id] = $carts_by_payment_type;
            }
            return view('models.sale.history_square', compact('data', 'cashbox_id', 'payment_types', 'total_monto', 'total_impuestos', 'total_cierre', 'square', 'boolean_tax_included'));
        } else {
            toastr()->info("Aún no se han utilizado las cajas registradoras");
            return back();
        }
    }

    public function close(Request $request) {
        //VALIDACION
        $request->validate([
            'clave' => 'required|min:4|max:255',
        ]);

        //AUTORIZACION
        $operador_autorizado = hotAuthorizationService($request->clave, 55, 2);

        //PROCESO
        if($operador_autorizado){
            $resultado = closePendingCarts();
            if($resultado) {
                toastr()->success("Se ha efectuado efectivamente el cierre de caja", "CIERRE DE CAJA", [ 'timeOut' => 30000 ]);
                return redirect()->route('cart.offers', auth()->user()->id);
            } else {
                toastr()->warning("Falló el intento de cerrar caja", "CIERRE DE CAJA" , [ 'timeOut' => 30000 ]);
                return back();
            }
        } else {
            toastr()->error("Acceso denegado, consulte con su administrador", "CIERRE DE CAJA", [ 'timeOut' => 30000 ]);
            return back();
        };
    }

    public function history( Request $request) {
        $solicitud = collect($request);
        if (!$solicitud->count()) {
            $fecha_inicial = date ( 'Y.m.d' );
            $fecha_final = date ( 'Y.m.d' );
        } else {
            $fecha_inicial =  date('Y.m.d', strtotime(Str::before($request->periodo, '-')));
            $fecha_final =  date('Y.m.d', strtotime(Str::after($request->periodo, '-')));
        }
        $periodo = $request->periodo;
        $data['cashboxes'] = User::whereHas('requisition.cart', function($q1) use($fecha_inicial, $fecha_final){
           $q1->whereDate('created_at', '>=', $fecha_inicial)->whereDate('created_at', '<=', $fecha_final)->where('invoiced', 1);
        })->whereHas('square')->with('square.cart')->paginate(16);
        return view('models.sale.history', $data, compact('periodo'))->with('warning', 'No se dispone de facturas para el periodo solicitado');
    }

    public function nullifyInvoice( Cart $cart ) {
        $cart_requisitions =  Requisition::where('cart_id', $cart->id)->get();
        $user_message = __("An error occurred ask for technical support");
        DB::beginTransaction();
        try {
            //Revirtiendo las existencias en el inventario
            foreach ($cart_requisitions as  $item) {
                $stock = Stock::where('service_id', $item->service_id)->first();
                $stock->stock_quantity = $stock->stock_quantity + $item->supply_quantity;
                if (!$stock->save()) {
                    $user_message = __('An error occured when it tries revert inventory item: ').$item->id.__('Please update your technical advisor');
                }
            }

            //Anulando los items de la factura
            foreach ($cart_requisitions as $item) {
                $item->active =  0;
                if (!$item->save()) {
                    $user_message = __('An error occured when it tries to nullify the item: ').$item->id.__('Please update your technical advisor');
                }
            }

            //Guardando los cambios
            DB::commit();
            toastr()->success('La factura ha sido anulada');
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
}
