<?php 

namespace Database;

use PDO;

class DBConnection 
{
    private static $instance = null;
    private $conn;
    protected $servername = "localhost";
    protected $dbname = "company";
    protected $user = "root";
    protected $password = "1234";

    public function __construct() 
    {   
        try {
            $this->conn =  new PDO("mysql:host=$this->servername;dbname=$this->dbname", 
                        $this->user, $this->password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDO $e)
        {
            echo $e->getMessage();
        }
    }

    public static function getInstance()
    {
        if(!self::$instance) {
            self::$instance = new DBConnection();
        }  
        return self::$instance;
    }

    public function getConnection()
    {
        return $this->conn;
    }

}

