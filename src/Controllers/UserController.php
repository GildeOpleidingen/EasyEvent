<?php

namespace App\Controllers;

use App\Controller;
use App\Models\UserModel;

class UserController extends Controller {
    public function index(): void {
        $usermodel = new UserModel();
        $this->render("beheer/user-overzicht", (array)$usermodel);
    }

    public function add(): void {
        $usermodel = new UserModel();
        $this->render("beheer/user-aanmaken", (array)$usermodel);
    }


    public function saveUser(){
        $um = new UserModel();
        $um->setVoornaam($_POST['voorNaam']);
        $um->setAchternaam($_POST['achterNaam']);
        $um->setEmail($_POST['email']);
        $um->setTelefoon($_POST['telefoon']);
        $um->setPostcode($_POST['postcode'] ?? null);
        $um->setHuisnummer($_POST['huisnummer'] ?? null);
     
        $um->setPlaatsnaam($_POST['plaatsnaam'] ?? null);
        $um->setWachtwoord($_POST['wachtwoord']);
        $um->setGebruikersnaam($_POST['gebruikersNaam']);
        $um->setRoles($_POST['rol'] ?? []);
        $um->setKledingmaat($_POST['kledingmaat'] ?? null);
        $um->setProfielfoto($_POST['profielfoto'] ?? null);

        $result = $um->save($um);

        if ($result) {
            $this->render('beheer/user-overzicht', ['success' => 'Gebruiker succesvol aangemaakt!']);
        } else {
            $this->render('beheer/user-overzicht', ['error' => 'Er is een fout opgetreden bij het aanmaken van de gebruiker.']);
        }
    } 

    public function delete(){
        if (!isset($_GET['userID'])) {
            $this->redirect('/beheer/user-overzicht');
            exit();
        }
        if (!isset($_SESSION['gebruiker']))
        {
            $this->redirect('/login');
            exit();
        }
        $id = intval($_GET['userID']);
        $user = new UserModel();
        $user->delete($id);
        $this->redirect('/beheer/user-overzicht');
    }
}