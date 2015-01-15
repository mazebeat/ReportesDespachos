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
		$this->root    = public_path() . '/reportes/' . Auth::user()->idUsuario . '/';
	}

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
		//  Se  crea carpeta
		if (!File::exists($this->root)) {
			File::makeDirectory($this->root);
		}

		// Valida campos
		if (str_contains(Str::lower(Input::get('negocio')), 'despacho ')) {
			$rules = array('negocio' => 'required', 'fecha' => 'required', 'ciclo' => 'required');
		} else {
			$rules = array('negocio' => 'required', 'fecha' => 'required');
		}

		$validator = Validator::make(Input::all(), $rules);

		if ($validator->fails()) {
			return Redirect::back()->withErrors($validator)->withInput(Input::except(array('_token')));
		}

		// Obtiene campos
		$negocio = Str::upper(Input::get('negocio'));
		$fecha   = new Carbon(Input::get('fecha'));
		$fecini  = new Carbon($fecha);
		$fecini  = $fecini->startOfMonth();
		$fecfin  = new Carbon($fecha);
		$fecfin  = $fecfin->endOfMonth();
		$ciclo   = Input::get('ciclo');

		$name     = $negocio . Input::get('fecha') . $ciclo;
		$nameFile = $negocio . '_' . Input::get('fecha') . '_' . $ciclo;

		if (!Cache::has($name)) {
			switch (Str::lower($negocio)) {
				case 'despacho fija':
					$negocio = 'FIJA';
					$query   = "EXEC dbo.ObtenerDetalle_ex1 '%s', %s, %s, %s";
					$query   = sprintf($query, $negocio, $ciclo, $fecha->month, $fecha->year);
					break;
				case 'despacho movil':
					$negocio = 'MOVIL';
					$query   = "EXEC dbo.ObtenerDetalle_ex1 '%s', %s, %s, %s";
					$ciclo = Input::get('ciclo') . explode('-', $fecha)[1] . substr(explode('-', $fecha)[0], -2);
					$query   = sprintf($query, $negocio, $ciclo, $fecha->month, $fecha->year);
					break;
				case 're-despacho':
					$query = "EXEC dbo.ObtenerDetalleRedespacho_ex1 '%s', '%s'";
					$query = sprintf($query, $fecini, $fecfin);
					break;
				case 're-envio fija':
					$negocio = '1';
					$query   = "EXEC dbo.DetalleReenvios_ex1 '%s', '%s', '%s'";
					$query   = sprintf($query, $negocio, $fecini, $fecfin);
					break;
				case 're-envio movil':
					$negocio = '2';
					$query   = "EXEC dbo.DetalleReenvios_ex1 '%s', '%s', '%s'";
					$query   = sprintf($query, $negocio, $fecini, $fecfin);
					break;
			}
		}

		$fileLocation = $this->root . $nameFile . '.txt';

		if (!File::exists($this->root . $nameFile . '.zip')) {

			try {
				$conn = new PDO('sqlsrv:server=10.185.30.243\INST1;Database=ReportesDespachos;MultipleActiveResultSets=false', 'emessuser', 'emessuser2013');
				$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
				$conn->setAttribute(constant('PDO::SQLSRV_ATTR_DIRECT_QUERY'), true);
			} catch (Exception $e) {
				die(print_r($e->getMessage()));
			}
			$stmt = $conn->prepare($query);
			$stmt->execute();

			while ($row = $stmt->fetch(\PDO::FETCH_ASSOC)) {
				File::append($fileLocation, Functions::array_2_csv($row));
			}

			if (File::exists($fileLocation)) {
				if (!File::exists($this->root . $nameFile . '.zip')) {
					$zip = new ZipArchive();
					if ($zip->open($this->root . $nameFile . '.zip', ZIPARCHIVE::CREATE) === true) {
						$zip->addFile($fileLocation, $nameFile . '.txt');
						$zip->close();
						$result = true;
					} else {
						$result = false;
					}

					if ($result) {
						unlink($fileLocation);
					}
				}
			}
			$conn = null;
		} else {
			$this->message[] = 'Archivo ya generado';
		}

		unset($negocio);
		unset($fecha);
		unset($fecini);
		unset($fecfin);
		unset($fecfin);
		unset($ciclo);

		$files = $this->list_files($this->root);

		return View::make('reportes.reporte')->with('files', $files)->with('message', $this->message);
	}

	public function estado_despacho()
	{
		$fecha = Carbon::now();
		$name  = 'estadoDespacho' . $fecha->format('Ymd');
		$sql   = array();

		if (Cache::has($name)) {
			$sql = Cache::get($name);
		} else {
			$query = "EXEC obc.REPORTEESTADODESPACHO_EX1 '%s','%s'";
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
