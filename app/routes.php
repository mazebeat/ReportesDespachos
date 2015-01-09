<?php
ini_set('max_execution_time', 0);
ini_set('memory_limit', '512M');
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
		Route::group(array('prefix' => 'resportes'), function () {
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
	$server   = '10.185.30.243\INST1';
	$database = 'ReportesDespachos';
	$user     = 'emessuser';
	$password = $user . '2013';
	//
	//	$conn = new PDO("sqlsrv:server=$server;Database=$database;", "$user", "$clave");
	//	$statement = DB::connection()->getReadPdo()->prepare("EXEC REPORTEESTADODESPACHO_EX1 '20130624 08:00:00' , '20130624 20:59:59'");
	//	$statement = $conn->prepare("EXEC REPORTEESTADODESPACHO_EX1 '20130624 08:00:00' , '20130624 20:59:59'");
	//	$statement = $conn->prepare("EXEC obtenerDetalle 'FIJA','0001',1,2014");
	//	$statement->execute();
	//
	//	while ($row = $statement->fetchAll(PDO::FETCH_ASSOC)) {
	//		var_dump($row);
	//	}
	$serverName     = $server;
	$connectionInfo = array("Database" => $database, "UID" => $user, "PWD" => $password);
	$conn           = sqlsrv_connect($serverName, $connectionInfo);

	if ($conn) {
		echo "Conexión establecida.<br />";
	} else {
		echo "Conexión no se pudo establecer.<br />";
		die(print_r(sqlsrv_errors(), true));
	}
	$sql  = "{ CALL obtenerDetalle_ex1 ('FIJA', '0001', '03', '2014') }";
	$stmt = sqlsrv_query($conn, $sql);
	if ($stmt === false) {
		echo "Error in executing statement 3.\n";
		die(print_r(sqlsrv_errors(), true));
	}
	dd($row = sqlsrv_fetch_array($stmt));
	while ($row = sqlsrv_fetch_array($stmt)) {
		var_dump($row);
	}

});

Route::get('testODBC', function () {
	$data = array();
	$conn = DB::connection()->getReadPdo();
	$conn->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
	$stmt = $conn->prepare("EXEC dbo.obtenerDetalle_ex1 'FIJA', '0001', '03', '2014'");
	$stmt->execute();
	while ($row = $stmt->fetch(\PDO::FETCH_ASSOC)) {
		File::append(public_path() . '/salida.txt', json_encode($row));
	}
});
