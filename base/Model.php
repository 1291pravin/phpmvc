<?php

class Model {

    public static $table;
    private $errors;

    public function hasError() {
        return (count($this->errors)) > 0 ? true : false;
    }

    public static function find($where, $select = "*", $limit = 0) {
        $sql = "";
        $conditions = [];
        $parameters = [];        
        foreach ($where as $column_name => $where) {
            $conditions[] = $column_name . ' = ' . "?";
            $parameters[] = $where;
        }
        $sql = "SELECT $select FROM " . static::$table;
        if ($conditions) {
            $sql .= " WHERE " . implode(" AND ", $conditions);
        }
        if ($limit > 0) {
            $sql .= " LIMIT $limit";
        }

        $stmt = Database::getBdd()->prepare($sql);
        $stmt->execute($parameters);
        $data = $stmt->fetchAll(PDO::FETCH_CLASS, get_called_class());
        return $data;
    }
    
    public static function findOne($where, $select = "*") {
        $data = self::find($where,$select,1);       
        return $data ?  $data[0] : false;
    }

    public function save() {
        $parameters = get_object_vars($this);
        unset($parameters['errors']);
        $keys = array_keys($parameters);
        $keys = implode(",", $keys);
        $bind_param_string = "";
        foreach ($parameters as $parameter) {
            $bind_param_string .= "?,";
        }
        $bind_param_string = rtrim($bind_param_string, ",");
        $sql = "insert into " . static::$table . " ($keys) values ($bind_param_string)";
        $stmt = Database::getBdd()->prepare($sql);
        $stmt->execute(array_values($parameters));
        $databaseErrors = $stmt->errorInfo();
        if ($databaseErrors[0] != 0) {
            throw new Exception('Wrong Query');
        } else {
            $this->id = Database::getBdd()->lastInsertId();
        }
    }

    public function validate() {
        foreach ($this->rules() as $validation => $rules) {
            foreach ($rules[0] as $column) {
                switch ($validation) {
                    case 'required':
                        if (empty($this->$column)) {
                            $this->addError($column, $column . ' Cannot be empty');
                        }
                        break;
                    case 'min':
                        if (strlen($this->$column) < $rules[1]) {
                            $this->addError($column, $column . ' Should be more than ' . $rules[1] . ' characters');
                        }
                        break;
                    case 'mobile':
                        if (!preg_match('/^[0-9]{10}+$/', $this->$column)) {
                            $this->addError($column, $column . ' Contact Number should be of 10 digits');
                        }
                        break;
                    case 'email':
                        if (!filter_var($this->$column, FILTER_VALIDATE_EMAIL)) {
                            $this->addError($column, $column . ' is not a valid email');
                        }
                        break;
                    case 'unique':
                        $row = self::find([$column => $this->$column]);
                        if ($row) {
                            $this->addError($column, $column . ' is not unqiue');
                        }
                        break;
                    default:
                        break;
                }
            }
        }
        return true;
    }

    public function addError($id, $message) {
        $this->errors[$id][] = $message;
    }

    public function getError() {
        return $this->errors;
    }

}

?>