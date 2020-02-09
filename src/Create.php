<?php


namespace src;


class Create
{

    private $table;
    private $create;
    private $result;
    private $error;
    private $data;
    private $statements;


    public function __construct()
    {

    }

    public function create(string $table, array $data)
    {
        $this->data = $data;
        $this->table = $table;
        $this->data = array_map('strip_tags', $this->data);
        $this->data = array_map('trim', $this->data);

        if ($this->data) {
            $this->setdata();
        }
    }


    private function setdata()
    {
        $fields = implode(', ', array_keys($this->data));
        $places = ':'.implode(', :', array_keys($this->data));
        $this->create = "INSERT INTO {$this->table} ({$fields}) VALUES ({$places})";

        try{

            $this->statements = DB::connect()->prepare($this->create);
            $this->statements->execute($this->data);
            $this->result = DB::connect()->lastInsertId();

        }catch (\PDOException $e){
            echo $e->getMessage();

        }

    }

}