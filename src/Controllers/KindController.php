<?php
namespace App\Controllers;

use App\Controller;
use App\Models\KindModel;

class KindController extends Controller
{

    public function index()
    {
        if (session_status() == PHP_SESSION_NONE) session_start();

        $user = unserialize($_SESSION['gebruiker']);
        $user_id = $user->getId();

        if ($user_id == null) {
            $this->redirect('/login');
            exit();
        }

        $kindModel = new KindModel();
        $gebruiker = $kindModel->getOuder($user_id);

        $this->render("add-child", ["gebruiker" => $gebruiker]);
    }

    public function saveChild() {
        if (session_status() === PHP_SESSION_NONE) session_start();
        $user = unserialize($_SESSION['gebruiker']);
        $ouderId = $user->getId();
  
        if (!$ouderId) {
            $this->redirect('/login');
            exit();
        }

        if (empty($_POST['voornaam']) ||
            empty($_POST['achternaam']) ||
            empty($_POST['postcode']) ||
            empty($_POST['plaatsnaam']) ||
            empty($_POST['huisnummer'])) {

            $kindModel = new KindModel();
            $gebruiker = $kindModel->getOuder($ouderId);

            $this->render('add-child', [
                'error' => 'Vul alle verplichte velden in.',
                'gebruiker' => $gebruiker
            ]);
            return;
        }

        $kindModel = new KindModel();

        $result = $kindModel->voegKindToe($ouderId, [
            'voornaam'   => $_POST['voornaam'],
            'achternaam' => $_POST['achternaam'],
            'postcode'   => $_POST['postcode'],
            'plaatsnaam' => $_POST['plaatsnaam'],
            'huisnummer' => $_POST['huisnummer']
        ]);

        $gebruiker = $kindModel->getOuder($ouderId);

        if ($result) {
            $this->render('add-child', [
                'success' => 'Kind succesvol aangemaakt!',
                'childAdded' => true,
                'gebruiker' => $gebruiker
            ]);
        } else {
            $this->render('add-child', [
                'error' => 'Er is een fout opgetreden bij het opslaan in de database.',
                'gebruiker' => $gebruiker
            ]);
        }
    }
}
