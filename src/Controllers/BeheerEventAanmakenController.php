<?php

namespace App\Controllers;

use App\Controller;
use App\Models\EventsModel;
use App\Models\EventModel;
use App\Models\UsersModel;
use App\Models\SectorModel;

class BeheerEventAanmakenController extends Controller {
    public function index() {
        $this->render("beheer/event-aanmaken");
    }

    public function step2() {
        $this->render("beheer/event-aanmaken-stap-2");
    }

    public function sendEvent(){
        $eventOrganizer = $_SESSION['GebruikersID'] ?? null;
        // Check if eventOrganizer is set and is an integer
        if (!isset($eventOrganizer) || !ctype_digit((string)$eventOrganizer)) {
            $this->render('beheer/home', ['error' => 'Organisator is niet geldig.']);
            return;
        }
        $eventOrganizer = (int)$eventOrganizer;
        $eventName = $_POST['eventNaam'] ?? null;
        $eventInfo = $_POST['info'] ?? null;
        $Land = $_POST['Land'] ?? null;
        $Plaats = $_POST['Plaats'] ?? null;
        $Straatnaam = $_POST['Straatnaam'] ?? null;
        $Huisnummer = $_POST['Huisnummer'] ?? null;
        $Postcode = $_POST['Postcode'] ?? null;
        $Sector = $_POST['Sector'] ?? '';
        $eventBanner = base64_encode($_POST['banner'] ?? null);
        $hoofdEvent = $_POST['hoofdEvent'] ?? null;
        $eventID = $_POST['eventID'] ?? null;


        $dates = $_POST['datum'] ?? [];
        $startTimes = $_POST['begin-tijd'] ?? [];
        $endTimes = $_POST['eind-tijd'] ?? [];

        $hasAtLeastOneTime = !empty($dates) && !empty($startTimes) && !empty($endTimes);

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
            'hoofdEvent' => $hoofdEvent,
            'eventID' => $eventID,
            'date' => $dates,
            'startTime' => $startTimes,
            'endTime' => $endTimes
        ];

        $result = $eventModel->sendEvent($eventModel);

        if ($result) {
            // Debugging statement to confirm redirection
            error_log("Redirecting to event aanmaken stap 2");
            $this->render('beheer/event-aanmaken-stap-2', ['success' => 'Evenement succesvol aangemaakt!']);
            return; // Ensure to return after rendering
        } else {
            $this->render('beheer/event-aanmaken-stap-2', ['error' => 'Er is een fout opgetreden bij het aanmaken van het evenement.']);
        }

    } 

    public function sendEventStep2()
    {
        $this->redirection('beheer/event');
    }

    public function editEvent() {

        $this->render("beheer/event-aanmaken");
    }
}
