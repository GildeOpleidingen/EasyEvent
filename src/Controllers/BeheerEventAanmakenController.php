<?php

namespace App\Controllers;

use App\Controller;

class BeheerEventAanmakenController extends Controller {
    public function index() {
        $this->render("beheer/event-aanmaken");
    }

    
    public function sendEvent(){
        $eventName = trim($_POST['eventNaam']);
        $eventInfo = trim($_POST['info']);
        $eventOrganizer = trim($_POST['organisator']);
        $banner = trim($_POST['banner']);
        $hoofdEvent = trim($_POST['hoofdEvent']);
        $eventID = trim($_POST['eventID']);
        $date = trim($_POST['date']);
        $startTime = trim($_POST['startTime']);
        $endTime = trim($_POST['endTime']);

        // Controleer of alle velden ingevuld zijn
        if (empty($eventName) || empty($eventInfo) || empty($eventOrganizer) || empty($banner) || empty($hoofdEvent) || empty($eventID) || empty($date) || empty($startTime) || empty($endTime)) {
            $this->render('event', ['error' => 'Alle velden zijn verplicht.']);
            return;
        }

        // Sla de gegevens tijdelijk op in de sessie
        // voeg gebruiker toe
        $_SESSION['register_data'] = [
            'gebrui'
            'eventNaam' => $eventName,
            'info' => $eventInfo,
            'organisator' => $eventOrganizer,
            'banner' => $banner,
            'hoofdEvent' => $hoofdEvent,
            'eventID' => $eventID,
            'date' => $date,
            'startTime' => $startTime,
            'endTime' => $endTime
        ];
        //Roep de `sendEvent`-functie aan
        $eventModel = new EventsModel();

        // $vul het eventmodel
        // Valideer het eventmodel
        // verstuur naar database
        // stuur naar de volgende stap met een redirect
        $result = $eventModel->sendEvent(
            $eventName,
            $eventInfo,
            $eventOrganizer,
            $banner,
            $hoofdEvent,
            $eventID,
            $date,
            $startTime,
            $endTime
        );

        if ($result) {
            $this->render('event-aanmaken-stap-2', ['success' => 'Evenement succesvol aangemaakt!']);
        } else {
            $this->render('event-aanmaken', ['error' => 'Er is een fout opgetreden bij het aanmaken van het evenement.']);
        }

    } 
}