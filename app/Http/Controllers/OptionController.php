<?php
namespace App\Http\Controllers;

use App\Option;
use Illuminate\Http\Request;
use App\Service;

class OptionController extends Controller
{
    public function index()
    {
        return view('models.configuration.index');
    }
}
