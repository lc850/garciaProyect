<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Clientes;
use App\Cotizaciones;
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
        $materialesGrupo=Cotizaciones::regresaGruposCotizacion($id_cot);
        return response()->json($materialesGrupo);
    }

    public function removerGrupoCotizacion(Request $request){
        Cotizaciones::removerGrupoCotizacion($request);
        $materialesGrupo=Cotizaciones::regresaGruposCotizacion($request->input("id_cot"));
        return response()->json($materialesGrupo);
    }

    public function cotizacionPDF($id){
        $listado=Cotizaciones::listadoPDF($id);
        $total=Cotizaciones::getTotal($id);
        $i=0;
        $cotizacion=DB::table('cotizaciones')
            ->where('cotizaciones.id', '=', $id)
            ->join('clientes', 'cotizaciones.id_cliente', '=', 'clientes.id')
            ->select('cotizaciones.*', 'clientes.nombre AS cliente')
            ->first();

        $vista=view('PDF/cotizacionPDF', compact('cotizacion', 'listado', 'i', 'total'));
        $pdf = \App::make('dompdf.wrapper');
        $pdf->loadHTML($vista);
        return $pdf->stream(); 
    }
}
