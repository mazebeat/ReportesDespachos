<?php

use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\View;

class ResumenController extends \ApiController
{
	public function despacho()
	{
		return View::make('resumenes.despacho');
	}

	public function procesa_despacho()
	{
		$rules = array('negocio' => 'required', 'fecha' => 'required');

		$validator = Validator::make(Input::all(), $rules);

		if ($validator->fails()) {
			return Redirect::back()->withErrors($validator)->withInput(Input::except(array('_token')));
		}

		$negocio = Str::upper(Input::get('negocio'));
		$fecha   = explode('-', Input::get('fecha'));
		$mes     = $fecha[1];
		$año     = substr($fecha[0], -2);
		$fecha   = $mes . $año;
		$ciclo = Input::get('ciclo');

		if ($ciclo != '' && $negocio === Str::upper('movil')) {
			$ciclo = $ciclo . $fecha;
		}

		$name = $negocio . $fecha . $ciclo;

		if (Cache::has($name)) {
			$sql = Cache::get($name);
		} else {
			if (empty($ciclo)) {
				$query = "EXEC ObtenerResumen_ex1 '%s', %u, %u, NULL";
				$query = sprintf($query, $negocio, $mes, $año);
			} else {
				$query = "EXEC ObtenerResumen_ex1 '%s', %u, %u, '%s'";
				$query = sprintf($query, $negocio, $mes, $año, $ciclo);
			}
			$sql = $this->store_query_cache($name, $query);
		}

		$message = $this->get_message($sql);

		return View::make('resumenes.despacho')->with('sql', $sql)->with('message', $message)->withInput(Input::except(array('_token')));;
	}

	public function emessaging()
	{
		return View::make('resumenes.emessaging');
	}

	public function procesa_emessaging()
	{
		$rules = array('negocio' => 'required', 'fecha_desde' => 'required', 'fecha_hasta' => 'required|after:' . Input::get('fecha_desde'));

		$validator = Validator::make(Input::all(), $rules);

		if ($validator->fails()) {
			return Redirect::back()->withErrors($validator)->withInput(Input::except(array('_token')));
		}

		$negocio     = Input::get('negocio');
		$fecha_desde = new Carbon(Input::get('fecha_desde'));
		$fecha_desde = $fecha_desde->startOfDay()->format('Ymd H:i:s');
		$fecha_hasta = new Carbon(Input::get('fecha_hasta'));
		$fecha_hasta = $fecha_hasta->endOfDay()->format('Ymd H:i:s');

		$name = $negocio . $fecha_desde . $fecha_hasta;

		if (Cache::has($name)) {
			$sql = Cache::get($name);
		} else {
			$query = "EXEC ObtenerResumenEmessaging_ex1 '%s','%s','%s'";
			$query = sprintf($query, $negocio, $fecha_desde, $fecha_hasta);
			$sql   = $this->store_query_cache($name, $query);
		}

		unset($negocio);
		unset($fecha_desde);
		unset($fecha_hasta);
		unset($query);

		$message = $this->get_message($sql);

		return View::make('resumenes.emessaging')->with('sql', $sql)->with('message', $message)->withInput(Input::except(array('_token')));;
	}
}
