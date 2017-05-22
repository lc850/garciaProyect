<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Mensajes extends Model
{
    protected $table = 'mensajes';

    public function cotizacion(){
    	return $this->belongsTo(Cotizaciones::class);
    }
}
