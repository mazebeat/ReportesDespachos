<?php

return array(

	'debug'       => true,
	'default'     => 'sqlsrv',
	'connections' => array(

		'sqlsrv'  => array(
			'driver'   => 'sqlsrv',
			'host'     => '10.185.30.243\INST1',
			'database' => 'ReportesDespachos',
			'username' => 'emessuser',
			'password' => 'emessuser2013',
			'prefix'   => '',
		),

		'sqlsrv2' => array(
			'driver'   => 'sqlsrv',
			'host'     => 'DPINTO-HP\SQLEXPRESS',
			'database' => 'test',
			'username' => 'sa',
			'password' => '120712',
			'prefix'   => '',
		),
	),

);
