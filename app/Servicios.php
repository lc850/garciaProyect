<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class Servicios extends Model
{
    protected $table='servicios';

    public static function regresarServicios(){
    	$servicios=Servicios::where('activo', '=', 1)->get();
    	return $servicios;
    }

    public static function registrarServicio($request){
        $servicio= new Servicios();
        $servicio->nombre=$request->input('nombre');
        $servicio->codigo=$request->input('codigoServicio');
        $servicio->unidad=$request->input('unidad');
        $servicio->precio=$request->input('precio');
        $servicio->activo=1;
        $servicio->save();
    }

    public static function ultimoCodigoServicio($request){
    	$servicio=Servicios::where('codigo', 'like', $request->input('codigo').'%')
        ->orderby('codigo','desc')
        ->first();

        if (!isset($servicio)) {
            if (strcmp ($request->input('codigo').'%' , '3%' ) == 0)
                return response()->json('3000');
        }
        
        return response()->json($servicio->codigo);
    }

    public static function eliminarServicio($id)
    {
    	$grupo=Servicios::find($id);
        $grupo->activo=0;
        $grupo->save();
    }

    public static function actualizarServicio($request)
    {
        $servicio = Servicios::find($request->input('id'));
            $servicio->nombre = $request->input('nombre');
            $servicio->unidad = $request->input('unidad');
            $servicio->precio=$request->input('precio');
            $servicio->save();
    }

    public static function regresarServiciosNoCotizacion($id){
        $lista=DB::table('cotizaciones_servicios')
            ->where('cotizacion_id', '=', $id)
            ->pluck('servicio_id');

        $servicios=DB::table('servicios')
            ->whereNotIn('id', $lista)
            ->where('activo', '=', 1)
            ->orderBy('id', 'ASC')
            ->get();

        return $servicios;
    }

    public static function agregarServicioCotizacion($request){
        DB::table('cotizaciones_servicios')->insert(
            ['cotizacion_id' => $request->input("id_cot"),
             'servicio_id' => $request->input("id_serv"),
             'cantidad' => $request->input("cantidad_serv"),
             'precio' => $request->input("precio")
            ]
        );
    }

    public static function serviciosCotizacion($id){
        $lista=DB::table('cotizaciones_servicios')
            ->where('cotizacion_id', '=', $id)
            ->pluck('servicio_id');

        $servicios=DB::table('servicios')
            ->whereIn('servicios.id', $lista)
            ->where('servicios.activo', '=', 1)
            ->join('cotizaciones_servicios', 'servicios.id', '=', 'cotizaciones_servicios.servicio_id')
            ->orderBy('id', 'ASC')
            ->selectRaw('servicios.*, cotizaciones_servicios.cantidad, cotizaciones_servicios.precio AS c_precio, cotizaciones_servicios.precio*cotizaciones_servicios.cantidad as c_p')
            ->get();

        return $servicios;
    }
}






