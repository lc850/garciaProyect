<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Materiales;
use DB;


class materialesController extends Controller
{
    public function index(){
    	return view('materiales/materiales');
    }

    public function obtenerMateriales(){
    	$materiales=Materiales::regresarMateriales();
    	return response()->json($materiales);
    }

    public function lastcodeMaterial(Request $request){
        $material=Materiales::where('codigo', 'like', $request->input('codigo').'%')
        ->orderby('codigo','desc')
        ->first();

        if (!isset($material)) {
            if (strcmp ($request->input('codigo').'%' , '3%' ) == 0)
                return response()->json('3000');
            else if (strcmp ($request->input('codigo').'%' , '2%' ) == 0)
                return response()->json('2000');
            else if (strcmp ($request->input('codigo').'%' , '1%' ) == 0)
                return response()->json('1000');
        }
        
        return response()->json($material->codigo);
    }

    public function registrarMaterial(Request $request){
        $codigo=$request->input('codigoMaterial');
        $existe=DB::table('materiales')
                    ->where('codigo', '=', $codigo)
                    ->count();
        if($existe>0){
            return 0;
        }
        else{
            Materiales::registrarMaterial($request);
            $materiales=Materiales::regresarMateriales();
    		return response()->json($materiales);
        }
    }

    public function actualizarMaterial(Request $request){
        Materiales::actualizarMaterial($request);
        $materiales=Materiales::regresarMateriales();
    	return response()->json($materiales);
    }

    public function removerMaterial(Request $request){
        Materiales::eliminarMaterial($request->input('id'));
        $materiales=Materiales::regresarMateriales();
    	return response()->json($materiales);
    }
}
