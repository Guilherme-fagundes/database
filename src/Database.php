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
    protected $limit;
    /**
     * @var
     */
    protected $offset;
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
    /**
     * @var
     */
    protected $rowCount;
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
     * @return mixed
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
        $this->sql = "INSERT INTO {$this->table} ({$places}) VALUES({$values})";

        try {
            $this->statements = $this->conn->prepare($this->sql);
            $this->statements->execute($this->data);
            $this->lastInsertId = $this->conn->lastInsertId();
        } catch (PDOException $ex) {
            echo "<p>Error:: {$ex->getCode()} | Message:: {$ex->getMessage()}</p>";
            echo "<p>FILE:: {$ex->getFile()} | LINE {$ex->getLine()}</p>";
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


}