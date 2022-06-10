<?php
//Init
define('ASSETS_PATH', 'assets/');
define('DB_PATH', ASSETS_PATH.'berbagi.db');
define('APP_TITLE', 'Berbagi');
define('APP_VERSION', '1.1 Beta');
define('APP_URL', 'http://localhost/berbagi/');
define('APP_PATH', dirname(__FILE__));

date_default_timezone_set('Asia/Jakarta');

session_start();

$ses_username = isset($_SESSION['ses_username']) ? $_SESSION['ses_username'] : '';
$ses = array();

if($ses_username != '')
{
    $ses['user_id'] = $_SESSION['ses_user_id'];
    $ses['username'] = $_SESSION['ses_username'];
    $ses['display_name'] = $_SESSION['ses_display_name'];
    $ses['role_id'] = $_SESSION['ses_role_id'];    
}


$page = isset($_GET['page']) ? $_GET['page'] : '';

//check
if($ses_username == '')
{
    if($page != 'login')
    {
        header('location: '.APP_URL.'?page=login');    
    }
    else
    {   
        //$_SESSION['mess'] = 'Need Login';
    }    
}
else
{
    if(! preg_match('/^[a-z0-9-_]{3,20}$/', $ses_username))
    {
        if($page != 'fatal_error')
        {
            header('location: '.APP_URL.'?page=fatal_error');    
        }
                
    }    
}
    
//Connect SQLite
$db = new SQLite3(DB_PATH) or die('Error Connect DB');
//print_r($_SESSION);
require 'base.php';