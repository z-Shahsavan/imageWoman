<?php
//error_reporting(E_ALL);
//ini_set('display_errors', 'Off');
//error_reporting(0);
ini_set('session.cookie_httponly',1);
ini_set('session.use_only_cookies',1);
function __autoload($class){
    require 'libs/'.$class.'.php';
}

require 'config/config.php';
$app=new Bootstrap();

