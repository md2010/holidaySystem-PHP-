<?php 

namespace App\Models;

class Admin extends BaseModel
{
    public $attributes = ['username','firstName', 'lastName', 'password'];

    public function __construct()
    {
        parent::__construct($this->attributes);
    }

    public function validateLogIn($password)
    {
        if($this->attributes["password"] == $password) {
            return true;
        } else {
            return false;
        }
    }   
    
    public function create (array $values = [])
    {  
        if(sizeof($values) != sizeof($this->attributes)) {
            $this->setKeyValue();
            $username = lcfirst($this->getTable());
            $username .= $this->getKeyValue();
            array_unshift($values, $username);
            array_unshift($values, $this->keyValue);
        } 
        $this->attributes = array_combine($this->attributes,$values);
    }

}