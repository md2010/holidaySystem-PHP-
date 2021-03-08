<?php

namespace App\Controllers;

use App\Models\Admin;
use App\Models\Employee;
use App\Models\TeamLeader;
use Loader;

class Controller 
{
    public function logIn()
    {      
        echo Loader::load()->render('login.twig');
    }

    public function validate()
    {
        $username = $_GET["username"];
        $password = $_GET["password"];  
        $user = preg_replace('/[0-9]+/', '', $username); //admin, employee, projectmanager, teamleader
        $class = self::resolveUser($user);     
        $e = new $class();
        $userID = filter_var($username, FILTER_SANITIZE_NUMBER_INT);
        $data = $e->getByID($userID);
        $e->create(array_values($data));
        if (! $e->validateLogIn($password)) {
            echo "Username or password incorrect!";
        } else if ($user == 'admin') {
            header("Location: http://holiday.local/".$user.'/');
        } else {
            header("Location: http://holiday.local/".$user.'/'.$userID);
        }
    }

    public function resolveUser($user)
    {
        if ($user == 'admin') {
            return 'App\Models\Admin';
        } else if ($user == 'teamleader') {
            return 'App\Models\TeamLeader';
        } else if ($user == 'employee') {
            return 'App\Models\Employee';
        }
    }

    public function logOut()
    {
        header("Location: http://holiday.local/");
    }

}