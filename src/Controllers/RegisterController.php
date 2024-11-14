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
        $gebruikersnaam = $_POST['gebruikersnaam'];
        $rol = $_POST['rol'];
        $herhaalWachtwoord = $_POST['herhaalWachtwoord'];
        $this->model = new RegisterModel();
      
        // Controleer of de gebruiker al bestaat
        if ($this->model->userExists($email)) {
            echo "Gebruiker bestaat al.";
            return;
        }

        if (trim($wachtwoord) === trim($herhaalWachtwoord)) {
            $this->model->register($voornaam, $achternaam, $telefoon, $email, $wachtwoord, $gebruikersnaam, $rol);
            echo "gebruiiker is geregistreerd";
        } else {
            echo "Wachtwoorden komen niet overeen";
            return;
        }
        


        
    }
}
