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
    private $query;

    /**
     * @var
     */
    private $limit;

    /**
     * @var
     */
    private $offset;

    /**
     * @var
     */
    private $page;
    /**
     * @var
     */
    private $link;
    /**
     * @var
     */
    private $rows;
    /**
     * @var
     */
    private $maxLinks;
    /**
     * @var
     */
    private $first;
    /**
     * @var
     */
    private $last;

    private $paginator;

    /**
     * @var
     */
    private $result;


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

    public function query(string $query, string $parse = null)
    {
        if ($parse) {
            parse_str($parse, $this->statement);

        }

        $this->query = $query;
        $this->read = DB::connect()->prepare($this->query);
        $this->read->execute($this->statement);
        $this->rows = $this->read->rowCount();
        $this->result = $this->read->fetchAll(\PDO::FETCH_OBJ);
        return $this;


    }

    /**
     * @param $table
     * @return $this
     */
    public function all($table)
    {
        $this->table = (string)$table;


        $this->read = DB::connect()->prepare("SELECT * FROM {$this->table}");
        $this->read->execute();
        $this->rows = $this->read->rowCount();
        return $this->result = $this->read->fetchAll(\PDO::FETCH_OBJ);

        return $this;

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
            $this->rows = $this->read->rowCount();
            return $this->result = $this->read->fetchAll(\PDO::FETCH_OBJ);
        } catch (\PDOException $e) {
            echo $e->getMessage() . " in " . $e->getFile();
        }

        return $this;
    }

    /**
     * @return int
     */
    public function getRowCount()
    {
        return $this->rows;

    }



}