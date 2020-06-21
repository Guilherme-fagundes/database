<?php


namespace database;

use database\DB;

/**
 * Class Read
 * @package src
 */
class Read
{

    /**
     * @var
     */
    private $db;
    /**
     * @var
     */
    private $table;
    /**
     * @var
     */
    private $read;
    /**
     * @var
     */
    private $statement;
    /**
     * @var
     */
    private $terms;
    /**
     * @var
     */
    private $result;

    /**
     * @var \PDOStatement
     */
    private $select;


    /**
     * Read constructor.
     */
    public function __construct()
    {

    }

    /**
     * @return mixed
     */
    public function getResult()
    {
        return $this->result;
    }

    /**
     * @param $table
     * @param null $parse
     * @return array
     */


    public function full($table, $parse = null)
    {
        $this->table = (string)$table;


        parse_str($parse, $this->statement);
        $this->read = DB::connect()->prepare("SELECT * FROM {$this->table}");
        $this->read->execute();
        return $this->result = $this->read->fetchAll(\PDO::FETCH_OBJ);


    }

    /**
     * @param string $table
     * @param string $terms
     * @param string $parse
     * @return mixed
     */
    public function find(string $table, string $terms, string $parse)
    {
        $this->table = $table;
        $this->terms = $terms;

        if ($parse) {
            parse_str($parse, $this->statement);
        }

        try {
            $this->read = DB::connect()->prepare("SELECT * FROM {$this->table} {$this->terms}");
            $this->read->execute($this->statement);
            return $this->result = $this->read->fetchAll(\PDO::FETCH_OBJ);
        } catch (\PDOException $e) {
            echo $e->getMessage() . " in " . $e->getFile();
        }
    }

    public function getRowCount()
    {
        return $this->select->rowCount();
    }


}