<?php


namespace Database;


use PDO;
use PDOException;

/**
 * Class Database
 * @package Database
 */
abstract class Database extends DB
{
    /**
     * @var
     */
    protected $rowCount;

    /**
     * @var
     */
    protected $offset;
    /**
     * @var
     */
    protected $limit;
    /**
     * @var
     */
    protected $page;
    /**
     * @var
     */
    protected $findByEmail;
    /**
     * @var string
     */
    protected $primary_key = 'id';
    /**
     * @var
     */
    protected $findById;
    /**
     * @var
     */
    protected $perPage;

    /**
     * @var
     */
    protected $links;
    /**
     * @var
     */
    protected $findParam;

    /**
     * @var
     */
    protected $lastInsertId;
    /**
     * @var
     */
    protected $table;
    /**
     * @var PDO
     */
    private $conn;
    /**
     * @var array
     */
    protected $data = [];
    /**
     * @var
     */
    private $arrPlaces;
    /**
     * @var
     */
    protected $sql;
    /**
     * @var
     */
    protected $get;
    /*
     * @var \PDOStatements
     * */
    /**
     * @var
     */
    protected $statements;

    /**
     * Database constructor.
     */
    public function __construct()
    {
        $this->conn = parent::getConnect();


    }

    /**
     * @return mixed
     */
    public function getGet()
    {
        return $this->get;

    }

    /**
     * @return mixed
     */
    public function getOffset()
    {
        return $this->offset;
    }

    /**
     * @return mixed
     */
    public function getLimit()
    {
        return $this->limit;
    }


    /**
     * @param $name
     * @param $value
     */
    public function __set($name, $value)
    {
        $this->data[$name] = $value;
    }

    /**
     * @param $name
     * @return mixed
     */
    public function __get($name)
    {
        if (array_key_exists($name, $this->data)) {
            return $this->data[$name];
        }
    }

    /**
     * @return $this
     */
    public function getRowCount()
    {
        return $this->rowCount;
    }



    /**
     * @return $this
     */
    public function all()
    {
        $this->sql = "SELECT * FROM {$this->table}";

        try {
            $this->statements = $this->conn->prepare($this->sql);
            $this->statements->execute();
            $this->rowCount = $this->statements->rowCount();
            $this->get = $this->statements->fetchAll();


        } catch (PDOException $ex) {
            echo "<p>Error:: {$ex->getCode()} | Message:: {$ex->getMessage()}</p>";
            echo "<p>FILE:: {$ex->getFile()} | LINE {$ex->getLine()}</p>";
        }
        return $this;

    }

    /**
     *
     */
    public function save()
    {
        $places = implode(', ', array_keys($this->data));
        $values = ':' . implode(', :', array_keys($this->data));
        if (in_array($this->primary_key, array_keys($this->data))) {
            $unsetkey = array_search($this->primary_key, array_keys($this->data));


            foreach ($this->data as $keys => $values):
                $data[] = $keys . ' = :' . $keys;
                unset($data[$unsetkey]);

            endforeach;
            $primary_key = $this->data[$this->primary_key];
            $this->arrPlaces = $this->data;

            $data = implode(', ', $data);

            $this->sql = "UPDATE {$this->table} SET {$data} WHERE {$this->primary_key} = :{$this->primary_key}";

            try {
                $this->statements = $this->conn->prepare($this->sql);
                $this->statements->execute($this->arrPlaces);
                $this->rowCount = $this->statements->rowCount();

            } catch (PDOException $ex) {
                echo "<p>Error:: {$ex->getCode()} | Message:: {$ex->getMessage()}</p>";
                echo "<p>FILE:: {$ex->getFile()} | LINE {$ex->getLine()}</p>";
            }


        } else {
            $this->sql = "INSERT INTO {$this->table} ({$places}) VALUES({$values})";

            try {
                $this->statements = $this->conn->prepare($this->sql);
                $this->statements->execute($this->data);
                $this->lastInsertId = $this->conn->lastInsertId();
                $this->rowCount = $this->statements->rowCount();
            } catch (PDOException $ex) {
                echo "<p>Error:: {$ex->getCode()} | Message:: {$ex->getMessage()}</p>";
                echo "<p>FILE:: {$ex->getFile()} | LINE {$ex->getLine()}</p>";
            }
        }


    }

