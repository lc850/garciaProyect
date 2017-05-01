<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class materiales_grupos extends Model
{
    protected $table = 'materiales_grupos';

    public static function obtenerMaterialesGrupo($id){
    	$mats_gpo=DB::table('materiales_grupos')
    		->where('materiales_grupos.id_grupo', '=', $id)
    		->join('materiales', 'materiales_grupos.id_material', '=', 'materiales.id')
    		->join('grupos', 'materiales_grupos.id_grupo', '=', 'grupos.id')
    		->select('materiales.*', 'grupos.id AS gpo_id', 'grupos.descripcion AS gpo_desc')
    		->get();

    	return $mats_gpo;
    }
}
