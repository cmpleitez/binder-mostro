<?php
use App\Cart;
use App\Requisition;
use App\Offer;
use App\Option;
use App\request_user;
use App\User;
use App\Role;
use App\Service;
use App\Branch;
use App\Square;
use App\Stock;

//COLD AUTHORIZATIONS SERVICE
function authorizationService( $service_id ) {
   $authorized_service = Service::wherehas('role.user', function ($query){
        $query->where('user_id', auth()->user()->id);
    })->where('id', $service_id)->first();
    if ($authorized_service) {
        $authorized = 1;
    } else {
        $authorized = 0;
    }
    return $authorized;
}

//HOT AUTHORIZATION SERVICE
function hotAuthorizationService($plaintext_password, $service_id, $role_id) {
    if(empty($plaintext_password)) {
        return false;
    }
    $authorities = User::whereHas('role', function($query) use($role_id){
        $query->where('role_id', $role_id);
    })->where('active', true)->get();
    if ($authorities->count()==0) {
        return false;
    } else {
        foreach ($authorities as $authority) {
            $hash = $authority->password;
            $password_verified = password_verify($plaintext_password, $hash);
            if ($password_verified) {
                return true;
            }
        }
    }
    return false;
}

//INVOICE - CONTROL PANEL
function invoicedControlPanel( $item_id ) {
    $service_code = '';
    if (authorizationService(60)) {
        $service_code .= '
            <a href="/cashbox/data-invoice/'.$item_id.'" title="Click para ver factura">
                <div class="badge-circle badge-circle-light-primary badge-circle-md">
                    <i class="livicon-evo" data-options="name: box.svg; style: solid; size: 25px; solidColor: #5A8DEE;">
                    </i>
                </div>
            </a>
        ';
    }

    if (authorizationService(100)) {
        $ruta = "'/cashbox/nullify-invoice/".$item_id."'";
        $service_code .= '
            <a href="#"  title="Click para anular" onclick="confirmar( '.$ruta.' );return false;">
                <div class="badge-circle badge-circle-light-danger badge-circle-md">
                    <i class="livicon-evo" data-options="name: multiply-alt.svg; style: solid; size: 25px; solidColor: #FF5B5C;"></i>
                </div>
            </a>
        ';
    }
    return $service_code;
}

//PROFILE - CONTROL PANEL
function profileControlPanel() {
    $service_code = '';
    $cart = Cart::where('client_id', auth()->user()->id)->where('purchased', 0)->first();
    $service_code .= '
        <a class="dropdown-item" href="/task"><i class="bx bx-check-square mr-50"></i>Mis actividades</a>
        <div class="dropdown-divider mb-0"></div>
    ';
    if (authorizationService(58)) {
        $service_code .= '
            <a class="dropdown-item" href="/cashbox/square"><class="bx bx-check-square mr-50"></i>Caja</a>
            <div class="dropdown-divider mb-0"></div>
        ';
    }
    return $service_code;
}

//CASHBOX  HISTORY - CONTROL PANEL
function cashBoxHistoryControlPanel( $cashbox_id, $square ) {
    $service_code = '';
    if (authorizationService(57)) {
        if ($square->closed) { $back_color = "rgb(223, 236, 255)"; } else { $back_color = "#ffdede"; }
        $service_code .= '
             <a href="/cashbox/detail/'.$cashbox_id.'/'.$square->id.'">
                <div class="align-items-center mb-2 pb-1 shadow-sm" style="background-color: '.$back_color.' " >
                    <div class="text-center"><i class="livicon-evo" data-options="name: coins.svg; style: solid; size: 100%; strokeStyle: round; strokeColor: #05a6ff; fillColor: #dcb369; solidColor: #5698e3; solidColorBgAction: #fcfc79; colorsOnHover: lighter"></i>
                    </div>
                    <div class="text-center pl-1 pr-1" style="font-size: 0.9rem; font-weight-bold;">
                        '.$square->updated_at->format('d/m/Y h:m:s').'
                    </div>
                </div>
            </a>
        ';

    } else {
        $service_code .= '
             <div class="align-items-center " style="background-color: rgb(223, 236, 255);">
                <div class="text-center"><i class="livicon-evo" data-options="name: coins.svg; style: solid; size: 100%; strokeStyle: round; strokeColor: #05a6ff; fillColor: #dcb369; solidColor: #5698e3; solidColorBgAction: #fcfc79; solidColorBg: #fcd9cd;"></i>
                </div>
                <div class="text-center pl-1 pr-1" style="font-size: 0.85rem; font-weight-bold;">
                    '.$created_at.'
                </div>
             </div>
        ';
    }
    return $service_code;
}

