<?php
// Set locale
setlocale(LC_ALL, "es_ES.UTF-8", "Esp", "Es");
//Memory
ini_set('memory_limit', '3500M');
ini_set('max_execution_time', '0');
ini_set('set_time_limit', '0');
//Iconv
if (PHP_VERSION_ID < 50600) {
	iconv_set_encoding('input_encoding', 'UTF-8');
	iconv_set_encoding('output_encoding', 'UTF-8');
	iconv_set_encoding('internal_encoding', 'UTF-8');
}
else {
	ini_set('default_charset', 'UTF-8');
}
//XDebug
ini_set('xdebug.collect_vars', 'on');
ini_set('xdebug.collect_params', '4');
ini_set('xdebug.dump_globals', 'on');
ini_set('xdebug.dump.SERVER', 'REQUEST_URI');
//Errors
error_reporting(E_ALL);
ini_set('display_errors', true);
ini_set('display_startup_errors', true);

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