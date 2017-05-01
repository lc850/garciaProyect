<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tipos extends Model
{
    protected $table='tipos';

    public static function regresarTipos(){
    	$tipos=Tipos::where('activo', '=', 1)->get();
    	return $tipos;
    }
}
