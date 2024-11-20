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

        if (empty($voornaam) || empty($achternaam) || empty($email) || empty($wachtwoord)|| empty($telefoon)|| empty($herhaalWachtwoord)) {
            $this->render('register', ['error' => 'Alle velden zijn verplicht.']);
            return;
        }
        
        $this->model = new RegisterModel();
      
        // Controleer of de gebruiker al bestaat
        if ($this->model->userExists($email)) {
            $this->render('register', ['error' => 'gebruiker bestaat al']);
            return;
        }
        
        if (trim($wachtwoord) === trim($herhaalWachtwoord)) {
            $this->model->register($voornaam, $achternaam, $telefoon, $email, $wachtwoord, $gebruikersnaam, $rol);
            $this->render('register', ['succes' => 'Gebruiker is geregistreerd.']);
        } else {
            $this->render('register', ['error' => 'Gebruikersnaam en wachtwoord komen niet overeen.']);
            return;
        }
  
    }
}
