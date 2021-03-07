<?php

namespace App\Models;

use App\Models\Employee;
use Database\DBConnection;
use PDO;

class HolidayRequestEmployee extends BaseModel
{
    public $attributes = ['employeeID', 'firstName', 'lastName', 'fromDate', 'toDate', 
                          'days', 'status', 'projectManagerApproval', 'teamLeaderApproval'];
    private $employee;

    public function __construct()
    {
        parent::__construct($this->attributes);
        $this->employee = new Employee();
        $instance = DBConnection::getInstance();
        $this->connection = $instance->getConnection();
    }

    public function create(array $values = [])
    {  
        if(sizeof($values) != sizeof($this->attributes)) {
            $days = $this->dayDifference($values);
            if($this->validateHoliday($values[0], $days)) {
                $this->setKeyValue();
                array_unshift($values, $this->keyValue);
                array_push($values, $days);
                array_push($values, "sent");
                array_push($values, false);
                array_push($values, false);
                $this->attributes = array_combine($this->attributes,$values);
                return true;
            } else {
                return false;
            }
        } 
        $this->attributes = array_combine($this->attributes,$values);
    }

    public function validateHoliday($employeeID, $days)
    {
        $table = $this->employee->getTable();
        $statement = $this->connection->query("SELECT days FROM $table WHERE id = $employeeID");
        $employeeDays = $statement->fetchColumn();
        if($employeeDays - $days > 0) {
           return true;
        } 
        return false;
    }

    public function dayDifference(array $data = [])
    {
        $dateFrom = date_create($data[3]);
        $dateTo = date_create($data[4]);
        $diff = date_diff($dateFrom, $dateTo);
        return $diff->d;
    }

}
