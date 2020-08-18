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
     * @var \PDOStatement
     */
    private $select;

    private $query;

    /**
     * @var
     */
    private $limit;

    /**
     * @var
     */
    private $offset;

    private $page;
    private $link;
    private $rows;
    private $maxLinks;
    private $first;
    private $last;

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
        $this->result = $this->read->fetchAll(\PDO::FETCH_OBJ);
        return $this;


    }

    public function all($table)
    {
        $this->table = (string)$table;


        $this->read = DB::connect()->prepare("SELECT * FROM {$this->table}");
        $this->read->execute();
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
            return $this->result = $this->read->fetchAll(\PDO::FETCH_OBJ);
        } catch (\PDOException $e) {
            echo $e->getMessage() . " in " . $e->getFile();
        }

        return $this;
    }

    public function getRowCount()
    {
        return $this->select->rowCount();
        return $this;
    }

    public function page(int $pag = null, int $limit)
    {
        $this->page = ($pag ? $pag : 1);
        $this->limit = $limit;
        $this->offset = ($this->page * $this->limit) - $this->limit;

        try {

            $this->read = DB::connect()->prepare("SELECT * FROM {$this->table} LIMIT {$this->limit} OFFSET {$this->offset}");
            $this->read->execute();
            $this->result = $this->read->fetchAll(\PDO::FETCH_OBJ);
        }catch (\PDOException $e){
            echo $e->getMessage() . " in " . $e->getFile();

        }


    }


}