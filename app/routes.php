<?php

ini_set('max_execution_time', 0);
ini_set('memory_limit', '1024M');
error_reporting(E_ALL);
setlocale(LC_ALL, "es_ES.UTF-8", "Esp", "Es");

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

Route::group(array('after' => 'auth'), function () {
	Route::get('/', 'HomeController@index');
	Route::post('/', 'HomeController@login');
});

Route::group(array('before' => 'auth'), function () {
	Route::group(array('prefix' => 'admin'), function () {
		//		Admin Controller
		Route::get('/', 'AdminController@index');
		//		User resource
		Route::resource('usuarios', 'UsersController');
		//		admin/resumen
		Route::group(array('prefix' => 'resumen'), function () {
			Route::get('despachos', 'ResumenController@despacho');
			Route::post('despachos', 'ResumenController@procesa_despacho');
			Route::get('emessaging', 'ResumenController@emessaging');
			Route::post('emessaging', 'ResumenController@procesa_emessaging');
		});
		//		admin/busquedas
		Route::group(array('prefix' => 'busquedas'), function () {
			Route::get('individual', 'BusquedaController@index');
			Route::post('individual', 'BusquedaController@process');
		});
		//		admin/reportes
		Route::group(array('prefix' => 'reportes'), function () {
			Route::get('reporte', 'ReportesController@reporte');
			Route::post('reporte', 'ReportesController@procesa_reporte');
			Route::get('estadodespachos', 'ReportesController@estado_despacho');
			Route::post('estadodespachos', 'ReportesController@procesa_estado_despacho');
		});
	});
	// graphs
	Route::get('anual', 'AdminController@anual');
	Route::get('mensual', 'AdminController@mensual');
	Route::get('gAnual', 'AdminController@gAnual');
	Route::get('gMensualFija', 'AdminController@gMensualFija');
	Route::get('gMensualMovil', 'AdminController@gMensualMovil');

	//	download files
	Route::get('download', function () {
		return Response::download(Input::get('path'));
	});
	//	logout method
	Route::get('logout', 'HomeController@logout');
});

Route::get('test', function () {
});