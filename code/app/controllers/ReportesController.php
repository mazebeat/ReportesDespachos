<?php

use App\Util\Functions;
use Illuminate\Support\Facades\File;

class ReportesController extends \ApiController
{
	private $message;
	private $root;

	public function __construct()
	{
		$this->message = array();
		$reportesdir   = public_path() . DIRECTORY_SEPARATOR . 'reportes' . DIRECTORY_SEPARATOR;
		$this->root    = $reportesdir . Auth::user()->idUsuario . DIRECTORY_SEPARATOR;

		if (!File::exists($reportesdir)) {
			File::makeDirectory($reportesdir);
			if (chmod($reportesdir, 0777)) {
				chmod($reportesdir, 0755);
			}
		}

		if (!File::exists($this->root)) {
			File::makeDirectory($this->root);
			if (chmod($this->root, 0777)) {
				chmod($this->root, 0755);
			}
		}
	}

	/**
	 * @return mixed
	 */
	public function reporte()
	{
		$files = $this->list_files($this->root);

		if (!count($files)) {
			$this->message[] = "No se han generado reportes aún";
		}

		return View::make('reportes.reporte')->with('files', $files)->with('message', $this->message);
	}

	/**
	 * @return mixed
	 */
	public function procesa_reporte()
	{
		if (str_contains(Str::lower(Input::get('negocio')), 'despacho ')) {
			$rules = array(
				'negocio' => 'required',
				'fecha'   => 'required',
				'ciclo'   => 'required'
			);
		}
		else {
			$rules = array(
				'negocio' => 'required',
				'fecha'   => 'required'
			);
		}

		$validator = Validator::make(Input::all(), $rules);

		if ($validator->fails()) {
			return Redirect::back()->withErrors($validator)->withInput(Input::except(array('_token')));
		}

		$negocio      = Str::upper(Input::get('negocio'));
		$fecha        = new Carbon(Input::get('fecha'));
		$fecini       = new Carbon($fecha);
		$fecini       = $fecini->startOfMonth()->format('Ymd');
		$fecfin       = new Carbon($fecha);
		$fecfin       = $fecfin->endOfMonth()->format('Ymd');
		$ciclo        = Input::get('ciclo');
		$instancia    = Config::get('database.connections.sqlsrv.host');  // 'DUF2409\INST1'
		$name         = $negocio . Input::get('fecha') . $ciclo;
		$nameFile     = $negocio . '_' . Input::get('fecha') . '_' . $ciclo;
		$fileLocation = $this->root . $nameFile . '.txt';

		if (!Cache::has($name)) {
			switch (Str::lower($negocio)) {
				case 'despacho fija':
					$negocio = 'FIJA';
					$spname  = 'ReportesDespachos.dbo.ObtenerDetalle_ex1';
					$sql     = app_path('database/Generadocumento' . 'ObtenerDetalle_ex1.sql');
					$cmd     = 'sqlcmd -S ' . $instancia . ' -i "' . $sql . '" -o "' . $fileLocation . '" -W -s";" -f 65001 -v negocio="' . $negocio . '" ciclo="' . $ciclo . '" mes="' . $fecha->month . '" ano="' . $fecha->year . '" spname=' . $spname;
					break;
				case 'despacho movil':
					$negocio = 'MOVIL';
					$spname  = 'ReportesDespachos.dbo.ObtenerDetalle_ex1';
					$sql     = app_path('database/Generadocumento' . 'ObtenerDetalle_ex1.sql');
					$ciclo   = Input::get('ciclo') . explode('-', $fecha)[1] . substr(explode('-', $fecha)[0], -2);
					$cmd     = 'sqlcmd -S ' . $instancia . ' -i "' . $sql . '" -o "' . $fileLocation . '" -W -s";" -f 65001 -v negocio="' . $negocio . '" ciclo="' . $ciclo . '" mes="' . $fecha->month . '" ano="' . $fecha->year . '" spname=' . $spname;
					break;
				case 're-despacho':
					$negocio = 'FIJA';
					$spname  = 'ReportesDespachos.dbo.ObtenerDetalleRedespacho_ex1';
					$sql     = app_path('database/Generadocumento' . 'ObtenerDetalleRedespacho_ex1.sql');
					$cmd     = 'sqlcmd -S ' . $instancia . ' -i "' . $sql . '" -o "' . $fileLocation . '" -W -s";" -f 65001 -v fechaini="' . $fecini . '" fechafin="' . $fecfin . '" spname=' . $spname;
					break;
				case 're-envio fija':
					$negocio = '1';
					$spname  = 'ReportesDespachos.dbo.DetalleReenvios_ex1';
					$sql     = app_path('database/Generadocumento' . 'DetalleReenvios_ex1.sql');
					$cmd     = 'sqlcmd -S ' . $instancia . ' -i "' . $sql . '" -o "' . $fileLocation . '" -W -s";" -f 65001 -v negocio="' . $negocio . '" fechaini="' . $fecini . '" fechafin="' . $fecfin . '" spname=' . $spname;
					break;
				case 're-envio movil':
					$negocio = '2';
					$spname  = 'ReportesDespachos.dbo.DetalleReenvios_ex1';
					$sql     = app_path('database/Generadocumento' . 'DetalleReenvios_ex1.sql');
					$cmd     = 'sqlcmd -S ' . $instancia . ' -i "' . $sql . '" -o "' . $fileLocation . '" -W -s";" -f 65001 -v negocio="' . $negocio . '" fechaini="' . $fecini . '" fechafin="' . $fecfin . '" spname=' . $spname;
					break;
			}
			$cmd = $this->store_query_cache($name, $cmd, 5, false);
		}
		else {
			//			$cmd = Cache::tags('sqlUser_' . Auth::user()->idUsuario)->get($name);
			$cmd = Cache::get($name);
		}

		if (!File::exists($this->root . $nameFile . '.zip')) {

			shell_exec($cmd);

			if (Functions::delLineFromFile($fileLocation, 2)) {
				if (File::exists($fileLocation)) {
					if (!File::exists($this->root . $nameFile . '.zip')) {
						$zip = new ZipArchive();
						if ($zip->open($this->root . $nameFile . '.zip', ZIPARCHIVE::CREATE) === true) {
							$zip->addFile($fileLocation, $nameFile . '.txt');
							$zip->close();
							$result = true;
						}
						else {
							$result = false;
						}

						if ($result) {
							unlink($fileLocation);
						}
					}
				}
			}
			$conn = null;
		}
		else {
			$this->message[] = 'Archivo ya generado';
		}

		unset($negocio);
		unset($conn);
		unset($fecha);
		unset($fecini);
		unset($fecfin);
		unset($fecfin);
		unset($ciclo);

		$files = $this->list_files($this->root);

		return View::make('reportes.reporte')->with('files', $files)->with('message', $this->message)->withInput(Input::except(array('_token')));;
	}

