<?php

use Illuminate\Auth\Reminders\RemindableInterface;
use Illuminate\Auth\Reminders\RemindableTrait;
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\UserTrait;

class User extends Eloquent implements UserInterface, RemindableInterface
{
	use UserTrait, RemindableTrait;

	public    $timestamps = false;
	protected $table      = "Usuarios";
	protected $primaryKey = 'idUsuario';
	protected $hidden     = ["pwdusuario"];
	protected $fillable
	                      = [
			'usuario',
			'pwdusuario',
			'nombre',
			'apellido',
			'rut',
			'mail'
		];

	public static $rules
		= array(
			'usuario'         => 'required',
			'pwdusuario'      => 'required',
			'pwdusuario_same' => 'required|same:pwdusuario',
			'nombre'          => 'required',
			'apellido'        => 'required',
			'rut'             => 'required|unique:Usuarios,rut',
			'mail'            => 'required|email'

		);

	public function tipoUsuario()
	{
		return $this->belongsTo('TipoUsuario', 'idTipoUsuario');
	}

	public function getAuthIdentifier()
	{
		return $this->getKey();
	}

	public function getAuthPassword()
	{
		return $this->pwdusuario;
	}

	public function getRememberToken()
	{
		return $this->remember_token;
	}

	public function setRememberToken($value)
	{
		$this->remember_token = $value;
	}

	public function getRememberTokenName()
	{
		return "remember_token";
	}

	public function getReminderEmail()
	{
		return $this->mail;
	}

}
