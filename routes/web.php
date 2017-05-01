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
	Route::get('/', function () {
	    return view('home');
	});

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

});

Auth::routes();

Route::get('/home', 'HomeController@index');
