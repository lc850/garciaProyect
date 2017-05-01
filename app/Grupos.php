<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class Grupos extends Model
{
    protected $table='grupos';

    public static function regresarGrupos(){
    	$grupos=DB::table('grupos')
    		->join('tipos', 'grupos.id_tipo', '=', 'tipos.id')
    		->where('grupos.activo', '=', 1)
    		->orderBy('grupos.id', 'ASC')
    		->select('grupos.id', 'grupos.descripcion', 'tipos.descripcion AS tipo', 'tipos.id AS id_tipo')
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
