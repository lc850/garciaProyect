<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::group(['middleware' => ['auth']], function () {
	Route::get('/', 'HomeController@principal');

	Route::get('/blank', function () {
	    return view('blank');
	});

	Route::get('/blankPrimary', function () {
	    return view('blankPrimary');
	});

	Route::get('/vistaAngular', function () {
	    return view('vistaAngular');
	});

	Route::get('/login', function () {
	    return view('login');
	});

	Route::get('/formularioGeneral', 'ejemploController@index');

	Route::get('/tablaDatos', function () {
	    return view('tablaDatos');
	});
	//Home controller

	Route::get('/misDatos', 'HomeController@misDatos');

	Route::post('/guardarMisDatos', 'HomeController@guardarMisDatos');

	Route::post('/actualizarMisDatos', 'HomeController@actualizarMisDatos');

	//MAteriales

	Route::get('/materiales', 'materialesController@index');

	Route::get('/obtenerMateriales', 'materialesController@obtenerMateriales');

	Route::post('/lastcode', 'materialesController@lastcodeMaterial');

	Route::post('/registrarMaterial', 'materialesController@registrarMaterial');

	Route::post('/actualizarMaterial', 'materialesController@actualizarMaterial');

	Route::post('/removerMaterial', 'materialesController@removerMaterial');

	//Grupos

	Route::get('/obtenerGrupos', 'gruposController@obtenerGrupos');

	Route::get('/grupos', 'gruposController@index');

	Route::post('/removerGrupo', 'gruposController@removerGrupo');

	Route::post('/registrarGrupo', 'gruposController@registarGrupo');

	Route::post('/actualizarGrupo', 'gruposController@actualizarGrupo');

	Route::get('/materialesGrupo/{id}', 'gruposController@materialesGrupo');

	Route::get('/obtenerMaterialesGrupo/{id}', 'gruposController@obtenerMaterialesGrupo');

	Route::post('/removerMaterialGrupo', 'gruposController@removerMaterialGrupo');

	Route::post('/agregarMaterialGrupo', 'gruposController@agregarMaterialGrupo');

	Route::post('/existeNombreGrupo', 'gruposController@existeNombreGrupo');

	//Cotizacion

	Route::get('/cotizaciones', 'cotizacionesController@index');

	Route::get('/obtenerCotizaciones', 'cotizacionesController@obtenerCotizaciones');

	Route::post('/registrarCotizacion', 'cotizacionesController@registrarCotizacion');

	Route::post('/removerCotizacion', 'cotizacionesController@removerCotizacion');

	Route::post('/actualizarCotizacion', 'cotizacionesController@actualizarCotizacion');

	Route::get('/detalleCotizacion/{id}', 'cotizacionesController@detalleCotizacion');

	Route::post('/gruposCotizacion', 'cotizacionesController@gruposCotizacion');

	Route::post('/removerGrupoCotizacion', 'cotizacionesController@removerGrupoCotizacion');

	Route::get('/cotizacionPDF/{id}', 'cotizacionesController@cotizacionPDF');

	Route::get('/detalladoPDF/{id}', 'cotizacionesController@detalladoPDF');

	Route::post('/agregarGrupoCotizacion', 'cotizacionesController@agregarGrupoCotizacion');

	Route::post('/removerMaterialCotizacion', 'cotizacionesController@removerMaterialCotizacion');

	Route::post('/agregarMaterialGrupoCotizacion', 'cotizacionesController@agregarMaterialGrupoCotizacion');

	Route::post('/existeMaterialGrupo', 'cotizacionesController@existeMaterialGrupo');

	Route::get('/ajusteCotizacion/{id}', 'cotizacionesController@ajusteCotizacion');

	Route::post('/guardarMensajes/{id}', 'cotizacionesController@guardarMensajes');

	Route::get('/prueba/{id}', 'cotizacionesController@prueba');
	
	Route::post('/actualizarCantidadGrupo', 'cotizacionesController@actualizarCantidadGrupo');

	Route::post('/agregarServicioCotizacion', 'cotizacionesController@agregarServicioCotizacion');

	Route::post('/removerServicioCotizacion', 'cotizacionesController@removerServicioCotizacion');

	Route::post('/removerIndividualCotizacion', 'cotizacionesController@removerIndividualCotizacion');

	Route::post('/agregarIndividualCotizacion', 'cotizacionesController@agregarIndividualCotizacion');

	Route::post('/actualizarCantidadDetalle', 'cotizacionesController@actualizarCantidadDetalle');



	//Clientes

	Route::get('/clientes', 'clientesController@index');

	Route::get('/obtenerClientes', 'clientesController@obtenerClientes');

	Route::post('/registrarCliente', 'clientesController@registrarCliente');

	Route::post('/removerCliente', 'clientesController@removerCliente');

	Route::post('/actualizarCliente', 'clientesController@actualizarCliente');

	//Servicios

	Route::get('/servicios', 'serviciosController@index');

	Route::get('/obtenerServicios', 'serviciosController@obtenerServicios');

	Route::post('/existeNombreServicio', 'serviciosController@existeNombreServicio');

	Route::post('/registrarServicio', 'serviciosController@registrarServicio');

	Route::post('/lastcodeServicio', 'serviciosController@lastcodeServicio');

	Route::post('/removerServicio', 'serviciosController@removerServicio');

	Route::post('/actualizarServicio', 'serviciosController@actualizarServicio');




});

Auth::routes();

Route::get('/home', 'HomeController@principal');
