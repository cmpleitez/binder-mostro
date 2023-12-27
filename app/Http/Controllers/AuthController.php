<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class AuthController extends Controller
{
    public function auth()
    {
        if (Auth::check()) {
        	return view('forestLayout');
    	} else {
    		return view('forestLogin');
    	}
    }

    public function forestRegister()
    {
    	return view('forestRegister');
    }

    public function forestLogin()
    {
    	return view('forestLogin');
    }
}
