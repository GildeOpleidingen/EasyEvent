<?php

namespace App\Controllers;

use App\Controller;
use App\Models\RegisterModel;

class RegisterController extends Controller
{
    private $model;

    public function index()
    {
        $this->render('register');
    }

    public function register()
    {
        $voornaam = $_POST['voornaam'];
        $achternaam = $_POST['achternaam'];
        $telefoon = $_POST['telefoon'];
        $email = $_POST['email'];
        $wachtwoord = $_POST['wachtwoord'];
        $herhaalwachtwoord = $_POST['herhaalwachtwoord'];
        $this->model = new RegisterModel();
      
        // Controleer of de gebruiker al bestaat
        if ($this->model->userExists($email)) {
            echo "Gebruiker bestaat al.";
            return;
        }

        // Als de gebruiker nog niet bestaat, registreer deze dan
        $this->model->register($voornaam, $achternaam, $telefoon, $email, $wachtwoord, $gebruikersnaam, $rol);
        //echo "Gebruiker is geregistreerd.";
    }
}
