<?php


namespace src;


trait DB
{
    private static $host = 'localhost';
    private static $user = 'root';
    private static $pass = '';
    private static $dbName = 'konmenager';
    private static $dbDriver = 'mysql';

    static $connect;


    static function connect()
    {
        try {
            $dsn = self::$dbDriver.":host=".self::$host.";dbname=".self::$dbName;
            $options = [\PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"];

            self::$connect = new \PDO($dsn, self::$user, self::$pass, $options);
            self::$connect->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);

        } catch (\PDOException $e) {
            echo $e->getMessage() ."in ".$e->getFile();

        }
        return self::$connect;

    }

}