//REQUISITION - CONTROL PANEL
function taskControlPanel($service_id, $task, $requisition_user_quantity) {
    $service_code = "";
    if (authorizationService(35)) {
        if ($task->processed) {
            $service_code .= "
            <div class='tablero-iconos'>
                <a href='/task/do/".$service_id."/".$task->id."/".$requisition_user_quantity."'><i class='badge-circle badge-circle-light-primary badge-circle-md bx bxs-flag-alt font-large-1'></i></a>
            </div>
            ";
        } else {
            $service_code .= "
            <div class='tablero-iconos'>
                <a href='/task/do/".$service_id."/".$task->id."/".$requisition_user_quantity."'><i class='badge-circle badge-circle-light-warning badge-circle-md bx bxs-flag-alt font-large-1'></i></a>
            </div>
            ";
        }
    }
    if (authorizationService(29)) {
        if ($task->active) {
            $service_code .= "
            <div class='tablero-iconos'>
                <a href='/task/undo/".$task->id."/".$requisition_user_quantity."'><i class='badge-circle badge-circle-light-primary badge-circle-md bx bx-caret-up font-large-1'></i></a>
            </div>
            ";
        } else {
            $service_code .= "
            <div class='tablero-iconos'>
                <a href='/task/undo/".$task->id."/".$requisition_user_quantity."'><i class='badge-circle badge-circle-light-warning badge-circle-md bx bx-caret-down font-large-1'></i></a>
            </div>
            ";
        }
    }
    if (authorizationService(30)) {
        $service_code .= "
        <div class='tablero-iconos'>
            <a href='/task/redo/".$task->id."'><i class='badge-circle badge-circle-light-secondary badge-circle-md bx bx-redo font-large-1'></i></a>
        </div>
        ";
    }
    if (authorizationService(31)) {
        if ($task->inspected) {
            $service_code .= "
            <div class='tablero-iconos'>
                <a href='/task/inspect/".$task->id."/".$requisition_user_quantity."'><i class='badge-circle badge-circle-light-primary badge-circle-md bx bxs-check-shield font-large-1'></i></a>
            </div>
            ";
        } else {
            $service_code .= "
            <div class='tablero-iconos'>
                <a href='/task/inspect/".$task->id."/".$requisition_user_quantity."'><i class='badge-circle badge-circle-light-warning badge-circle-md bx bxs-check-shield font-large-1'></i></a>
            </div>
            ";
        }
    }
    return $service_code;
}

//USER - CONTROL PANEL
function createUserControl() {
    $service_code = "";
    if (authorizationService(5)) {
        $service_code .= "<a href='/user/create'><i class='badge-circle badge-circle-primary badge-circle-md bx bxs-plus-circle font-medium-5'></i></a>";
    }
    return $service_code;
}

