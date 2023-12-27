    public function index()
    {
        $payment_types = Payment_type::where('active', true)->get();
        $cart = Cart::where("purchased", true)->where('invoiced', false)->orderBy("id", "desc")->first();
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