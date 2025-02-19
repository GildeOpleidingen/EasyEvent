<?php

namespace App\Controllers;

use App\Controller;
use App\Models\EventsModel;
use App\Models\UsersModel;

class BeheerEventAanmakenController extends Controller {
    public function index() {
        $this->render("beheer/event-aanmaken");
    }
    public function sendEvent(){
        $eventName = $_POST['eventNaam'] ?? null;
        $eventInfo = $_POST['info'] ?? null;
        $eventOrganizer = $_POST['organisater'] ?? null;
        $eventBanner = $_POST['banner'] ?? null;
        $hoofdEvent = $_POST['hoofdEvent'] ?? null;
        $eventID = $_POST['eventID'] ?? null;
        $eventDate = $_POST['Land'] ?? null;
        $eventTime = $_POST['Plaats'] ?? null;
        $eventLocation = $_POST['Straatnaam'] ?? null;
        $eventPrice = $_POST['Huisnummer'] ?? null;
        $eventCapacity = $_POST['Postcode'] ?? null;
        $date = $_POST['datum'] ?? null;
        $startTime = $_POST['begin-tijd'] ?? null;
        $endTime = $_POST['eind-tijd'] ?? null;
        $eventSector = $_POST['Sector'] ?? null;

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

        $eventModel = new EventsModel($eventName, $eventInfo, $_SESSION['GebruikersID'], $eventBanner,  ['date' => $date[0], 'BeginTijd' => $startTime[0], 'EindTijd' => $endTime[0]]);
        $errors = $eventModel->validateModel();
        // Sla de gegevens tijdelijk op in de sessie
        $_SESSION['register_data'] = [
            'GebruikersID' => $_SESSION['GebruikersID'],
            'eventNaam' => $eventName,
            'info' => $eventInfo,
            'organisater' => $eventOrganizer,
            'banner' => $eventBanner,
            'hoofdEvent' => $hoofdEvent,
            'eventID' => $eventID,
            'date' => $date,
            'startTime' => $startTime,
            'endTime' => $endTime
        ];

        $result = $eventModel->sendEvent($eventModel);

        if ($result) {
            $this->render('beheer/event-aanmaken-stap-2', ['success' => 'Evenement succesvol aangemaakt!']);
        } else {
            $this->render('beheer/event-aanmaken-stap-2', ['error' => 'Er is een fout opgetreden bij het aanmaken van het evenement.']);
        }

    } 
}