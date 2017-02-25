<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ejemploController extends Controller
{
    public function index(){
    	return view('formularioGeneral');
    }
}
