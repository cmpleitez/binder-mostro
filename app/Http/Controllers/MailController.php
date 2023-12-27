<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Mail;

use App\User;
use App\Cart;
use App\Requisition;
use App\Offer;

class MailController extends Controller
{
    public function store( Request $request, User $client, Cart $cart )
    {
        //VALIDACIÓN
        if (!$client->email_verified_at) {
            toastr()->warning("El destinatario aún no ha confirmado su correo", $client->name, [ 'timeOut' => 30000 ]);
            return back();
        }

        //LECTURA DE VARIABLES
        $mensaje = $request->mensaje;
        $cart_id = $cart->id;

        //RECOPILANDO LOS DATOS DE LA ORDEN
        $data = invoiceItems( $cart, false );

        //ENVIO
        Mail::Send('models.slices.offer_email_message', $data, function($m) use ($client, $mensaje){
            $m->to($client->email, $client->name)->subject($mensaje);
        });
        toastr()->success("Oferta enviada", "Con atención a: ".$client->name, [ 'timeOut' => 30000 ]);
        return back();
    }
}
