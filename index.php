<!DOCTYPE html>

 <?php

/* $string = '21-11-2015';
 $pattern = '/([0-9]{2})-([0-9]{2})-([0-9]{4})/';
 $replacemnt = 'Год $3, месяц $2, день $1';
 echo preg_replace($pattern, $replacemnt, $string);
 die;*/
 
 
 // front controller
 ini_set('display', 1);
 error_reporting(E_ALL);
 session_start();
 //echo 'dcvd';
 // 2. подключение
 
 define('ROOT', dirname(__FILE__));
 require_once (ROOT.'/components/Autoload.php');
 require_once (ROOT.'/components/Router.php');
 require_once (ROOT.'/components/Db.php');
 
 
 $router = new Router();
 $router->run();