<?php


class ApiController extends \BaseController
{

	public function __construct()
	{
		$sp_anual         = "EXEC dbo.BuscaDataResumen_Anual '%s','%s'";
		$sp_mensual       = "EXEC dbo.BuscaDataResumen_Mensual '%s','%s'";
		$sp_gAnual        = "EXEC dbo.BuscaDataResumen_GraficoAnual '%s','%s'";
		$sp_gMensualFija  = "EXEC dbo.BuscaDataResumen_GraficoMensualFija '%s','%s'";
		$sp_gMensualMovil = "EXEC dbo.BuscaDataResumen_GraficoMensualMovil '%s','%s'";
		$sp_busqueda      = "EXEC busquedaIndividual_ex1 '%s', %s, %s, %s, %s";
		$sp_despacho      = "EXEC ObtenerResumen_ex1 '%s',%u,%u,'%s'";
		$sp_emmessagin    = "EXEC obc.REPORTEESTADODESPACHO_EX1 '%s','%s'";
	}

	public function validate($rules, $except = array('_token'))
	{
		$root = \Request::path();
		if (!count($except))
			$except = \Input::except($except);

		$validator = Validator::make(Input::all(), $rules);

		if ($validator->fails()) {
			return Redirect::to($root)->withErrors($validator)->withInput($except);
		}
	}

	public function get_message($sql = '')
	{
		if (count($sql) && $sql == '') {
			$message = '';
		} else {
			$message = 'No se han encontrado resultados a su busqueda.';
		}

		return $message;
	}

	public function store_query_cache($name, $query, $minutes = 15)
	{
		$sql = DB::select($query);
		$minutes = Carbon::now()->addMinutes($minutes);
		Cache::put($name, $sql, $minutes);
		unset($minutes);

		return $sql;
	}

	public function generate_file($location, $name, $content = '')
	{
		if ($content != '' && Str::length($content) > 1) {
			$fileLocation = $location . $name . '.txt';
			if (!File::exists($location . $name . '.zip')) {
				File::append($fileLocation, $content);
				$zipper = new \Chumper\Zipper\Zipper;
				$zipper->make($location . $name . '.zip')->add($fileLocation);
			}
			unset($fileLocation);
			unset($zipper);

			return true;
		}

		return false;
	}

	public function list_files($directory)
	{
		return File::files($directory);
	}

	public function connectSp()
	{
		$server = '10.185.30.243\INST1';
		$database = 'ReportesDespachos';
		$user = 'emessuser';
		$clave = $user . '2013';

		$conn = new PDO("sqlsrv:server=$server;Database=$database;", "$user", "$clave");
		//	$statement = DB::connection()->getReadPdo()->prepare("EXEC obtenerDetalle 'FIJA','0001',1,2014");
		$statement = $conn->prepare("EXEC REPORTEESTADODESPACHO_EX1 '20130624 08:00:00' , '20130624 20:59:59'");
		//	$statement = $conn->prepare("EXEC obtenerDetalle 'FIJA','0001',1,2014");
		$statement->execute();
		var_dump($statement);
		//		while ($row = $statement->fetchAll(PDO::FETCH_ASSOC)) {
		//			var_dump($row);
		//		}
	}

	public function ftp()
	{
		$ftp = FTP::connection();
		$list = $ftp->getDirListing('.', '-la');

		var_dump($ftp->currentDir());
		var_dump($ftp->readFile('/U Mayor Sistema de Monitoreo Permanente.docx'));
		var_dump($ftp->size('/MovReportes.war'));
		var_dump($ftp->downloadFile('/test.txt', storage_path() . '/download/test.txt'));
		var_dump($ftp->uploadFile(storage_path() . '/download/test.txt', '/test2.txt'));

		//	$zipper = new \Zipper();
		//
		//	$zipper->make('test.zip')->folder('test')->add($ftp->downloadFile('/test.txt', storage_path() . '/download/test.txt'));

		//	$zipper->remove('composer.lock');
		//
		//	$zipper->folder('mySuperPackage')->add(
		//		array(
		//			'vendor',
		//			'composer.json'
		//		)
		//	);

		//	$zipper->getFileContent('mySuperPackage/composer.json');

		//	$zipper->make('test.zip')->extractTo('',array('mySuperPackage/composer.json'),Zipper::WHITELIST);

		dd($list);
	}

}
