<?php

class Db {

    public static function getConnection() {
        $paramsPath = ROOT . '/config/db_params.php';
        $params = include ($paramsPath);

        //   $dsn = "mysql:host= {$params['host']};dbname={$params['dbname']};charset={$params['charset']}";
        // $db = new PDO($dsn, $params['user'], $params['password']);
        //$db = new PDO("mysql:host={$params['host']};dbname={$params['dbname']};charset=utf8", $params['user'], $params['password']);
//$db->exec("set names utf8"); 
        
        $dsn = "mysql:host={$params['host']};dbname={$params['dbname']}";
        $db = new PDO($dsn, $params['user'], $params['password']);

        // Задаем кодировку
        $db->exec("set names utf8");
        
        return $db;
    }

}

/* $host = 'localhost';
                $dbname = 'pegas';
                $user ='root';
                $password = '';
                $db= new PDO ("mysql:host=$host;dbname=$dbname;charset=utf8",$user,$password);*/
/*
 * try {
    $dbh = new PDO($dsn, $user, $password);
} catch (PDOException $e) {
    echo 'Подключение не удалось: ' . $e->getMessage();
}

 */