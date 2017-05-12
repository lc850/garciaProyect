<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Clientes;

class clientesController extends Controller
{
    public function index(){
    	return view('clientes/clientes');
    }

    public function obtenerClientes(){
    	$clientes=Clientes::regresarClientes();
    	return response()->json(array("clientes" => $clientes));
    }

    public function registrarCliente(Request $request){
    	Clientes::nuevo($request);
    	$clientes=Clientes::regresarClientes();
    	return response()->json(array("clientes" => $clientes));
    }

    public function removerCliente(Request $request){
        Clientes::eliminarCliente($request->input('id'));
        $clientes=Clientes::regresarClientes();
    	return response()->json(array("clientes" => $clientes));
    }

    public function actualizarCliente(Request $request){
        Clientes::actualizarCliente($request);
        $clientes=Clientes::regresarClientes();
    	return response()->json(array("clientes" => $clientes));
    }
}