	/**
	 * @return mixeds
	 */
	public function estado_despacho()
	{
		$fecha = Carbon::now();
		$name  = 'estadoDespacho' . $fecha->format('Ymd');
		$sql   = array();

		if (Cache::has($name)) {
			//			$sql = Cache::tags('sqlUser_' . Auth::user()->idUsuario)->get($name);
			$sql = Cache::get($name);
		}
		else {
			$query = "EXEC dbo.REPORTEESTADODESPACHO_EX1 '%s','%s'";
			$query = sprintf($query, $fecha->subHours(12)->format('Ymd h:\\00:\\00'), $fecha->format('Ymd h:\\59:\\59'));
			try {
				$sql = $this->store_query_cache($name, $query);
				if (!count($sql)) {
					$sql = array();
				}
			} catch (Exception $e) {
				$this->message[] = '';
			}
		}
		unset($query);
		unset($name);

		$time = 'Despachos por profile: (Desde %s, Hasta %s)';
		$time = sprintf($time, $fecha->subHours(12)->format('Y-m-d h:\\00:\\00'), $fecha->format('Y-m-d h:\\59:\\59'));

		$this->message[] = $this->get_message($sql);

		unset($fecha);

		return View::make('reportes.despachos')->with('sql', $sql)->with('message', $this->message)->with(compact('time'));
	}
}
