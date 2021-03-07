<?php

namespace App\Controllers;

use App\Models\Employee;
use App\Models\HolidayRequestEmployee;
use Loader;

class EmployeeController 
{

    public function employeeIndex($id)
    {
        $e = new Employee();
        $employee = $e->getByID($id);
        $data = array();
        array_push($data, $employee);
        echo Loader::load()->render('employee.twig', array('employers' => $data));          
    }

    public function makeHolidayRequest()
    {
        echo Loader::load()->render('makeHolidayRequestEmployee.twig');
    }

    public function processHolidayRequest()
    {
        $request = new HolidayRequestEmployee();
        $data = $_POST["data"];
        if(! $data[0]) {
            echo "Invalid request. Employee ID can't be empty!.\n\n";
            header('Refresh: 2; URL=http://holiday.local/makeHolidayRequest');
            return;
        } else if($request->create($data)) {
            $request->save();
            echo "Request sent!\n\n";
        } else {
            echo "Invalid request. You don't have enough days left.\n\n";
        }
        echo "You're being rediracted...";
        header('Refresh: 2; URL=http://holiday.local/employee?'.$data[0]);
    }

}