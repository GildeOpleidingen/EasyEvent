<?php

namespace App\Controllers;

use App\Controller;

class RegisterController extends Controller
{
    public function index()
    {

        $this->render('register');
    }

    public function register()
    {
        {
            $voornaam = $_POST['voornaam'];
            $achternaam = $_POST['achternaam'];
            $telefoon = $_POST['telefoon'];
            $email = $_POST['email'];
            $wachtwoord = $_POST['wachtwoord'];
        }
        
        $count = $this->model->checkUser($email);

        if ($count > 0) {
            return "gebruiker bestaat al";
        } else {
            $this->model->register($voornaam, $achternaam, $telefoon, $email, $wachtwoord);
            return "gebruiker bestaat niet";
        }
    }
}