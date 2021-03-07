<?php

namespace App\Controllers;

use App\Models\Admin;
use App\Models\Employee;
use App\Models\TeamLeader;
use App\Controllers\Controller;
use Loader;

class AdminController 
{
    public function adminIndex()
    {
        echo Loader::load()->render('admin.twig');
    }

    public function viewAdmins($id)
    {
        $data = array();
        $a = new Admin();
        if($id) {   //viewAdmins?:ID
            $admin = $a->getByID($id);
            array_push($data, $admin);
        } else {
            $data = $a->getAll();
        }
        if($data) {
            echo Loader::load()->render('viewAdmins.twig', array('admins' => $data));
        } else {
            echo "Nothing in DB!";
        }
    }

    public function viewEmployers($id)
    {
        $data = array();
        $e = new Employee();
        if($id) {   //viewEmployers?:ID
            $employee = $e->getByID($id);
            array_push($data, $employee);
        } else {
            $data = $e->getAll();
        }
        if($data) {
            echo Loader::load()->render('viewEmployersAdmin.twig', array('employers' => $data));
        } else {
            echo "Nothing in DB!";
        }
    }

    public function editAdmin()
    {
        $a = new Admin();
        $values = $_POST["data"]; //mora biti istim redom u formi kao u DB !!
        $a->create($values);
        $a->save();
        header("Location: http://holiday.local/viewAdmins");
    }

    public function editEmployee()
    {
        $e = new Employee();
        $values = array($_POST["id"], $_POST["username"],$_POST["firstName"],$_POST["lastName"],
                $_POST["password"],$_POST["teamLeaderID"], $_POST["projectManagerID"],$_POST["days"]);
        $e->create($values);
        $e->save();
        header("Location: http://holiday.local/viewEmployersAdmin");
    }

    public function viewTeamLeaders($id)
    {
        $tl = new TeamLeader();
        $data = array();
        if($id) {   //viewTeamLeaders?:ID
            $teamLeader= $tl->getByID($id);
            array_push($data, $teamLeader);
        } else {
            $data = $tl->getAll();
        }
        if($data) {
            echo Loader::load()->render('viewTeamLeadersAdmin.twig', array('teamLeaders' => $data));
        } else {
            echo "Nothing in DB!";
        }
    }

    public function viewTeamMembers()
    {
        $e = new Employee();
        $tl = new TeamLeader();
        $tl->id = $_GET["id"];
        $data = $tl->with($e);
        if($data) {
            echo Loader::load()->render('viewEmployersAdmin.twig', array('employers' => $data));
        } else {
            echo "Nothing in DB!";
        }
    }

    public function editTeamLeader()
    {
        $tl = new TeamLeader();
        $values = array($_GET["id"], $_POST["username"],$_POST["firstName"],$_POST["lastName"],
                $_POST["password"], $_POST["projectManagerID"],$_POST["days"]);
        $tl->create($values);
        $tl->save();
        header("Location: http://holiday.local/viewTeamLeadersAdmin");
    }

    public function addNewAdmin()
    {
        echo Loader::load()->render('addNewAdmin.twig');
    }

    public function processNewAdmin()
    {
        $values = $_POST['data'];
        $admin = new Admin();
        $admin->create($values);
        $admin->save();
        header("Location: http://holiday.local/admin");
    }

    public function addNewEmployee()
    {
        echo Loader::load()->render('addNewEmployee.twig');
    }

    public function processNewEmployee() 
    {
        $values = $_POST['data'];
        $e = new Employee();
        $e->create($values);
        $e->save();
        header("Location: http://holiday.local/admin");
    }

    public function addNewTeamLeader()
    {
        echo Loader::load()->render('addNewTeamLeader.twig');
    }

    public function processNewTeamLeader()
    {
        $values = $_POST['data'];
        $tl = new TeamLeader();
        $tl->create($values);
        $tl->save();
        header("Location: http://holiday.local/admin");
    }

    public function delete()
    {
        $username = $_POST["username"];
        $user = preg_replace('/[0-9]+/', '', $username); //admin, employee, projectmanager, teamleader
        $class = Controller::resolveUser($user);   
        $e = new $class();
        $id = $_POST["id"];
        $e->deletePermanently($id);
        header("Location: http://holiday.local/admin");
    }
}