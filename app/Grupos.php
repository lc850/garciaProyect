<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class Grupos extends Model
{
    protected $table='grupos';

    public function materialesDetalle()
    {
        return $this->belongsToMany('App\Materiales', 'detalle_cotizaciones', 'id_grupo', 'id_material')
         ->withPivot('cantidad_gpo', 'id_cotizacion', 'precio', 'cantidad')
         ->selectRaw('detalle_cotizaciones.cantidad*detalle_cotizaciones.precio AS cant_precio, materiales.*, detalle_cotizaciones.precio AS p, detalle_cotizaciones.id_cotizacion AS id_c')
         ->withTimestamps();
    }


    public static function regresarGrupos(){
    	$grupos=DB::table('grupos')
    		->where('grupos.activo', '=', 1)
            ->join('tipos', "grupos.id_tipo", "=", "tipos.id")
    		->orderBy('grupos.id', 'ASC')
            ->select("grupos.*", "tipos.descripcion AS tipo_desc")
    		->get();

    	return $grupos;
    }

    public static function eliminarGrupo($id)
    {
    	$grupo=Grupos::find($id);
        $grupo->activo=0;
        $grupo->save();
    }

    public static function registrarGrupo($request){
        $grupo= new Grupos();
        $grupo->descripcion=$request->input('descripcion');
        $grupo->id_tipo=$request->input('tipo');
        $grupo->activo=1;
        $grupo->save();
    }

    public static function actualizarGrupo($request)
    {
        $grupo = Grupos::find($request->input('id'));
            $grupo->descripcion = $request->input('descripcion1');
            $grupo->id_tipo = $request->input('tipo1');
            $grupo->save();
    }
}
