<?php
namespace App\Controllers;

use App\Models\UserModel;
use App\Controller;

class ProfielController extends Controller
{
    public function index()
    {
        if (!isset($_SESSION['gebruiker'])) {
            return $this->render('login', ['error' => 'Je moet ingelogd zijn om je profiel te bekijken.']);
        }


        $gebruiker = unserialize($_SESSION['gebruiker']);


        $gebruiker = UserModel::getById($gebruiker->getId());

        // var_dump($gebruiker);
        if (!$gebruiker) {
            return $this->render('login', ['error' => 'Gebruiker niet gevonden. Log opnieuw in.']);
        }

        return $this->render('profiel', ['gebruiker' => $gebruiker]);
    }

    public function updateTelefoon()
    {
        if (!isset($_SESSION['gebruiker']) || empty($_POST['newPhone'])) {
            return $this->render('profiel', ['error' => 'Ongeldige invoer']);
        }

        $gebruiker = unserialize($_SESSION['gebruiker']);
        $gebruiker->updateTelefoon(trim($_POST['newPhone']));

        return $this->render('profiel', [
            'gebruiker' => $gebruiker,
            'success' => 'Telefoonnummer bijgewerkt'
        ]);
    }

    public function updateAdresGegevens()
    {
        if (!isset($_SESSION['gebruiker'])) {
            return $this->render('profiel', ['error' => 'Je moet ingelogd zijn om je adresgegevens te wijzigen.']);
        }

        $gebruiker = unserialize($_SESSION['gebruiker']);
        
        $newPostCode = trim($_POST['newPostCode']) ?: null;
        $newCity = trim($_POST['newCity']) ?: null;
        $newHouseNumber = trim($_POST['newHouseNumber']) ?: null;

        $gebruiker->updateAdresGegevens($newPostCode, $newCity, $newHouseNumber);

        return $this->render('profiel', [
            'gebruiker' => $gebruiker,
            'success' => 'Adresgegevens succesvol bijgewerkt'
        ]);
    }

    public function updateWachtwoord()
    {
        if (!isset($_SESSION['gebruiker'])) {
            return $this->render('profiel', ['error' => 'Je moet ingelogd zijn om je wachtwoord te wijzigen.']);
        }

        $gebruiker = unserialize($_SESSION['gebruiker']);

        try {
            $message = $gebruiker->updateWachtwoord($_POST['currentPassword'], $_POST['newPassword'], $_POST['confirmPassword']);
            return $this->render('profiel', ['gebruiker' => $gebruiker, 'success' => $message]);
        } catch (Exception $e) {
            return $this->render('profiel', ['error' => 'wachtwoord komt niet overeen']);
        }
    }

    public function addChildForm() {
        if (!isset($_SESSION['gebruiker'])) {
            return $this->render('login', ['error' => 'Je moet ingelogd zijn om een kind toe te voegen.']);
        }

        $gebruiker = unserialize($_SESSION['gebruiker']);
        $gebruiker = UserModel::getById($gebruiker->getId());

        return $this->render('add-child', ['gebruiker' => $gebruiker]);    }

    public function addChild()
    {
        if (!isset($_SESSION['gebruiker'])) {
            return $this->render('login', ['error' => 'Je moet ingelogd zijn om een kind toe te voegen.']);
        }

        if (empty($_POST['voornaam']) || empty($_POST['achternaam']) || empty($_POST['geboortedatum'])) {
            return $this->render('add-child', ['error' => 'Alle velden zijn verplicht.']);
        }


        return $this->render('add-child', ['success' => 'Kind succesvol toegevoegd!']);
    }


}
