<?php


namespace database;


trait DB
{
    private static $host = DB['host'];
    private static $user = DB['user'];
    private static $pass = DB['pass'];
    private static $dbName = DB['name'];
    private static $dbDriver = DB['driver'];

    static $connect;


    static function connect()
    {
        try {
            $dsn = self::$dbDriver.":host=".self::$host.";dbname=".self::$dbName;
            $options = [\PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8",
                \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_OBJ];

            self::$connect = new \PDO($dsn, self::$user, self::$pass, $options);
            self::$connect->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);

        } catch (\PDOException $e) {
            echo $e->getMessage() ."in ".$e->getFile();

        }
        return self::$connect;

    }

}