function userControlPanel($user) {
    $service_code = "";
    if (authorizationService(33)) {
        $service_code .= "
            <a href='/cart/offers/".$user->id."'>
                <div class='tablero-iconos'>
                    <i class='badge-circle badge-circle-light-primary badge-circle-lg bx bxs-cart font-large-1'></i>
                </div>
            </a>
        ";
    }
    if (authorizationService(31)) {
        $service_code .= "
            <a href='/task/its/".$user->id."'>
                <div class='tablero-iconos'>
                    <i class='badge-circle badge-circle-light-primary badge-circle-lg bx bx-task font-large-1'></i>
                </div>
            </a>
        ";
    }
    if (authorizationService(8)) {
        $service_code .= "
        <a href='/user/bind/".$user->id."'>
            <div class='tablero-iconos'>
                <i class='badge-circle badge-circle-light-primary badge-circle-lg bx bxs-briefcase-alt-2 font-large-1'></i>
            </div>
        </a>
        ";
    }
    if (authorizationService(6)) {
        $service_code .= "
                <a href='/user/edit/".$user->id."'>
                    <div class='tablero-iconos'>
                        <i class='badge-circle badge-circle-light-warning badge-circle-lg bx bxs-edit-alt font-large-1'></i>
                    </div>
                </a>
        ";
    }
    if (authorizationService(7)) {
        if($user->active) {
            $service_code .= "
                <a href='/user/undo/".$user->id."'>
                    <div class='tablero-iconos'>
                        <i class='badge-circle badge-circle-light-primary badge-circle-lg bx bx-check font-large-1'></i>
                    </div>
                </a>
            ";
        } else {
            $service_code .= "
                <a href='/user/undo/".$user->id."'>
                    <div class='tablero-iconos'>
                        <i class='badge-circle badge-circle-light-danger badge-circle-lg bx bx-x font-large-1'></i>
                    </div>
                </a>
            ";
        }
    }
    return $service_code;
}

//ROLE - CONTROL PANEL
function createRoleControl() {
    $service_code = "";
    if (authorizationService(11)) {
        $service_code .= "<a href='/role/create/'><i class='badge-circle badge-circle-primary badge-circle-md bx bxs-plus-circle font-medium-5'></i></a>";
    }
    return $service_code;
}
function roleControlPanel($role) {
    $service_code = "";
    if (authorizationService(13)) {
        $service_code .= "
        <div class='tablero-iconos'>
            <a href='/role/bind/".$role->id."'><i class='badge-circle badge-circle-light-primary badge-circle-lg bx bxs-briefcase-alt-2 font-large-1'></i></a>
        </div>
        ";
    }
    if (authorizationService(14)) {
        if ($role->active==true) {
            $service_code .= "
            <div class='tablero-iconos'>
                <a href='/role/undo/".$role->id."'><i class='badge-circle badge-circle-light-primary badge-circle-lg bx bx-check font-large-1'></i></a>
            </div>
            ";
        } else {
            $service_code .= "
            <div class='tablero-iconos'>
                <a href='/role/undo/".$role->id."'><i class='badge-circle badge-circle-light-warning badge-circle-lg bx bx-x font-large-1'></i></a>
            </div>
            ";
        }
    }
    $service_code .= "<div>";
    return $service_code;
}

//OFFER - CONTROL PANEL
function createOfferControl() {
    $service_code = "";
    if (authorizationService(16)) {
        $service_code .= "
            <a href='/offer/create/'><i class='badge-circle badge-circle-primary badge-circle-md bx bxs-plus-circle font-medium-5'></i></a>
        ";
    }
    return $service_code;
}
function offerControlPanel($offer) {
    $service_code = "";
    if (authorizationService(17)) {
        $service_code .= "
        <div class='tablero-iconos'>
            <a href='/offer/edit/".$offer->id."'><i class='badge-circle badge-circle-light-danger badge-circle-lg bx bxs-edit-alt font-large-1'></i></a>
        </div>
        ";
    }
    if (authorizationService(18)) {
        $service_code .= "
        <div class='tablero-iconos'>
            <a href='/offer/bind/".$offer->id."'><i class='badge-circle badge-circle-light-primary badge-circle-lg bx bxs-gift font-large-1'></i></a>
        </div>
        ";
    }
    if (authorizationService(19)) {
        if ($offer->active) {
            $service_code .= "
            <div class='tablero-iconos'>
                <a href='/offer/undo/".$offer->id."'><i class='badge-circle badge-circle-light-primary badge-circle-lg bx bx-check font-large-1'></i></a>
            </div>
            ";
        } else {
            $service_code .= "
            <div class='tablero-iconos'>
                <a href='/offer/undo/".$offer->id."'><i class='badge-circle badge-circle-light-warning badge-circle-lg bx bx-x font-large-1'></i></a>
            </div>
            ";
        }
    }
    $service_code .= "</div>";
    return $service_code;
}

