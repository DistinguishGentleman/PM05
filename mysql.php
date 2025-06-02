<?php

class MySql extends mysqli
{
    public bool $isConnected = false;

    public function __construct(array $dbParams){
        $this->isConnected = parent::__construct($dbParams['hostname'], $dbParams['username'], $dbParams['password'], $dbParams['database'], $dbParams['port']);
        $this->set_charset($dbParams['charset']);
    }

    public function dbQuery(string $queryCode){
        $queryResult = $this->query($queryCode);

        if(is_array($queryResult)){
            return $queryResult->fetch_all();
        }
        return $queryResult;
    }

    public function isUnique(string $table, string $field, string $value){
        $queryResult = $this->query("SELECT COUNT($field) FROM `$table` WHERE $field = \"$value\"");
        return $queryResult->fetch_assoc()["COUNT($field)"];
    }
}