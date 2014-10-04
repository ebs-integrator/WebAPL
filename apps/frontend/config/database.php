<?php
return array(
    'fetch' => PDO::FETCH_CLASS,
    'default' => 'sqlite',
    'connections' => array(
        'sqlite' => array(
			'driver'   => 'sqlite',
			'database' => __DIR__.'/../database/production.sqlite',
			'prefix'   => '',
		)
    ),
    'migrations' => 'migrations',
    'redis' => array(
        'cluster' => false,
        'default' => array(
            'host' => '127.0.0.1',
            'port' => 6379,
            'database' => 0,
        ),
    ),
);
