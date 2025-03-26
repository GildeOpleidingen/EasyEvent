<?php

namespace App\Controllers;

use App\Controller;
use App\Models\EventsModel;
use App\Models\EventModel;
use App\Models\UsersModel;

class BeheerEventAanmakenController extends Controller {
    public function index() {
        $this->render("beheer/event-aanmaken");
    }
    public function sendEvent(){
        $eventName = $_POST['eventNaam'] ?? null;
        $eventInfo = $_POST['info'] ?? null;
        $eventOrganizer = $_SESSION['GebruikersID'] ?? null;
        // Check if eventOrganizer is set and is an integer
        if (!isset($eventOrganizer) || !is_int($eventOrganizer)) {
            $this->render('beheer/home', ['error' => 'Organisator is niet geldig.']);
            return;
        }
        $Land = $_POST['Land'] ?? null;
        $Plaats = $_POST['Plaats'] ?? null;
        $Straatnaam = $_POST['Straatnaam'] ?? null;
        $Huisnummer = $_POST['Huisnummer'] ?? null;
        $Postcode = $_POST['Postcode'] ?? null;
        $Sector = $_POST['Sector'] ?? '';
        $eventBanner = $_POST['banner'] ?? null;
        $hoofdEvent = $_POST['hoofdEvent'] ?? null;
        $eventID = $_POST['eventID'] ?? null;
        $date = $_POST['datum'] ?? null;
        $startTime = $_POST['begin-tijd'] ?? null;
        $endTime = $_POST['eind-tijd'] ?? null;

        // Controleer of alle velden ingevuld zijn
        if (empty($eventName) || empty($eventInfo) || empty($eventBanner)|| empty($date) || empty($startTime)|| empty($endTime)) {
            var_dump($eventName);
            var_dump($eventInfo);
            var_dump($eventBanner);
            var_dump($startTime);
            var_dump($_POST);
            var_dump($endTime);
            die(); 
            $this->render('beheer/home', ['error' => 'Alle velden zijn verplicht.']);
            return;
        }

        $eventModel = new EventModel( $eventOrganizer, $eventName, $eventInfo, $Land, $Plaats, $Straatnaam,$Huisnummer, $Postcode, $Sector, ['date' => $date[0], 'BeginTijd' => $startTime[0], 'EindTijd' => $endTime[0]], $eventBanner);
        $errors = $eventModel->validateModel();
        // Sla de gegevens tijdelijk op in de sessie
        $_SESSION['register_data'] = [
            'GebruikersID' => $_SESSION['GebruikersID'],
            'eventNaam' => $eventName,
            'info' => $eventInfo,
            'land' => $Land,
            'plaats' => $Plaats,
            'straatNaam' => $Straatnaam,
            'huisNummer' => $Huisnummer,
            'postcode' => $Postcode,
            'sector' => $Sector,
            'organisator' => $eventOrganizer,
            'banner' => $eventBanner,
            'hoofdEvent' => $hoofdEvent,
            'eventID' => $eventID,
            'date' => $date,
            'startTime' => $startTime,
            'endTime' => $endTime
        ];
       // var_dump($eventModel->event);
        $result = $eventModel->sendEvent($eventModel);

        if ($result) {
            $this->render('beheer/event-aanmaken-stap-2', ['success' => 'Evenement succesvol aangemaakt!']);
        } else {
            $this->render('beheer/event-aanmaken-stap-2', ['error' => 'Er is een fout opgetreden bij het aanmaken van het evenement.']);
        }

    } 
}