//SERVICE - CONTROL PANEL
function createServiceControl() {
    $service_code = "";
    if (authorizationService(25)) {
        $service_code .= "
            <a href='/service/create/'><i class='badge-circle badge-circle-primary badge-circle-md bx bxs-plus-circle font-medium-5'></i></a>
        ";
    }
    return $service_code;
}
function serviceControlPanel($service) {
    $service_code = "";
    if (authorizationService(26)) {
        $service_code .= "
        <div class='tablero-iconos'>
            <a href='/service/edit/".$service->id."'><i class='badge-circle badge-circle-light-warning badge-circle-lg bx bxs-edit-alt font-large-1'></i></a>
        </div>
        ";
    }
    if (authorizationService(27)) {
        if ($service->active) {
            $service_code .= "
            <div class='tablero-iconos'>
                <a href='/service/undo/".$service->id."'><i class='badge-circle badge-circle-light-primary badge-circle-lg bx bx-check font-large-1'></i></a>
            </div>
            ";
        } else {
            $service_code .= "
            <div class='tablero-iconos'>
                <a href='/service/undo/".$service->id."'><i class='badge-circle badge-circle-light-warning badge-circle-lg bx bx-x font-large-1'></i></a>
            </div>
            ";
        }
    }
    return $service_code;
}

//BRANCH - CONTROL PANEL
function createBranchControl() {
    $service_code = "";
    if (authorizationService(21)) {
        $service_code .= '
            <a href="/branch/create">
                <i class="badge-circle badge-circle-primary badge-circle-md bx bxs-plus-circle font-medium-5"></i>
            </a>
        ';
    }
    return $service_code;
}
function branchControlPanel( $branch_id ) {
    $branch = Branch::find($branch_id);
    $service_code = "";
    if (authorizationService(22)) {
        $service_code .= '
            <div class="tablero-iconos">
                <a href="/branch/edit/'.$branch_id.'"><i class="badge-circle badge-circle-light-warning badge-circle-lg bx bxs-edit-alt font-large-1"></i></a>
            </div>
        ';
    }
    if (authorizationService(23)) {
        if($branch->active == true) {
            $service_code .= '
                <div class="tablero-iconos">
                    <a href="/branch/undo/'.$branch_id.'"><i class="badge-circle badge-circle-light-primary badge-circle-lg bx bx-check font-large-1"></i></a>
                </div>
            ';
        } else {
            $service_code .= '
                <div class="tablero-iconos">
                    <a href="/branch/undo/'.$branch_id.'"><i class="badge-circle badge-circle-light-warning badge-circle-lg bx bx-x font-large-1"></i></a>
                </div>
            ';
        }
    }
    return $service_code;
}

//SUPERVISION - CONTROL PANEL
function supplyingControlPanel() {
    $service_code = '';
    if (authorizationService(36)) {
        $service_code .= '
            <a href="/task/supplies">
                <button type="reset" class="btn btn-light-primary mr-1 mb-1">Abastecimiento de productos</button>
            </a>
        ';
    }
    return $service_code;
}

//INVOICE REVIEW - CONTROL PANEL
function dataInvoiceControlPanel( $cart_id ) {
    $service_code = '';
    if (authorizationService(61)) {
        $service_code .= '<a href="/cashbox/pdf-reprint/'.$cart_id.'" )}}">
                <div class="invoice-action-btn">
                    <button class="btn btn-primary btn-block invoice-send-btn">
                        <i class="bx bx-send"></i>
                        <span>Re-imprimir</span>
                    </button>
                </div>
        </a>';
    }
    if (authorizationService(64)) {
        $service_code .= "<a href='#'>
                <div class='invoice-action-btn'>
                    <button class='btn btn-primary btn-block invoice-send-btn'>
                        <i class='bx bx-send'></i>
                        <span>Enviar</span>
                    </button>
                </div>
        </a>";
    }
    if (authorizationService(65)) {
        $service_code .= "<a href='#'>
            <div class='invoice-action-btn'>
                <button class='btn btn-light-primary btn-block'>
                    <span>Descargar</span>
                </button>
            </div>
        </a>";
    }
    return $service_code;
}

