<?php


namespace database;


/**
 * Class Update
 * @package src
 */
class Update
{
    /**
     * @var
     */
    private $table;
    /**
     * @var
     */
    private $update;
    /**
     * @var
     */
    private $statements;
    /**
     * @var
     */
    private $result;
    /**
     * @var
     */
    private $error;
    /**
     * @var
     */
    private $terms;
    /**
     * @var
     */
    private $places;
    /**
     * @var
     */
    private $data;


    /**
     * Update constructor.
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
     * @param string $table
     * @param array $data
     * @param string $terms
     * @param string $parse
     */
    public function update(string $table, array $data, string $terms, string $parse)
    {
        $this->table = $table;
        $this->terms = $terms;
        $this->data = $data;
        parse_str($parse, $this->statements);

        foreach ($data as $key => $value){
            $this->places[] = $key.' = :'.$key;

        }

        $this->places = implode(', ', $this->places);

        $this->update = "UPDATE {$this->table} SET {$this->places} {$this->terms}";

        try{
            $this->result = DB::connect()->prepare($this->update);
            $this->result->execute(array_merge($this->data, $this->statements));
            $this->error = true;


        }catch (\PDOException $e){
            echo $e->getMessage();

        }


    }

}