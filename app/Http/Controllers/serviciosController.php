<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Servicios;

class serviciosController extends Controller
{
    public function index(){
    	return view('servicios/servicios');
    }

    public function obtenerServicios(){
    	$servicios=Servicios::regresarServicios();
    	return $servicios;
    }

    public function existeNombreServicio(Request $request){
        $grupo=Servicios::where('nombre', '=', $request->input('nombre'))->get();
        return count($grupo);
    }

    public function registrarServicio(Request $request){
    	Servicios::registrarServicio($request);
    	$servicios=Servicios::regresarServicios();
    	return response()->json($servicios);
    }

    public function lastcodeServicio(Request $request){
    	$codigo=Servicios::ultimoCodigoServicio($request);
    	return $codigo;
    }

    public function removerServicio(Request $request){
        Servicios::eliminarServicio($request->input('id'));
        $servicios=Servicios::regresarServicios();
    	return response()->json($servicios);
    }

    public function actualizarServicio(Request $request){
        Servicios::actualizarServicio($request);
        $servicios=Servicios::regresarServicios();
    	return response()->json($servicios);
    }
}
