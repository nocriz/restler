<?php

return array(
	'default' => 'mysql',
	'connections' => array(

		'sqlite' => array(
			'driver'   => 'sqlite',
			'database' => 'application',
			'prefix'   => '',
		),

		'mysql' => array(
			'driver'   => 'mysql',
			'host'     => 'localhost',
			'database' => 'api',
			'username' => 'root',
			'password' => '',
			'charset'  => 'utf8',
			'prefix'   => '',
		),

		'pgsql' => array(
			'driver'   => 'pgsql',
			'host'     => '127.0.0.1',
			'database' => 'database',
			'username' => 'root',
			'password' => '',
			'charset'  => 'utf8',
			'prefix'   => '',
			'schema'   => 'public',
		),

		'sqlsrv' => array(
			'driver'   => 'sqlsrv',
			'host'     => '127.0.0.1',
			'database' => 'database',
			'username' => 'root',
			'password' => '',
			'prefix'   => '',
		)
	)
);