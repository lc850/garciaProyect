<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Materiales;
use App\Cotizaciones;
use App\Grupos;
use App\Clientes;
use App\Datos;


class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('home');
    }

    public function principal(){
        $materiales=count(Materiales::where('activo', '=', 1)->get());
        $cotizaciones=count(Cotizaciones::where('activo', '=', 1)->get());
        $clientes=count(Clientes::where('activo', '=', 1)->get());
        $grupos=count(Grupos::where('activo', '=', 1)->get());
        $prueba=array($materiales, $clientes, $cotizaciones, $grupos);
        return view('home', compact('totales', 'prueba'));
    }

    public function misDatos(){
        $datos=Datos::all()->first();
        return view('misDatos', compact('datos'));
    }

    public function guardarMisDatos(Request $request){
        $datos=new Datos();
        $datos->nombre=$request->input('nombre');
        $datos->direccion=$request->input('direccion');
        $datos->responsable=$request->input('responsable');
        $datos->save();
        flash('¡Se guardaron exitósamente los datos de la empresa!')->success();
        return redirect('/misDatos');
    }

    public function actualizarMisDatos(Request $request){
        $datos=Datos::find($request->input('id'));
        $datos->nombre=$request->input('nombre');
        $datos->direccion=$request->input('direccion');
        $datos->responsable=$request->input('responsable');
        $datos->save();
        flash('¡Se actualizaron exitósamente los datos de la empresa!')->success();
        return redirect('/misDatos');
    }
}
