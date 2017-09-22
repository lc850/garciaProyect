<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Clientes extends Model
{
    protected $table='clientes';


    public static function regresarClientes(){
    	$clientes=Clientes::where('activo', '=', 1)->get();
    	return $clientes;
    }

    public static function nuevo($request){
    	$cliente= new Clientes();
        $cliente->nombre=$request->input('nombre');
        $cliente->email=$request->input('correo');
        $cliente->telefono=$request->input('telefono');
        $cliente->representante=$request->input('representante');
        $cliente->activo=1;
        $cliente->save();
    }

    public static function eliminarCliente($id)
    {
    	$cliente=Clientes::find($id);
        $cliente->activo=0;
        $cliente->save();
    }

    public static function actualizarCliente($request)
    {
        $cliente = Clientes::find($request->input('id'));
            $cliente->nombre = $request->input('nombre1');
            $cliente->email = $request->input('email1');
            $cliente->telefono = $request->input('telefono1');
            $cliente->representante=$request->input('representante1');
            $cliente->save();
    }

}







