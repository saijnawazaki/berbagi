<?php
//Init
define('APP_PATH', dirname(__FILE__));
define('DB_PATH', APP_PATH.'/assets/berbagi.db');
define('APP_TITLE', 'Berbagi');
define('APP_VERSION', '1.1 Beta');
define('APP_URL', 'http://localhost/manastudio/public_html/app/berbagi/');
define('MAFURA_URL', 'http://localhost/mafura/dist/');

date_default_timezone_set('Asia/Jakarta');

error_reporting(E_ALL);
ini_set('display_errors', '1');