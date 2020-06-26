<?php
/**
 * Created by PhpStorm.
 * User: Usuario
 * Date: 05/02/2020
 * Time: 21:44
 */

namespace database;


class Delete
{

    private $table;
    private $terms;
    private $delete;
    private $statements;
    private $result;
    private $error;


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



    public function delete(string $table, string $terms, string $parseString)
    {
        $this->table = $table;
        $this->terms = $terms;

        parse_str($parseString, $this->statements);

        $this->delete = "DELETE FROM {$this->table} {$this->terms}";

        try{
            $this->result = DB::connect()->prepare($this->delete);
            $this->result->execute($this->statements);
            $this->error = true;

        }catch (\PDOException $e){
            echo $e->getMessage();

        }

    }

}