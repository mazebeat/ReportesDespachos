<?php

class BusquedaController extends \ApiController
{

	public function index()
	{
		return View::make('busquedas.individual');
	}

	public function process()
	{
		$rules = array(
			'negocio' => 'required',
			'correo' => 'email'
		);

		$validator = Validator::make(Input::all(), $rules);

		if ($validator->fails()) {
			return Redirect::back()->withErrors($validator)->withInput(Input::except(array('_token')));
		}

		$negocio = Str::upper(Input::get('negocio'));
		$cuenta  = Input::has('cuenta') ? "'" . Input::get('cuenta') . "'" : 'NULL';
		$tipodoc = Input::has('tipodoc') ? "'" . Input::get('tipodoc') . "'" : 'NULL';
		$folio   = Input::has('folio') ? "'" . Input::get('folio') . "'" : 'NULL';
		$correo  = Input::has('correo') ? "'" . Input::get('correo') . "'" : 'NULL';

		$name = $negocio . $cuenta . $tipodoc . $folio . $correo;

		if (Cache::has($name)) {
			$sql = Cache::get($name);
		} else {
			$query = "EXEC busquedaIndividual_ex1 '%s', %s, %s, %s, %s";
			$query = sprintf($query, $negocio, $cuenta, $tipodoc, $folio, $correo);
			$sql   = $this->store_query_cache($name, $query);
		}

		unset($negocio);
		unset($cuenta);
		unset($tipodoc);
		unset($folio);
		unset($correo);
		unset($query);
		unset($name);

		$message = $this->get_message($sql);

		return View::make('busquedas.individual')->with('sql', $sql)->with('message', $message)->withInput(Input::except(array('_token')));

	}
}