//TIPOS DE PAGO - CONTROL PANEL
function createPaymentTypeControl() {
    $service_code = "";
    if (authorizationService(53)) {
        $service_code .= "
            <a href='/payment-type/create/'><i class='badge-circle badge-circle-primary badge-circle-md bx bxs-plus-circle font-medium-5'></i></a>";
    }
    return $service_code;
}
function paymentTypeControlPanel($payment_type) {
    $service_code = '';
    if (authorizationService(54)) {
        $service_code .= '
            <div class="tablero-iconos">
                <a href="/payment-type/edit/'.$payment_type->id.'"><i class="badge-circle badge-circle-light-warning badge-circle-lg bx bxs-edit-alt font-large-1"></i></a>
            </div>
        ';
    }
    if (authorizationService(23)) {
        if($payment_type->active == true) {
            $service_code .= '
                <div class="tablero-iconos">
                    <a href="/payment-type/undo/'.$payment_type->id.'"><i class="badge-circle badge-circle-light-primary badge-circle-lg bx bx-check font-large-1"></i></a>
                </div>
            ';
        } else {
            $service_code .= '
                <div class="tablero-iconos">
                    <a href="/payment-type/undo/'.$payment_type->id.'"><i class="badge-circle badge-circle-light-warning badge-circle-lg bx bx-x font-large-1"></i></a>
                </div>
            ';
        }
    }
    return $service_code;
}

//WHATSAPP - CHAT
function whatsappChat() {
    $branch = Branch::whereHas("user", function ($query) {
            $query->where("id", auth()->user()->id);
    })->first();
    $service_code = '
        <a  class="chat-demo-button shadow" href="https://wa.me/'.$branch->phone_number.'/?text=Buen%20día" target="_blank">
            <img class="img-fluid" src="/../../img/WhatsApp_Logo_2.png" width="60" height="auto">
        </a>
    ';
    return $service_code;
}

//CART HEADDING PROCESSING
function cart_headding_processing($client_id) {

    //CREATING-READING CART
    $requested_cart = Cart::where('client_id', $client_id)->where('purchased', 0)->count();
    if ($requested_cart == 0) {
        $cart = Cart::create([
            'client_id'     => $client_id,
            'amount'        => 0,
            'tax'           => 0,
        ]);
    } else {
        $cart = Cart::where('client_id', $client_id)->where('purchased', 0)->first();
    }
    return $cart;
}

//CART SUMMARY PROCESSING
function cart_summary_processing($cart_id) {
    //CART REQUISITION
    $requisitions_exists = Requisition::where('cart_id', $cart_id)->where('offer_id', '<>', 1)->count();
    if($requisitions_exists>0) {
        $offers = Offer::whereHas('requisition', function($query) use($cart_id) {
            $query->where('cart_id', $cart_id)->where('offer_id', '<>', 1);
        })->get();
        foreach ($offers as $key => $offer) {
            $requisition = Requisition::where('cart_id', $cart_id)->where('offer_id', $offer->id)->first('requisition_amount');
            $offers[$key] = array_add($offer,'requisition_amount', $requisition->requisition_amount);
        }
        $requisition_amount = $offers->sum('requisition_amount');
    } else {
        $requisition_amount = 0;
    }
    
    //CART CUSTOM REQUISITION
    $custom_requisitions_exists = Requisition::where('cart_id', $cart_id)->where('offer_id', '=', 1)->count();
    if($custom_requisitions_exists>0) {
        $custom_requisition = Requisition::where('cart_id', $cart_id)->where('offer_id', 1)->get();
        $custom_requisition_amount = $custom_requisition->sum('requisition_amount');
    } else {
        $custom_requisition_amount=0;
    }
    
    //CART AMOUNT
    $new_cart_amount = $requisition_amount + $custom_requisition_amount;
    if ($new_cart_amount==0) {
        $user_message = 'Your cart is now update'.', your current amount: '.$new_cart_amount.' ( Taxes didn´t include in )';
    } else {
        $cart = Cart::find($cart_id);
        $str_tax_percent = Option::where('id', 1)->where('active', true)->first();
        $str_tax_included = Option::where('id', 2)->where('active', true)->first();
        $float_tax_percent =  (float) $str_tax_percent->value;
        $boolean_tax_included =  (boolean) $str_tax_included->value;
        $cart->amount = $new_cart_amount;
        if ($boolean_tax_included) {
            $cart->tax = $new_cart_amount/(($float_tax_percent/100)+1) * ($float_tax_percent/100);
            $user_message = 'Your cart is now update'.', your current amount: '.$new_cart_amount.' ( Taxes didn´t include in )';
        } else {
            $cart->tax = $new_cart_amount * ($float_tax_percent/100);
            $user_message = 'Your cart is now update'.', your current amount: '.$new_cart_amount.' ( Taxes didn´t include in )';
        }
        $cart->save();
    }
    toastr()->success($user_message);
}

