<?php

namespace App\Router;

use App\Controllers\Controller;
use App\Controllers\AdminController;
use App\Controllers\EmployeeController;

class Routes 
{
    public $get_routes = [
        '/' => Controller::class.'::logIn',
        "/validate" => Controller::class.'::validate',
        "/getByID" => Controller::class.'::getByID',
        "/logOut" =>  Controller::class.'::logOut',
        "/admin" => AdminController::class.'::adminIndex',
        "/addNewAdmin" =>  AdminController::class.'::addNewAdmin',
        "/addNewEmployee" =>  AdminController::class.'::addNewEmployee',
        "/addNewTeamLeader" =>  AdminController::class.'::addNewTeamLeader',
        "/viewEmployersAdmin" => AdminController::class.'::viewEmployers',
        "/viewTeamLeadersAdmin" => AdminController::class.'::viewTeamLeaders',
        "/viewTeamMembersAdmin" => AdminController::class.'::viewTeamMembers',
        "/viewAdmins" => AdminController::class.'::viewAdmins',
        "/employee" => EmployeeController::class.'::employeeIndex',
        "/makeHolidayRequest" => EmployeeController::class.'::makeHolidayRequest',
    ]; 

    public $post_routes = [
        "/processNewAdmin" => AdminController::class.'::processNewAdmin',
        "/processNewEmployee" => AdminController::class.'::processNewEmployee',
        "/processNewTeamLeader" => AdminController::class.'::processNewTeamLeader',
        "/editEmployee" => AdminController::class.'::editEmployee',
        "/delete" => AdminController::class.'::delete',
        "/editTeamLeader" => AdminController::class.'::editTeamLeader',
        "/editAdmin" => AdminController::class.'::editAdmin',
        "/processHolidayRequest" => EmployeeController::class.'::processHolidayRequest',
        "/update" => Controller::class.'::update',
    ];

    /* not supported!
     public $delete_routes = [
        "/delete" => Controller::class.'::delete'
    ];

    public $put_routes = [
        "/update" => Controller::class.'::update'
    ]; */

}
    