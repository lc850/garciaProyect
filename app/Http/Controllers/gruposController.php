<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Grupos;
use App\Tipos;
use App\Materiales;
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
    	$materiales=materiales_grupos::regresarMaterialesNoGrupo($id);
    	return response()->json(array("materiales_grupo" => $materiales_grupo, "materiales" => $materiales));
    }

    public function removerMaterialGrupo(Request $request){
    	$mat_gpo=materiales_grupos::find($request->input('id'));
    	$mat_gpo->delete();
    	$materiales_grupo=materiales_grupos::obtenerMaterialesGrupo($request->input('id_gpo'));
    	$materiales=materiales_grupos::regresarMaterialesNoGrupo($request->input('id_gpo'));
    	return response()->json(array("materiales_grupo" => $materiales_grupo, "materiales" => $materiales));
    }

    public function agregarMaterialGrupo(Request $request){
    	materiales_grupos::nuevo($request->input('id_mat'), $request->input('id_gpo'), $request->input('cantidad'));
    	$materiales_grupo=materiales_grupos::obtenerMaterialesGrupo($request->input('id_gpo'));
    	$materiales=materiales_grupos::regresarMaterialesNoGrupo($request->input('id_gpo'));
    	return response()->json(array("materiales_grupo" => $materiales_grupo, "materiales" => $materiales));
    }

    public function existeNombreGrupo(Request $request){
        $grupo=Grupos::where('descripcion', '=', $request->input('descripcion'))->get();
        return count($grupo);
    }


}
