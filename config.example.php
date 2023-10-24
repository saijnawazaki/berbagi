<?php
//APP
define('APP_PATH', dirname(__FILE__));
define('APP_URL', 'http://localhost/berbagi/'); //Using $_SERVER['SERVER_NAME'] if multiple Domain
define('MAFURA_URL', 'https://manastudio.id/repo/public/manastudio/mafura/');
date_default_timezone_set('Asia/Jakarta');  

//DB
define('DB_CONNECTOR', 'sqlite'); //sqlite, mysqli
define('DB_USERNAME', 'root');
define('DB_PASSWORD', '');
define('DB_SERVERNAME', 'localhost');
define('DB_DATABASE', 'berbagi');
define('DB_PATH', APP_PATH.'/assets/berbagi.db'); 

//ENV
error_reporting(E_ALL);
ini_set('display_errors', '1');