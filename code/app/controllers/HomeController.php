<?php

use Illuminate\Support\Facades\Auth;

class HomeController extends \ApiController
{

	public function index()
	{
		if (Auth::check()) {
			return Redirect::to('admin');
		}

		return View::make('index');
	}

	public function login()
	{
		//		sleep(40);

		$rules = array(
			'usuario'    => 'required|exists:Usuarios',
			'contraseña' => 'required|min:3'
		);

		$validator = Validator::make(Input::all(), $rules);

		if ($validator->fails()) {
			return Redirect::back()->withErrors($validator)->withInput(Input::except(array(
				                                                                         'contraseña',
				                                                                         '_token'
			                                                                         )));
		}

		$user = User::where('usuario', Input::get('usuario'))->where('pwdusuario', Input::get('contraseña'))->first();
		if ($user) {
			$id = $user->idUsuario;
			if (Auth::loginUsingId($id)) {
				return Redirect::to('admin');
			}
			else {
				return Redirect::to('/');
			}
		}
		else {
			return Redirect::back()->withErrors(array('Usuario incorrecto'))->withInput(Input::except(array(
				                                                                                          'contraseña',
				                                                                                          '_token'
			                                                                                          )));
		}
	}

	public function logout()
	{
		File::cleanDirectory(public_path() . '/reportes/' . Auth::user()->idUsuario);
		//		Cache::tags('sqlUser_' . Auth::user()->idUsuario)->flush();
		Auth::logout();

		return Redirect::to('/');
	}
}
