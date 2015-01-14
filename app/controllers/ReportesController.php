<?php

use App\Util\Functions;

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

		if (!File::exists($this->root . $nameFile . '.zip')) {
			$csv = new \App\Util\arrayToCsv();

			if (Cache::has($name)) {
				$sql = Cache::get($name);
			} else {
				$sql = $this->store_query_cache($name, $query);
			}

			$fileLocation = $this->root . $nameFile . '.txt';

			$conn = DB::connection()->getReadPdo();
			$conn->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
			$stmt = $conn->prepare($query);
			$stmt->execute();
			$count = 0;

			while ($row = $stmt->fetchAll(PDO::FETCH_ASSOC)) {
				if ($count < 0) {
					foreach ($row as $key => $value) {
						File::append($fileLocation, $csv->convert($key));
						$count++;
					}
				}
				File::append($fileLocation, $csv->convert($row));
			}

			if (File::exists($fileLocation)) {
				if (!File::exists($this->root . $nameFile . '.zip')) {
					$zipper = new \Chumper\Zipper\Zipper;
					$zipper->make($this->root . $nameFile . '.zip')->add($fileLocation);
				} else {
					unlink($fileLocation);
				}
			}
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
			$query = "EXEC REPORTEESTADODESPACHO_EX1 '%s','%s'";
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
