<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;
use Carbon\Carbon;
use App\detalle_cotizaciones;
use App\Mensajes;

class Cotizaciones extends Model
{
    protected $table='cotizaciones';

    public function clientes(){
        return $this->belongsTo('App\Clientes', 'id_cliente');
    }

    public function mensajes()
    {
        return $this->hasOne('App\Mensajes', 'cotizacion_id');
    }

    public function grupos(){
        return $this->belongsToMany('App\Grupos', 'cotizaciones_grupos', 'id_cotizacion', 'id_grupo')
            ->with('materialesDetalle')
            ->withPivot('cantidad')
            ->withTimestamps();
    }

    public static function regresarCotizaciones(){
    	$cotizaciones=Cotizaciones::with('clientes')->with('mensajes')->where('activo', '=', 1)->get();
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

        $mensaje=new Mensajes();
        $mensaje->cotizacion_id=$cotizacion->id;
        $mensaje->save();
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
            ->select('detalle_cotizaciones.*', 'materiales.descripcion AS mat_nom', 'grupos.descripcion AS gpo_nom', 'materiales.unidad', 'detalle_cotizaciones.cantidad_gpo')
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
            $cant_gpo=$materialesGrupo[0]->cantidad_gpo;
            foreach ($materialesGrupo as $mats) {
                $grupoActual=$mats->id_grupo;
                if($grupo!=$grupoActual){
                    array_push($detalle, array("id" => $id_gpo, "grupo" => $nom_gpo, "cant_gpo" => $cant_gpo, "materiales" => $materiales, "total" => 0));
                    $materiales=array();
                    $nom_gpo=$mats->gpo_nom;
                    $id_gpo=$mats->id_grupo;
                    $grupo=$grupoActual;
                }
                array_push($materiales, $mats);
            }
            array_push($detalle, array("id" => $id_gpo, "grupo" => $nom_gpo, "cant_gpo" => $cant_gpo, "materiales" => $materiales, "total" => 0));
        }
        for ($i=0; $i < count($detalle); $i++) { 
            $total=0;
            for ($j=0; $j < count($detalle[$i]["materiales"]); $j++) { 
                $total=$total+(($detalle[$i]["materiales"][$j]->precio)*($detalle[$i]["materiales"][$j]->cantidad));
            }
            $detalle[$i]["total"]=$total;
        }

        return $detalle;
    }

    public static function removerGrupoCotizacion($request){
        DB::table('detalle_cotizaciones')
            ->where('id_cotizacion', '=', $request->input("id_cot"))
            ->where('id_grupo', '=', $request->input("id_grupo"))
            ->delete();

        DB::table('cotizaciones_grupos')
            ->where('id_cotizacion', '=', $request->input("id_cot"))
            ->where('id_grupo', '=', $request->input("id_grupo"))
            ->delete();
    }

    public static function listadoPDF($id){
        $lista=Cotizaciones::where('id', $id)->with('grupos')->get();

        return $lista;
    }

    public static function getTotal($id){
        $total=DB::table('detalle_cotizaciones')
            ->select(DB::raw('SUM(cantidad*precio*cantidad_gpo) as total'))
            ->where('id_cotizacion', '=', $id)
            ->get();

        return $total;
    }

    public static function regresarGruposNoCotizacion($id){
        $lista=DB::table('detalle_cotizaciones')
            ->where('id_cotizacion', '=', $id)
            ->pluck('id_grupo');

        $grupos=DB::table('grupos')
            ->whereNotIn('id', $lista)
            ->where('activo', '=', 1)
            ->orderBy('id', 'ASC')
            ->get();

        return $grupos;
    }

    public static function agregarGrupoCotizacion($request){
        $id_grupo=$request->input('id_gpo');
        $id_cot=$request->input('id_cot');
        $mats=DB::table('materiales_grupos')
            ->where('id_grupo', '=', $id_grupo)
            ->join('materiales', 'materiales_grupos.id_material', '=', 'materiales.id')
            ->select('materiales.*', 'materiales_grupos.cantidad AS cant_mat')
            ->get();
        foreach ($mats as $m) {
            $detalle=new detalle_cotizaciones();
            $detalle->id_cotizacion=$id_cot;
            $detalle->id_grupo=$id_grupo;
            $detalle->id_material=$m->id;
            $detalle->cantidad=$m->cant_mat;
            $detalle->cantidad_gpo=$m->$id_cot=$request->input('cantidad_gpo');
            $detalle->precio=$m->precio;
            $detalle->save();
        }
        if(count($mats)>0){
            $nuevo= new cotizaciones_grupos();
            $nuevo->id_cotizacion=$id_cot;
            $nuevo->id_grupo=$id_grupo;
            $nuevo->cantidad=$request->input('cantidad_gpo');
            $nuevo->save();
        }

        return count($mats);
    }

    public static function removerMaterialCotizacion($request){
        $elemento=detalle_cotizaciones::find($request->input('id'));
        $elemento->delete();
        return 1;
    }

    public static function existeMaterialGrupo($request){
        $material=detalle_cotizaciones::where('id_cotizacion', '=', $request->input('id_cot'))
            ->where('id_grupo', '=', $request->input('id_gpo'))
            ->where('id_material', '=', $request->input('id_mat'))
            ->get();

        return count($material);
    }

    public static function agregarMaterialGrupoCotizacion($request){
        $nuevo=new detalle_cotizaciones();
        $nuevo->id_cotizacion=$request->input('id_cot');
        $nuevo->id_grupo=$request->input('id_gpo');
        $nuevo->id_material=$request->input('id_mat');
        $nuevo->cantidad=$request->input('cantidad');
        $nuevo->precio=$request->input('precio');
        $nuevo->cantidad_gpo=$request->input('cant_gpo');
        $nuevo->save();
    }

    public static function guardarMensajes($id, $request){
        $mensaje=Mensajes::find($request->input('id_msg'));
            $mensaje->msg1=$request->input('msg1');
            $mensaje->msg2=$request->input('msg2');
            $mensaje->msg3=$request->input('msg3');
            $mensaje->msg4=$request->input('msg4');
            $mensaje->msg5=$request->input('msg5');
        $mensaje->save();

        if($request->input('fecha_impresion')!=null){
            $cotizacion=Cotizaciones::find($id);
            $cotizacion->fecha_impresion=$request->input('fecha_impresion');
            $cotizacion->save();
        }

    }

}
