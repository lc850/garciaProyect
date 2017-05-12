<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class materiales_grupos extends Model
{
    protected $table = 'materiales_grupos';

    public static function nuevo($id_mat, $id_gpo, $cantidad){
        $mat_gpo=new materiales_grupos();
        $mat_gpo->id_material=$id_mat;
        $mat_gpo->id_grupo=$id_gpo;
        $mat_gpo->cantidad=$cantidad;
        $mat_gpo->save();
    }

    public static function obtenerMaterialesGrupo($id){
    	$mats_gpo=DB::table('materiales_grupos')
    		->where('materiales_grupos.id_grupo', '=', $id)
    		->join('materiales', 'materiales_grupos.id_material', '=', 'materiales.id')
    		->join('grupos', 'materiales_grupos.id_grupo', '=', 'grupos.id')
    		->select('materiales.*', 'grupos.id AS gpo_id', 'grupos.descripcion AS gpo_desc', 'materiales_grupos.id AS id_mat_gpo', 'materiales_grupos.cantidad AS mat_cant')
    		->get();

    	return $mats_gpo;
    }

    public static function regresarMaterialesNoGrupo($id){
        $lista=DB::table('materiales_grupos')
            ->where('id_grupo', '=', $id)
            ->pluck('id_material');

        $materiales=DB::table('materiales')
            ->whereNotIn('id', $lista)
            ->where('activo', '=', 1)
            ->orderBy('codigo', 'ASC')
            ->get();

        return $materiales;

        
    }
}
