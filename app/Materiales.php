<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Materiales extends Model
{
    protected $table='materiales';

    public static function registrarMaterial($request)
    {
    	$material = new Materiales();
            $material->codigo = $request->input('codigoMaterial');
            $material->descripcion = $request->input('descripcion');
            $material->cantidad = $request->input('cantidad');
            $material->precio = $request->input('precio');
            $material->unidad = $request->input('unidad');
            $material->clasificacion = $request->input('clasificacion');
            $material->activo = 1;
            $material->save();
    }

    public static function regresarMateriales(){
    	$materiales=Materiales::where('activo', '=', 1)
    		->orderBy('codigo', 'ASC')
    		->get();

    	return $materiales;
    }

    public static function actualizarMaterial($request)
    {
        $material = Materiales::find($request->input('id'));
            $material->codigo = $request->input('codigo1');
            $material->descripcion = $request->input('descripcion1');
            $material->cantidad = $request->input('cantidad1');
            $material->precio = $request->input('precio1');
            $material->unidad = $request->input('unidad1');
            $material->clasificacion = $request->input('clasificacion1');
            $material->save();
    }

    public static function eliminarMaterial($id)
    {
    	$material=Materiales::find($id);
        $material->activo=0;
        $material->save();
    }

}
