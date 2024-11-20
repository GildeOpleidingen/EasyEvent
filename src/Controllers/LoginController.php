<?php

namespace App\Controllers;

use App\Controller;

class LoginController extends Controller
{
    public function index()
    {
        if(isset($_SESSION['Gebruikersnaam'])){
            header('Location: HTTP://' . $_SERVER["HTTP_HOST"] . "/events");
        }
        $this->render('login');
    }

    public function __construct()
    {
        $this->model = new \App\Models\LoginModel();
    }

    public function login(){
        $reslt = $this->model->login($_POST["Gebruikersnaam"], $_POST["wachtwoord"]); 

        if($reslt == "events"){
            header('Location: HTTP://' . $_SERVER["HTTP_HOST"] . "/events");
        } else {
            $this->render('login', ['error' => 'Gebruikersnaam en wachtwoord komen niet overeen.']);
            return;
        }
        
    }

    public function logout(){
        session_destroy();

        header('Location: HTTP://' . $_SERVER["HTTP_HOST"] . "/login");
    }

}