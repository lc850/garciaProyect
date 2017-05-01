<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Grupos;
use App\Tipos;
use App\materiales_grupos;
use DB;

class gruposController extends Controller
{
    public function index(){
    	return view('grupos/grupos');
    }

    public function obtenerGrupos(){
    	$grupos=Grupos::regresarGrupos();
    	$tipos=Tipos::regresarTipos();
    	return response()->json(array("grupos" => $grupos, "tipos" => $tipos));
    }

    public function removerGrupo(Request $request){
        Grupos::eliminarGrupo($request->input('id'));
        $grupos=Grupos::regresarGrupos();
    	return response()->json($grupos);
    }

    public function registarGrupo(Request $request){
    	Grupos::registrarGrupo($request);
    	$grupos=Grupos::regresarGrupos();
    	$tipos=Tipos::regresarTipos();
    	return response()->json(array("grupos" => $grupos, "tipos" => $tipos));
    }

    public function actualizarGrupo(Request $request){
        Grupos::actualizarGrupo($request);
        $grupos=Grupos::regresarGrupos();
    	$tipos=Tipos::regresarTipos();
    	return response()->json(array("grupos" => $grupos, "tipos" => $tipos));
    }

    public function materialesGrupo($id){
    	$grupo=Grupos::find($id);
    	return view('grupos/materialesGrupos', compact('grupo'));
    }

    public function obtenerMaterialesGrupo($id){
    	$materiales_grupo=materiales_grupos::obtenerMaterialesGrupo($id);
    	return response()->json($materiales_grupo);
    }
}
