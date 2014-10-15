<?php
return array(
    'fetch' => PDO::FETCH_CLASS,
    'default' => 'mysql',
    'connections' => array(
        'mysql' => array(
            'driver' => 'mysql',
            'host' => 'lpa.devebs.net',
            'database' => 'c1lpa',
            'username' => 'c1lpa',
            'password' => 'FE27wbyzGi',
            'charset' => 'utf8',
            'collation' => 'utf8_unicode_ci',
            'prefix' => '',
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