function closePendingCarts() {
    $pending_carts = Cart::whereHas('requisition', function($request1){
        $request1->where('active', true);
    })->whereHas('square', function($request2){
        $request2->where(['user_id'=>auth()->user()->id, 'closed'=>false]);
    })->where(['closed'=>false,  'invoiced'=>true])->get();
    DB::beginTransaction();
    try {
        $resultado = true;
        foreach ($pending_carts as $pending_cart) {
            $pending_cart->closed = 1;
            $pending_cart->save();
            if(!$pending_cart->save()){
                $resultado = false;
            }
        }
        $square = Square::find($pending_cart->square_id);
        $square->closed = 1 ;
        if(!$square->save()){
            $resultado = false;
        }
        DB::commit();
        return $resultado;
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

function localMoneyFormat($number) {
    $outcome = "$ ".number_format($number, 2);
    return $outcome;
}

function itemInventory( $requested_quantity, $offer, $service, $transaction_type, $into_cart_quantity ) {
    $stock = Stock::where('service_id', $service->id)->first();
    if ($stock) {
    } else {
        $titulo = strtoupper($offer->offer).": ".$service->service;
        toastr()->warning(__("Exceeds stock").". Cantidad disponible 0", $titulo , [ 'timeOut' => 30000 ]);
        return false;
    }
    if ( $transaction_type=='storing' ) {
        $requested_quantity = $into_cart_quantity + $requested_quantity;
    }
    if( $requested_quantity > $stock->stock_quantity ) {
        $titulo = strtoupper($offer->offer).": ".$service->service;
        toastr()->warning(__("Exceeds stock").". Disponible: ".$stock->stock_quantity." Solicitado: ".$requested_quantity, $titulo, [ 'timeOut' => 30000 ]);
        return false;
    }
    return true;
}

//CART - CONTROL PANEL
function cartCheckControlPanel($client, $cart) {
    $service_code = '';
    if (authorizationService(36)) {
        $service_code .= '
            <button type="button" class="btn btn-light-primary ml-1" data-toggle="modal" data-target="#exampleModalScrollable">
                <i class="bx bx-mail-send"></i>
                Enviar cotización
            </button>
        ';
    }
    return $service_code;
}

//OFFERS - CONTROL PANEL
function OffersControlPanel() {
    $service_code = '';
    if (authorizationService(62)) {
        $service_code .= '
            <div class="row" style="margin-bottom: 0.7rem;">
                <input type="number" class="touchspin-color touchspin-min-max form-control" name="supply_quantity" value="1">
            </div>
            <button type="submit" class="btn btn-primary shadow display-3">'.__("Add").'</button>
        ';
    }
    return $service_code;
}

//PRODUCTS - CONTROL PANEL
function ProductsControlPanel() {
    $service_code = '';
    if (authorizationService(32)) {
        $service_code .= '
            <button type="submit" class="btn btn-primary shadow display-3">'.__('Add').'</button>
        ';
    }
    return $service_code;
}

//CLIENT - CONTROL PANEL
function ClientControlPanel( $client_name ) {
    $service_code = '';
    if (authorizationService(4)) {
        $service_code .= '
            <li class="nav-item my-auto pr-1" style="color:rgb(220,220,220) !important;">'.$client_name.'</li>
            <li class="nav-item my-auto">
                <a class="nav-link" href="/user">
                    <i class="livicon-evo" data-options=" name: user.svg; style: solid; size: 2rem; solidColor: #61adfe; solidColorAction: #dff30c; colorsOnHover: custom; strokeStyle: round; strokeWidth: 1; keepStrokeWidthOnResize: true "></i>
                </a>
            </li>
            <li class="nav-item my-auto">
                <a class="nav-link" href="/user/create">
                    <i class="livicon-evo" data-options=" name: plus-alt.svg; style: solid; size: 2rem; solidColor: #61adfe; solidColorAction: #dff30c; colorsOnHover: custom; strokeStyle: round; strokeWidth: 1; keepStrokeWidthOnResize: true; solidColorBg: #1a233a; solidColorBgAction: #1a233a;"></i>
                </a>
            </li>
        ';
    }
    return $service_code;
}

function invoiceItems( $cart, $invoiced ) {
    //GATHERING OFFERS ITEMS
    $offers = offer::where('active', 1)->get(['id', 'offer', 'charge']);
    foreach ($offers as $key => $offer) {
        $item = Requisition::where( 'cart_id', $cart->id )->whereHas( 'service', function($q1) {
            $q1->where('billable', true);
        } )->where( 'offer_id', $offer->id )->where( 'invoiced', $invoiced )->where('active', true)->orderBy( 'created_at' )->first();
        if ($item) {
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

    //GATHERING PRODUCTS ITEMS
    $items = Requisition::where(['cart_id'=>$cart->id, 'offer_id'=>1, 'invoiced'=>$invoiced])->orderBy('created_at')->with('service')->get();
    foreach ($items as $key => $item) {
        if ($item->supply_detail) {
            $item_request = $item->service->service.': '.$item->supply_detail;
        } else {
            $item_request =  $item->service->service;
        }
        $product_items[] = [
            'item_id'=>$item->id,
            'quantity' => $item->supply_quantity,
            'request' =>  $item_request,
            'charge' => $item->supply_charge,
            'value' => $item->supply_quantity * $item->supply_charge,
        ];
    }

    //GATHERING ORDER DATA
    $requisition = Requisition::where(['cart_id'=>$cart->id, 'active'=>true])->with('cart.client')->with('cart.client.branch')->first();
    $order = [
        'dui'=>$requisition->cart->client->dui,
        'nrc' =>  $requisition->cart->client->nrc,
        'nit' => $requisition->cart->client->nit,
        'phone_number' => $requisition->cart->client->phone_number,
        'email' => $requisition->cart->client->email,
        'name' => $requisition->cart->client->name,
        'amount' => $requisition->cart->amount,
        'order_id'=>$requisition->cart->id,
        'branch' => $requisition->cart->client->branch->branch,
        'payment_type_id' => $requisition->cart->payment_type_id,
        'created_at' => $requisition->cart->created_at,
    ];

    //INTEGRATTING GATHERED DATA
    if ( isset($offer_items ) ){
        $data['offer_items'] = $offer_items;
    }
    if ( isset($product_items) ){
        $data['product_items'] = $product_items;
    }
    $data['order'] = $order;
    $data['cart'] = $cart;

    //RETURN
    return $data;
}

/*
//XXX - CONTROL PANEL
function createServiceControl() {
    $service_code = "";
    if (authorizationService(25)) {
        $service_code .= "<a href='/service/create/'><i class='badge-circle badge-circle-light-primary badge-circle-lg bx bxs-plus-circle font-large-1'></i></a>";
    }
    return $service_code;
}
function xxxControlPanel($xxx) {
    $service_code = '';
    if (authorizationService(999)) {
        $service_code .= '';
    }
    return $service_code;
}
{!! xxxControlPanel($xxx) !!}
*/
