<?php

namespace App\Controllers;

use App\Controller;
use App\Models\EventsModel;
use App\Models\EventModel;
use App\Models\UsersModel;
use App\Models\SectorModel;

class BeheerEventAanmakenController extends Controller {
    public function index() {
        $allSectors = SectorModel::getAllSectors();
        $this->render("beheer/event-aanmaken", [
            'allSectors' => $allSectors
        ]);
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
        $Sector = $_POST['Sector'] ?? [];
        // $eventBanner = base64_encode($_POST['banner'] ?? null);
        $hoofdEvent = $_POST['hoofdEvent'] ?? null;
        $eventID = $_POST['eventID'] ?? null;


        $dates = $_POST['datum'] ?? [];
        $startTimes = $_POST['begin-tijd'] ?? [];
        $endTimes = $_POST['eind-tijd'] ?? [];

        $hasAtLeastOneTime = !empty($dates) && !empty($startTimes) && !empty($endTimes);

        // Controleer of alle velden ingevuld zijn
        if ($eventName == '' || $eventInfo == '' || !$hasAtLeastOneTime) {
            $this->render('beheer/home', ['error' => 'Alle velden zijn verplicht.']);
            return;
        }

        $eventModel = new EventModel(
            $eventOrganizer, 
            $eventName, 
            $eventInfo, 
            $Land, 
            $Plaats, 
            $Straatnaam, 
            $Huisnummer, 
            $Postcode, 
            $Sector, 
            []
        );

        $rows = max(count($dates), count($startTimes), count($endTimes));
        for ($i = 0; $i < $rows; $i++) {
            $d = $dates[$i] ?? null;
            $b = $startTimes[$i] ?? null;
            $e = $endTimes[$i] ?? null;

            if (!$d || !$b || !$e) {
                continue;
            }

            $eventModel->addEventTime([
                'date'      => $d,
                'BeginTijd' => $b,
                'EindTijd'  => $e,
            ]);
}
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
}
