<?php

class Database extends PDO {

    public function __construct() {
      parent::__construct(DB_TYPE.':host='.DB_HOST.';dbname='.DB_NAME, 
                          DB_USER, DB_PASS);
    }

    private function unsetNonExistent($array, $keys) {
        $newArray = array();
        foreach ($keys as $key)
            if (isset($array[$key]))
                $newArray[$key] = $array[$key];
        return $newArray;
    }

    public function insertQuery($table, $columns, $values) {
        $query = "INSERT INTO $table (";
        foreach ($columns as $column)
            $query .= $column . ', ';
        $query = rtrim($query, ' ,');
        $query .= ') VALUES (';
        foreach ($columns as $column)
            $query .= ':'.$column . ', ';
        $query = rtrim($query, ' ,');
        $query.= ')';
        $this->executeQuery($query, $values);
    }

    public function executeQuery($query, $values = array()) {
        $preparedValues = array();
        if (!empty($values))
            foreach ($values as $key => $val)
                $preparedValues[':'.$key] = $val;
//        echo $query."<br>";
//        var_dump($preparedValues);
        $statement = $this->prepare($query);
        $success = $statement->execute($preparedValues);
        if (!$success) {
            $errorMessage = 'Database exception: ';
            $errors = $statement->errorInfo();
            foreach($errors as $error)
                $errorMessage .= $error;
            throw new Exception($errorMessage);
        }
        return $statement;
    }

}
