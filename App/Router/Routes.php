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
        "/admin/" => AdminController::class.'::adminIndex',
        "/admin/addNewAdmin" =>  AdminController::class.'::addNewAdmin',
        "/admin/addNewEmployee" =>  AdminController::class.'::addNewEmployee',
        "/admin/addNewTeamLeader" =>  AdminController::class.'::addNewTeamLeader',
        "/admin/viewEmployers" => AdminController::class.'::viewEmployers',
        "/admin/viewHolidayRequests" => AdminController::class.'::viewHolidayRequests',
        "/admin/viewTeamLeaders" => AdminController::class.'::viewTeamLeaders',
        "/admin/viewTeamMembers" => AdminController::class.'::viewTeamMembers',
        "/admin/viewAdmins" => AdminController::class.'::viewAdmins',
        "/employee/:id" => EmployeeController::class.'::employeeIndex',
        "/employee/makeHolidayRequest" => EmployeeController::class.'::makeHolidayRequest'
    ]; 

    public $post_routes = [
        "/admin/processNewAdmin" => AdminController::class.'::processNewAdmin',
        "/admin/processNewEmployee" => AdminController::class.'::processNewEmployee',
        "/admin/processNewTeamLeader" => AdminController::class.'::processNewTeamLeader',
        "/admin/editEmployee" => AdminController::class.'::editEmployee',
        "/admin/delete" => AdminController::class.'::delete',
        "/admin/editTeamLeader" => AdminController::class.'::editTeamLeader',
        "/admin/editAdmin" => AdminController::class.'::editAdmin',
        "/employee/processHolidayRequest" => EmployeeController::class.'::processHolidayRequest'       
    ];

    /* not supported!
     public $delete_routes = [
        "/delete" => Controller::class.'::delete'
    ];

    public $put_routes = [
        "/update" => Controller::class.'::update'
    ]; */

}
    