<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Clientes;
use App\Cotizaciones;
use App\Materiales;
use App\Datos;
use App\Grupos;
use App\Servicios;
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
        $servicios=Servicios::regresarServiciosNoCotizacion($id_cot);
        $serviciosCotizacion=Servicios::serviciosCotizacion($id_cot);
        $individuales=Materiales::individualesCotizacion($id_cot);//materiales cotizacion
        $noIndividuales=Materiales::regresarMaterialesNoCotizacion($id_cot);//materiales no en coti

        return response()->json(array("grupos_cotizacion" => $gruposCotizacion, "gpo_noCot" => $gpo_noCotizacion, "materiales" => $materiales, "servicios" => $servicios, "serviciosCotizacion" => $serviciosCotizacion, "individuales" => $individuales, "noIndividuales" => $noIndividuales));
    }

    public function removerGrupoCotizacion(Request $request){
        Cotizaciones::removerGrupoCotizacion($request);
        $gruposCotizacion=Cotizaciones::regresaGruposCotizacion($request->input("id_cot"));
        $gpo_noCotizacion=Cotizaciones::regresarGruposNoCotizacion($request->input("id_cot"));
        return response()->json(array("grupos_cotizacion" => $gruposCotizacion, "gpo_noCot" => $gpo_noCotizacion));

    }

    public function cotizacionPDF($id){
        $listado=Cotizaciones::listadoPDF($id);
        //dd($listado[0]->mensajes);
        $total=Cotizaciones::getTotal($id);
        $datos=Datos::first();
        $servicios=Servicios::serviciosCotizacion($id);
        $individuales=Materiales::individualesCotizacion($id);
        if (count($servicios)>0) {
            $total[0]->total+=$servicios->sum('c_p');
        }
        if (count($individuales)>0) {
            $total[0]->total+=$individuales->sum('c_p');
        }
        $i=0;
        $cotizacion=Cotizaciones::find($id);

        $vista=view('PDF/cotizacionPDF', compact('cotizacion', 'listado', 'i', 'total', 'datos', 'servicios', 'individuales'));
        $pdf = \App::make('dompdf.wrapper');
        $pdf->loadHTML($vista);
        return $pdf->stream('Cotizacion'.$cotizacion->folio.'.pdf'); 
    }

    public function detalladoPDF($id){
        $listado=Cotizaciones::listadoPDF($id);
        $total=Cotizaciones::getTotal($id);
        $datos=Datos::first();
        $servicios=Servicios::serviciosCotizacion($id);
        $individuales=Materiales::individualesCotizacion($id);
        if (count($servicios)>0) {
            $total[0]->total+=$servicios->sum('c_p');
        }
        if (count($individuales)>0) {
            $total[0]->total+=$individuales->sum('c_p');
        }
        $i=0;
        $cotizacion=Cotizaciones::find($id);

        //dd($listado);

        $vista=view('PDF/detalladoPDF', compact('cotizacion', 'listado', 'i', 'total', 'datos', 'servicios', 'individuales'));
        $pdf = \App::make('dompdf.wrapper');
        $pdf->loadHTML($vista);
        $pdf->setPaper('letter');
        return $pdf->stream('Cotizacion'.$cotizacion->folio.'.pdf'); 
    }

    public function agregarGrupoCotizacion(Request $request){
        $vacio=Cotizaciones::agregarGrupoCotizacion($request);
        $gruposCotizacion=Cotizaciones::regresaGruposCotizacion($request->input("id_cot"));
        $gpo_noCotizacion=Cotizaciones::regresarGruposNoCotizacion($request->input("id_cot"));
        return response()->json(array("grupos_cotizacion" => $gruposCotizacion, "gpo_noCot" => $gpo_noCotizacion, "vacio" => $vacio));
    }

    public function agregarServicioCotizacion(Request $request){
        $vacio=Servicios::agregarServicioCotizacion($request);
        $serviciosNo=Servicios::regresarServiciosNoCotizacion($request->input("id_cot"));
        $servicios=Servicios::serviciosCotizacion($request->input("id_cot"));
        return response()->json(array("serviciosNo" => $serviciosNo, "servicios" => $servicios));
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

    public function actualizarCantidadGrupo(Request $request){
        Cotizaciones::actualizarCantidadGrupo($request);
        $gruposCotizacion=Cotizaciones::regresaGruposCotizacion($request->input("id_cot"));
        $gpo_noCotizacion=Cotizaciones::regresarGruposNoCotizacion($request->input("id_cot"));
        return response()->json(array("grupos_cotizacion" => $gruposCotizacion, "gpo_noCot" => $gpo_noCotizacion));
    }

    public function removerServicioCotizacion(Request $request){
        Cotizaciones::removerServicioCotizacion($request);
        $serviciosNo=Servicios::regresarServiciosNoCotizacion($request->input("id_cot"));
        $servicios=Servicios::serviciosCotizacion($request->input("id_cot"));
        return response()->json(array("serviciosNo" => $serviciosNo, "servicios" => $servicios));

    }

    public function removerIndividualCotizacion(Request $request){
        $id_cot=$request->input("id_cot");
        Cotizaciones::removerIndividualCotizacion($request);
        $individuales=Materiales::individualesCotizacion($id_cot);//materiales cotizacion
        $noIndividuales=Materiales::regresarMaterialesNoCotizacion($id_cot);//materiales no en coti
        return response()->json(array("individuales" => $individuales, "noIndividuales" => $noIndividuales));

    }

    public function agregarIndividualCotizacion(Request $request){
        $id_cot=$request->input("id_cot");
        Cotizaciones::agregarIndividualCotizacion($request);
        $individuales=Materiales::individualesCotizacion($id_cot);//materiales cotizacion
        $noIndividuales=Materiales::regresarMaterialesNoCotizacion($id_cot);//materiales no en coti
        return response()->json(array("individuales" => $individuales, "noIndividuales" => $noIndividuales));
    }

    public function prueba($id){
        $mats = Cotizaciones::where('id', $id)->with(['grupos' => function ($q) use ($id) { 
            $q->with(['materialesDetalle' => function ($query) use ($id) {
                $query->wherePivot('id_cotizacion', $id);
            }]);
        }])->get();

        dd($mats[0]->grupos[0]);

        return $mats;
    }

    public function actualizarCantidadDetalle(Request $request){
        Cotizaciones::actualizarCantidadDetalle($request);
        $gruposCotizacion=Cotizaciones::regresaGruposCotizacion($request->input("id_cot"));
        $gpo_noCotizacion=Cotizaciones::regresarGruposNoCotizacion($request->input("id_cot"));
        return response()->json(array("grupos_cotizacion" => $gruposCotizacion, "gpo_noCot" => $gpo_noCotizacion));
    }
}



