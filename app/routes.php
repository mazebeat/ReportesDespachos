<?php

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

Route::get('/', function()
{
	return View::make('index');
});

Route::group(array('prefix' => 'admin'), function () {
	Route::get('/', function () {
		return View::make('despachos.index');
	});
	
	Route::group(array('prefix' => 'resumen'), function () {
		Route::get('despachos', function () {
			return View::make('resumenes.despacho');
		});
		Route::get('emessaging', function () {
			return View::make('resumenes.emessaging');
		});
	});
	Route::group(array('prefix' => 'busquedas'), function () {
		Route::get('individual', function () {
			return View::make('busquedas.individual');
		});
	});
	Route::group(array('prefix' => 'resportes'), function () {
		Route::get('reporte', function () {
			return View::make('reportes.reporte');
		});
		Route::get('estadodespachos', function () {
			return View::make('reportes.despachos');
		});
	});
});
