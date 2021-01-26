<?php


namespace Database;


use PDO;
use PDOException;
use PDOStatement;

/**
 * class DB
 * @package Database
 */
abstract class DB
{
    /**
     * @var mixed
     */
    private static $host = DB['host'];
    /**
     * @var mixed
     */
    private static $user = DB['user'];
    /**
     * @var mixed
     */
    private static $pass = DB['pass'];
    /**
     * @var mixed
     */
    private static $dbName = DB['name'];
    /**
     * @var mixed
     */
    private static $dbport = DB['port'];
    /**
     * @var mixed
     */
    private static $driver = DB['driver'];

    /**
     * @var
     */
    public static $connect;


    /**
     * @return PDO
     */
    protected function getConnect()
    {
        return self::connect();
    }






    ############################################################
    #################### PRIVATES METHODS #####################
    ############################################################


    /**
     * @return PDO
     * <p>Realiza a conexão com o banco de dados</p>
     */
    private function connect()
    {
        try {
            $dsn = self::$driver . ':host=' . self::$host . ';dbname=' . self::$dbName . ';port=' . self::$dbport;
            $options = DB['options'];
            self::$connect = new PDO($dsn, self::$user, self::$pass, $options);


        } catch (PDOException $ex) {
            echo "<p>Error:: {$ex->getCode()} | Message:: {$ex->getMessage()}</p>";
            echo "<p>FILE:: {$ex->getFile()} | LINE {$ex->getLine()}</p>";
        }
        return self::$connect;
    }

}