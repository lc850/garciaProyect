<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Clientes;
use App\Cotizaciones;
use App\Materiales;
use App\Datos;
use App\Grupos;
use Carbon\Carbon;
use DB;
use PDF;

class cotizacionesController extends Controller
{
    public function index(){
		$date = Carbon::now();
    	return view('cotizaciones/cotizaciones');
    }

    public function obtenerCotizaciones(){
    	$cotizaciones=Cotizaciones::regresarCotizaciones();
    	$clientes=Clientes::regresarClientes();
    	return response()->json(array("cotizaciones" => $cotizaciones, "clientes" => $clientes));
    }

    public function registrarCotizacion(Request $request){
    	Cotizaciones::registrarCotizacion($request);
    	$cotizaciones=Cotizaciones::regresarCotizaciones();
    	$clientes=Clientes::regresarClientes();
    	return response()->json(array("cotizaciones" => $cotizaciones, "clientes" => $clientes));
    }

    public function removerCotizacion(Request $request){
        Cotizaciones::eliminarCotizacion($request->input('id'));
        $cotizaciones=Cotizaciones::regresarCotizaciones();
    	return response()->json($cotizaciones);
    }

    public function actualizarCotizacion(Request $request){
        Cotizaciones::actualizarCotizacion($request);
        $cotizaciones=Cotizaciones::regresarCotizaciones();
    	return response()->json($cotizaciones);
    }

    public function detalleCotizacion($id){
        $cotizacion=Cotizaciones::find($id);
        return view('cotizaciones/detalleCotizaciones', compact('cotizacion'));
    }

    public function gruposCotizacion(Request $request){
        $id_cot=$request->input('id');
        $materiales=Materiales::regresarMateriales();
        $gruposCotizacion=Cotizaciones::regresaGruposCotizacion($id_cot);
        $gpo_noCotizacion=Cotizaciones::regresarGruposNoCotizacion($id_cot);
        return response()->json(array("grupos_cotizacion" => $gruposCotizacion, "gpo_noCot" => $gpo_noCotizacion, "materiales" => $materiales));
    }

    public function removerGrupoCotizacion(Request $request){
        Cotizaciones::removerGrupoCotizacion($request);
        $gruposCotizacion=Cotizaciones::regresaGruposCotizacion($request->input("id_cot"));
        $gpo_noCotizacion=Cotizaciones::regresarGruposNoCotizacion($request->input("id_cot"));
        return response()->json(array("grupos_cotizacion" => $gruposCotizacion, "gpo_noCot" => $gpo_noCotizacion));

    }

    public function cotizacionPDF($id){
        $listado=Cotizaciones::listadoPDF($id);
        $total=Cotizaciones::getTotal($id);
        $datos=Datos::first();
        $i=0;
        $cotizacion=Cotizaciones::find($id);

        //dd($cotizacion);

        $vista=view('PDF/cotizacionPDF', compact('cotizacion', 'listado', 'i', 'total', 'datos'));
        $pdf = \App::make('dompdf.wrapper');
        $pdf->loadHTML($vista);
        return $pdf->stream('Cotizacion'.$cotizacion->folio); 
    }

    public function agregarGrupoCotizacion(Request $request){
        $vacio=Cotizaciones::agregarGrupoCotizacion($request);
        $gruposCotizacion=Cotizaciones::regresaGruposCotizacion($request->input("id_cot"));
        $gpo_noCotizacion=Cotizaciones::regresarGruposNoCotizacion($request->input("id_cot"));
        return response()->json(array("grupos_cotizacion" => $gruposCotizacion, "gpo_noCot" => $gpo_noCotizacion, "vacio" => $vacio));
    }

    public function removerMaterialCotizacion(Request $request){
        Cotizaciones::removerMaterialCotizacion($request);
        $gruposCotizacion=Cotizaciones::regresaGruposCotizacion($request->input("id_cot"));
        $gpo_noCotizacion=Cotizaciones::regresarGruposNoCotizacion($request->input("id_cot"));
        return response()->json(array("grupos_cotizacion" => $gruposCotizacion, "gpo_noCot" => $gpo_noCotizacion));
    }

    public function agregarMaterialGrupoCotizacion(Request $request){
        Cotizaciones::agregarMaterialGrupoCotizacion($request);
        $gruposCotizacion=Cotizaciones::regresaGruposCotizacion($request->input("id_cot"));
        $gpo_noCotizacion=Cotizaciones::regresarGruposNoCotizacion($request->input("id_cot"));
        return response()->json(array("grupos_cotizacion" => $gruposCotizacion, "gpo_noCot" => $gpo_noCotizacion));
    }

    public function existeMaterialGrupo(Request $request){
        $b=0;
        $b=Cotizaciones::existeMaterialGrupo($request);
        return $b;
    }

    public function ajusteCotizacion($id){
        $cotizacion=Cotizaciones::find($id);
        return view('cotizaciones/cotizacionPDF', compact('cotizacion'));
    }

    public function guardarMensajes($id, Request $request){
        Cotizaciones::guardarMensajes($id, $request);
        return redirect('/ajusteCotizacion/'.$id);
    }

    public function prueba($id){
        $mats=Cotizaciones::where('id', $id)->with('grupos')->get();
        dd($mats);
        return $mats;
    }
}



