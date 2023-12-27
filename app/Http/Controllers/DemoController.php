<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Cart;
use Carbon\carbon;

class DemoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function demo( Cart $cart )
    {

$serverName = 'GTI-ANALI-02';
$uid = 'biotime';
$pwd = 'biotimedos21';
$databaseName = 'zkbiotime';
$connectionInfo = array( 'UID'=>$uid,'PWD'=>$pwd,'Database'=>$databaseName);
$conn = sqlsrv_connect($serverName,$connectionInfo);
if($conn){echo 'conectado!'; }else{echo 'Connection failure<br />';die(print_r(sqlsrv_errors(),TRUE));}


        //return view('models.demo');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $url = "/automation/offer-send";
        $authorized_service = Service::wherehas('role.user', function ($query){
            $query->where('user_id', auth()->user()->id);
        })->where('route', $url)->first();

return $authorized_service;

        if (!$authorized_service) {
            abort(403);
        }
        return "next";
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show( $tipo_certificado, $numero_verificacion, $operador ) //Request $request
    {


        //$operador =  $request->nombre;
        //$numero_verificacion = $request->numero_verificacion;

        $data['tipo_certificado'] =  $tipo_certificado;
        $data['numero_verificacion'] =  $numero_verificacion;
        $data['operador'] =  $operador;


        return view('models.sale.certificado', $data );
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
