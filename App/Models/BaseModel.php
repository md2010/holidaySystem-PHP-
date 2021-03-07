<?php

namespace App\Models;

use App\Traits\HasAttributes;
use Database\DBConnection;
use PDO;

abstract class BaseModel
{
    use HasAttributes;

    protected $connection;
    protected $table;
    protected $primaryKey = 'id';
    protected $keyValue;
    public $exists = false;
    
    public function __construct (array $attributes = [])
    {   
        $instance = DBConnection::getInstance();
        $this->connection = $instance->getConnection();
        $this->setTable();
        $this->fill($attributes);
    }

    public function create(array $values = []) 
    {   
        if(sizeof($values) != sizeof($this->attributes)) {
            $this->setKeyValue();
            array_unshift($values, $this->keyValue);
        } 
        $this->attributes = array_combine($this->attributes,$values);
    }

    public function getByID($id)
    {
        $statement = $this->connection->prepare("SELECT * FROM $this->table WHERE id = ?");
        $statement->execute([$id]);
        $result = $statement->fetch(PDO::FETCH_ASSOC);
        return $result; 
    }

    public function getAll()
    {
        $statement = $this->connection->prepare("SELECT * FROM $this->table");
        $statement->execute();
        $result = $statement->fetchAll();
        return $result; 
    }

    public function save() 
    {
        $values = array_values($this->attributes);
        if (! $this->getByID($this->id)) {
            try {
                $questionMarks = $this->makePlaceholder($values);
                $statement = $this->connection->prepare("INSERT INTO $this->table VALUES (".$questionMarks. ")");
                $statement->execute($values);     
            } catch (PDO $e) {
                echo "Error" . $e->getMessage();
            }
        } else { 
            $this->update($this->id);
        } 
    }

    public function update($id) 
    {
        $sqlQuery = $this->columnsWithValues();
        $statement = $this->connection->prepare("UPDATE $this->table SET $sqlQuery WHERE id = ?");
        $statement->execute([$id]);  
    }

    public function updateAttribute($key, $value, $id)
    {
        $statement = $this->connection->prepare("UPDATE $this->table SET $key = $value WHERE id = ?");
        $statement->execute([$id]);  
    }

    public function columnsWithValues()
    {
        $keys = array_keys($this->attributes);
        $values = array_values($this->attributes);
        $sql = null;
        for ($i = 1; $i < sizeof($this->attributes); $i++) { //$i = 1 => ID se ne mijenja
            $sql .= $keys[$i]. '=';
            if (is_string($values[$i])) {
                $sql .= '"'.$values[$i].'"';
            } else { 
                $sql .= $values[$i];
            }
            if ($i != sizeof($values) - 1) {
                $sql .= ', ';
            }
        } 
        return $sql;
    }

    public function delete($id) //delete from DB
    {
        $statement = $this->connection->prepare("DELETE FROM $this->table WHERE id = ?");
        $statement->execute([$id]);
    }

    public function deletePermanently($id) //delete from DB and program
    {
        $statement = $this->connection->prepare("DELETE FROM $this->table WHERE id = ?");
        $statement->execute([$id]);
        $this->attributes = array(); 
    }

    private function makePlaceholder($values)
    {
        $str = null;
        for($i = 0; $i < sizeof($values); $i++){
            $str .= '?';
            if ($i != sizeof($values) - 1) {
                $str .= ', ';
            }
        }
        str_replace("'",'',$str);
        return $str;
    }

    public function setTable()
    {
        $obj = new \ReflectionClass(get_class($this));
        $this->table = $obj->getShortName();
    }

    public function getTable()
    {
        return $this->table;
    }

    protected function setKeyValue() 
    {
        $ids = $this->connection->query("SELECT id FROM $this->table ORDER BY id DESC LIMIT 1");
        $lastInsertID = $ids->fetchColumn();
        $this->keyValue = intval($lastInsertID + 1);
    }

    public function getKeyValue()
    {   
        return $this->keyValue;
    }

    public function __get($name) 
    {
        if (array_key_exists($name, $this->attributes)) {
            return $this->attributes[$name];
        } 
    }

    public function __set($name, $value)
    {
        $this->attributes[$name] = $value;
    }

    public function __isset($name)
    {
        return isset($this->attributes[$name]);
    }

    protected function fill(array $attributes = [])
    {
        array_unshift($attributes, 'id');
        $this->attributes = $attributes;
    }

    public function with($object) 
    {
        $objTable = $object->getTable();
        $column = $this->getTable().'id';
        $id = $this->attributes["id"];
        $statement = $this->connection->prepare("SELECT * FROM $objTable WHERE $column = ?");
        $statement->execute([$id]);
        $result = $statement->fetchAll();
        return $result; 
    }

}

