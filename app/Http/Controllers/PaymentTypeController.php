<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;

use App\Payment_type;

class PaymentTypeController extends Controller
{
    public function index()
    {
        $payment_types = Payment_type::where('active', true)->orderBy('id', 'asc')->paginate(10);
        return view('models.payment_type.index', compact('payment_types'));
    }

    public function create()
    {
        $payments_types = payment_type::where('active', true)->get();
        return view('models.payment_type.create', compact('payments_types'));
    }
 
    public function store(Request $request)
    {
        $request->validate([
            'type'                  => 'required|min:4|max:255|unique:payment_types',
            'cashbox_in'      => 'nullable|in:on,off',
        ]);
        $payment_type = (new Payment_type)->fill($request->all());
        $payment_type->type  = $request->type;
        if ($request->cashbox_in == 'on') {
            $payment_type->cashbox_in = true;
        } elseif( $request->cashbox_in == null ) {
            $payment_type->cashbox_in = false;
        }
        if ($payment_type->save()) {
            toastr()->success("El tipo de pago ha sido creado efectivamente", $payment_type->type, [ 'timeOut' => 30000 ]);
            return redirect()->route('payment-type');
        };
        toastr()->warning("Falló el intento de crear el tipo de pago", $payment_type->type, [ 'timeOut' => 30000 ]);
        return back();
    }

    public function edit(Payment_type $payment_type)
    {
        return view('models.payment_type.edit', compact('payment_type'));
    }
 
    public function update(Request $request, Payment_type $payment_type)
    {
        $request->validate([
            'type'          => 'required|min:4|max:255',
            'cashbox_in'    => 'nullable|in:on,off',
        ]);
        $payment_type->type  = $request->type;
        if ($request->cashbox_in == 'on') {
            $payment_type->cashbox_in = true;
        } elseif( $request->cashbox_in == null ) {
            $payment_type->cashbox_in = false;
        }
        if ($payment_type->save()) {
            toastr()->success("El tipo de pago ha sido actualizado efectivamente", $payment_type->type, [ 'timeOut' => 10000 ]);
            return redirect()->route('payment-type');
        };
        toastr()->warning("Falló el intento de actualizar el tipo de pago", $payment_type->type, [ 'timeOut' => 30000 ]);
        return back();
    }
 
    public function undo(Payment_type $payment_type)
    {
        if ($payment_type->active) {
            $payment_type->active = 0;
        } else {
            $payment_type->active = 1;
        }
        if($payment_type->save()){
            toastr()->warning("El estado del tipo de pago ha sido revertido efectivamente", $payment_type->type, [ 'timeOut' => 20000 ]);
            return back();
        }
        toastr()->warning("Falló el intento de revertir el tipo de pago", $payment_type->type, [ 'timeOut' => 30000 ]);
        return back();
    }
}
