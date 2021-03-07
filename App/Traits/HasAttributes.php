<?php

namespace App\Traits;

trait HasAttributes
{
    protected $attributes = [];

    public function getAttributes()
    {
        return $attributes;
    }

    public function setAttribute($key, $value)
    {
        if (! is_null($value) && array_key_exists($key, $this->attributes)) {
            $this->attributes[$key] = $value;
            echo "set";
            return $this;
        } 
    } 
  
    public function checkAttribute($key)
    {
        if (! $key) {
            return false;
        }
        if (in_array($key, $this->attributes)) {
            return true;
        }
        else 
        {
            echo 'Invalid attribute';
            echo "<br>";
        }
    }

}



    