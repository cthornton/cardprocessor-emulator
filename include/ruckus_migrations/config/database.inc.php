<?php

$conf = require_once('db/config.php');


//----------------------------
// DATABASE CONFIGURATION
//----------------------------
$ruckusing_db_config = array(
	
    'development' => array(
        'type'      => 'mysql',
        'host'      => $conf['host'],
        'port'      => 3306,
        'database'  => $conf['name'],
        'user'      => $conf['user'],
        'password'  => $conf['pass']
    ),

	'test' 					=> array(
			'type' 			=> 'mysql',
			'host' 			=> 'localhost',
			'port'			=> 3306,
			'database' 	=> 'ruckusing_migrations_test',
			'user' 			=> 'root',
			'password' 	=> ''
	)
	
);


?>