    /**
     * @param int $id
     * @return $this
     */
    public function findById(int $id)
    {
        $this->findById = $id;
        $this->sql = "SELECT * FROM {$this->table} WHERE {$this->primary_key} = :{$this->primary_key}";
        $this->arrPlaces = [
            $this->primary_key => $this->findById
        ];

        try {
            $this->statements = $this->conn->prepare($this->sql);
            $this->statements->execute($this->arrPlaces);
            $this->rowCount = $this->statements->rowCount();
            $this->get = $this->statements->fetch();


        } catch (PDOException $ex) {
            echo "<p>Error:: {$ex->getCode()} | Message:: {$ex->getMessage()}</p>";
            echo "<p>FILE:: {$ex->getFile()} | LINE {$ex->getLine()}</p>";
        }
        return $this;


    }

    /**
     * @param string $email
     * @return $this
     */
    public function findByEmail(string $email)
    {
        $this->findByEmail = 'email';

        $this->sql = "SELECT * FROM {$this->table} WHERE {$this->findByEmail} = :{$this->findByEmail}";
        $this->arrPlaces = [
            $this->findByEmail => $email
        ];

        try {
            $this->statements = $this->conn->prepare($this->sql);
            $this->statements->execute($this->arrPlaces);
            $this->rowCount = $this->statements->rowCount();
            $this->get = $this->statements->fetch();


        } catch (PDOException $ex) {
            echo "<p>Error:: {$ex->getCode()} | Message:: {$ex->getMessage()}</p>";
            echo "<p>FILE:: {$ex->getFile()} | LINE {$ex->getLine()}</p>";
        }
        return $this;

    }

    /**
     * @param string $terms
     * @param array $parse
     * @return $this
     */
    public function findAny(string $terms, array $parse)
    {
        $this->findParam = $terms;
        $this->arrPlaces = $parse;
        $this->sql = "SELECT * FROM {$this->table} WHERE {$this->findParam}";

        try {
            $this->statements = $this->conn->prepare($this->sql);
            $this->statements->execute($this->arrPlaces);
            $this->rowCount = $this->statements->rowCount();
            $this->get = $this->statements->fetchAll();


        } catch (PDOException $ex) {
            echo "<p>Error:: {$ex->getCode()} | Message:: {$ex->getMessage()}</p>";
            echo "<p>FILE:: {$ex->getFile()} | LINE {$ex->getLine()}</p>";
        }
        return $this;

    }


    /**
     * @param int|string $param
     * @param array|null $parse
     *
     */
    public function delete($param, array $parse = null)
    {
        if (is_int($param)) {
            $this->sql = "DELETE FROM {$this->table} WHERE {$this->primary_key} = :{$this->primary_key}";
            $this->arrPlaces = [
                $this->primary_key => $param
            ];


        }
        try {
            $this->statements = $this->conn->prepare($this->sql);
            $this->statements->execute($this->arrPlaces);
            $this->rowCount = $this->statements->rowCount();


        } catch (PDOException $ex) {
            echo "<p>Error:: {$ex->getCode()} | Message:: {$ex->getMessage()}</p>";
            echo "<p>FILE:: {$ex->getFile()} | LINE {$ex->getLine()}</p>";
        }
        return $this;

    }

    /**
     * @param int|null $limit
     * @param int|null $offset
     */
    public function paginate($limit = 15, $offset = 0)
    {
        $this->limit = $limit;
        $this->offset = $offset;

        $this->page = filter_input(INPUT_GET, 'page', FILTER_VALIDATE_INT);
        $this->page = (isset($this->page) ? $this->page : 1);

        $totalPerPage = ceil($this->getRowCount() / $this->limit);
        if ($this->page > $totalPerPage){
            $this->page -= 1;
        }

        $this->offset = ($this->limit * $this->page) - $this->limit;

        $this->sql .= " limit {$this->limit} OFFSET {$this->offset}";


        try {
            $this->statements = $this->conn->prepare($this->sql);
            $this->statements->execute();
            $this->rowCount = $this->statements->rowCount();
            $this->get = $this->statements->fetchAll();


        } catch (PDOException $ex) {
            echo "<p>Error:: {$ex->getCode()} | Message:: {$ex->getMessage()}</p>";
            echo "<p>FILE:: {$ex->getFile()} | LINE {$ex->getLine()}</p>";
        }
        return $this;

    }


}