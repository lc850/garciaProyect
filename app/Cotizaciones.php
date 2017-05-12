<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;
use Carbon\Carbon;

class Cotizaciones extends Model
{
    protected $table='cotizaciones';

    public static function regresarCotizaciones(){
    	$cotizaciones=DB::table('cotizaciones')
    		->join('clientes', 'cotizaciones.id_cliente', '=', 'clientes.id')
    		->where('cotizaciones.activo', '=', 1)
    		->select('cotizaciones.*', 'clientes.nombre')
    		->get();
    	return $cotizaciones;
    }

    public static function registrarCotizacion($request){
        $cotizacion= new Cotizaciones();
        $cotizacion->folio=0;
        $cotizacion->descripcion=$request->input('descripcion');
        $cotizacion->id_cliente=$request->input('cliente');
        $cotizacion->fecha=$request->input('fecha');
        $cotizacion->fecha_impresion=$request->input('fecha_impresion');
        $cotizacion->activo=1;
        $cotizacion->save();

        $folio="C".$cotizacion->id;
        $cotizacion->folio=$folio;
        $cotizacion->save();
    }

    public static function eliminarCotizacion($id)
    {
        $cotizaciones=Cotizaciones::find($id);
        $cotizaciones->activo=0;
        $cotizaciones->save();
    }

    public static function actualizarCotizacion($request)
    {
        $cotizacion = Cotizaciones::find($request->input('id'));
            $cotizacion->descripcion = $request->input('descripcion');
            $cotizacion->id_cliente = $request->input('id_cliente');
            $cotizacion->fecha = $request->input('fecha');
            $cotizacion->fecha_impresion = $request->input('fecha_impresion');
            $cotizacion->save();
    }

    public static function regresaGruposCotizacion($id){
        $materialesGrupo=DB::table('detalle_cotizaciones')
            ->where('detalle_cotizaciones.id_cotizacion', '=', $id)
            ->join('grupos', 'detalle_cotizaciones.id_grupo', '=', 'grupos.id')
            ->join('materiales', 'detalle_cotizaciones.id_material', '=', 'materiales.id')
            ->select('detalle_cotizaciones.*', 'materiales.descripcion AS mat_nom', 'grupos.descripcion AS gpo_nom', 'materiales.unidad')
            ->orderBy('detalle_cotizaciones.id_grupo', 'ASC')
            ->orderBy('detalle_cotizaciones.id_material', 'ASC')
            ->get();

        $detalle=array();
        if(count($materialesGrupo)>0){
            $materiales=array();
            $grupo=$materialesGrupo[0]->id_grupo;
            $grupoActual=$materialesGrupo[0]->id_grupo;
            $nom_gpo=$materialesGrupo[0]->gpo_nom;
            $id_gpo=$materialesGrupo[0]->id_grupo;
            foreach ($materialesGrupo as $mats) {
                $grupoActual=$mats->id_grupo;
                if($grupo!=$grupoActual){
                    array_push($detalle, array("id" => $id_gpo, "grupo" => $nom_gpo,"materiales" => $materiales));
                    $materiales=array();
                    $nom_gpo=$mats->gpo_nom;
                    $id_gpo=$mats->id_grupo;
                    $grupo=$grupoActual;
                }
                array_push($materiales, $mats);
            }
            array_push($detalle, array("id" => $id_gpo, "grupo" => $nom_gpo,"materiales" => $materiales));
        }
        return $detalle;
    }

    public static function removerGrupoCotizacion($request){
        DB::table('detalle_cotizaciones')
            ->where('id_cotizacion', '=', $request->input("id_cot"))
            ->where('id_grupo', '=', $request->input("id_grupo"))
            ->delete();
    }

    public static function listadoPDF($id){
        $lista=DB::table('detalle_cotizaciones')
            ->select('grupos.descripcion', DB::raw('SUM(precio) as total'))
            ->where('detalle_cotizaciones.id_cotizacion', '=', $id)
            ->groupBy('grupos.descripcion')
            ->orderBy('detalle_cotizaciones.id_grupo', 'ASC')
            ->join('grupos', 'detalle_cotizaciones.id_grupo', '=', 'grupos.id')
            ->get();

        return $lista;
    }

    public static function getTotal($id){
        $total=DB::table('detalle_cotizaciones')
            ->select(DB::raw('SUM(precio) as total'))
            ->where('id_cotizacion', '=', $id)
            ->get();

        return $total;
    }

}
