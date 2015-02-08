<?php

class TipoUsuario extends \Eloquent
{
	protected $table = 'TipoUsuario';
	protected $primaryKey = 'idTipoUsuario';
	protected $fillable
		= [
			'Descripcion',
			'Codigo'
		];

	public function usuarios()
	{
		return $this->hasMany('Usuarios', 'idTipoUsuario');
	}
}
