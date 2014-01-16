<?php

$db="aimaster1209";

if(!$GLOBALS['isLocal']){

define('HOST',"pzdt6wgvt1.database.windows.net");
define('DB',$db);
define('DB_USER','aimaster1209');
define('DB_PASS','Aimaster9999');

}else{

# kiyosawa local
define('HOST',"localhost\SQLExpress");
#define('HOST',"localhost");
define('DB',$db);
define('DB_USER','');
define('DB_PASS','');

}

class DATABASE_CONFIG {

	public $default = array(
		'datasource' => 'Database/SqlserverLog',
		'driver'=>'sqlsrv',
		'persistent' => false,
		'host' => HOST,
		'login' => DB_USER,
		'password' => DB_PASS,
		'database' => DB,
		'prefix' => '',
		#'encoding' => 'utf8',
	);
	public $test = array(
		'datasource' => 'Database/Mysql',
		'persistent' => false,
		'host' => HOST,
		'login' => DB_USER,
		'password' => DB_PASS,
		'database' => DB,
		'prefix' => '',
		'encoding' => 'utf8',
	);
}


?>
