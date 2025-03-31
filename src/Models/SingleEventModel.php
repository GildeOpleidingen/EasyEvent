<?php

namespace App\Models;

use App\Conn;
use PDO;

class SingleEventModel extends DBModel
{
    public $message;
    public $gebruikerID;
    public $event;
    public $activities;
    public $organisations;
    public $active_roles;

    public function __construct()
    {

    }

    public function setMessage(string $message)
    {
        $this->message = $message;
    }

    public function setGebruikerId(int $gebruikerID){
        $this->gebruikerID = $gebruikerID;
    }

    public function setEvent(EventModel $event){
        $this->event = $event;
    }

    public function setActivities(array $activities){
        $this->activities = $activities;
    }

    public function setOrganisations(array $organisations){
        $this->organisations = $organisations;
    }

    public function setRoles(array $active_roles){
        $this->active_roles = $active_roles;
    }

    public static function getOrganisations()
    {
        $mysql = Conn::getInstance();
        $db = $mysql->getPDO();

        $sql = "SELECT * FROM `organisatie`";

        $stmt = $db->prepare($sql);

        if (!$stmt->execute()) {
            die('Query failed: ' . implode(' ', $stmt->errorInfo()));
        }

        $organisations = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $organisation = new OrganisationModel($row['ID'], $row['Organtisatie']);
            $organisations[] = $organisation;
        }

        return $organisations;
    }

    public static function getActivitiesByEventId(int $id)
    {
        $mysql = Conn::getInstance();
        $db = $mysql->getPDO();
        $sql = "SELECT kpl_activiteit_event_tijd.kpl_activiteit_event_tijd_ID,
                                    kpl_activiteit_event_tijd.event_tijd_ID,
                                    kpl_activiteit_event_tijd.BeginTijd,
                                    kpl_activiteit_event_tijd.EindTijd,
                                    `activiteit`.ID,
                                    `activiteit`.Naam,
                                    NULL as Gebruiker_ID,
                                    NULL as Organisatie_ID,
                                    NULL as Rol_ID FROM `kpl_activiteit_event_tijd`
                                    LEFT JOIN `event-tijd` ON kpl_activiteit_event_tijd.event_tijd_ID = `event-tijd`.ID
                                    LEFT JOIN `activiteit` ON kpl_activiteit_event_tijd.activiteit_ID = `activiteit`.ID
                                    WHERE`event-tijd`.Event_ID=:eventid";

        $stmt = $db->prepare($sql);

        if (!$stmt->execute(['eventid' => $id])) {
            die('Query failed: ' . implode(' ', $stmt->errorInfo()));
        }

        $activities = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $activity = new ActivityModel($row['kpl_activiteit_event_tijd_ID'], $row['ID'], $row['event_tijd_ID'],
             $row['Naam'], $row['BeginTijd'], $row['EindTijd'], null, null, null);
            $activities[] = $activity;
        }
        return $activities;
    }

    public static function getActiveActivitiesByEventIdAndUserId(int $id, int $gebruiker_id)
    {
        $mysql = Conn::getInstance();
        $db = $mysql->getPDO();
        $sql = "SELECT kpl_activiteit_event_tijd.kpl_activiteit_event_tijd_ID,
                                kpl_activiteit_event_tijd.event_tijd_ID,
                                `planning`.BeginTijd,
                                `planning`.EindTijd,
                                `activiteit`.ID,
                                `activiteit`.Naam,
                                `planning`.`Gebruiker_ID`,
                                `planning`.`Organisatie_ID`,
                                `planning`.`Rol_ID`
                                FROM `kpl_activiteit_event_tijd`
                                LEFT JOIN `event-tijd` ON kpl_activiteit_event_tijd.event_tijd_ID = `event-tijd`.ID
                                LEFT JOIN `activiteit` ON kpl_activiteit_event_tijd.activiteit_ID = `activiteit`.ID
                                RIGHT JOIN `planning` ON kpl_activiteit_event_tijd.kpl_activiteit_event_tijd_ID  = `planning`.activiteit_event_tijd_ID 
                                WHERE`event-tijd`.Event_ID=:eventid AND `planning`.Gebruiker_ID=:userid";

        $stmt = $db->prepare($sql);

        if (!$stmt->execute(['eventid' => $id, 'userid' => $gebruiker_id])) {
            die('Query failed: ' . implode(' ', $stmt->errorInfo()));
        }

        $activities = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $activity = new ActivityModel($row['kpl_activiteit_event_tijd_ID'], $row['ID'], $row['event_tijd_ID'],
             $row['Naam'], $row['BeginTijd'], $row['EindTijd'], $row['Gebruiker_ID'], $row['Organisatie_ID'], $row['Rol_ID']);
            $activities[] = $activity;
        }
        return $activities;
    }

    public static function getActivitiesByEventIdAndUserId(int $id, int $gebruiker_id)
    {
        $mysql = Conn::getInstance();
        $db = $mysql->getPDO();

        $sql = "SELECT t.kpl_activiteit_event_tijd_ID, t.event_tijd_ID, t.BeginTijd, t.EindTijd, t.ID, t.Naam, t.Gebruiker_ID, t.Organisatie_ID, t.Rol_ID
                FROM (SELECT    kpl_activiteit_event_tijd.kpl_activiteit_event_tijd_ID,
                                kpl_activiteit_event_tijd.event_tijd_ID,
                                `planning`.BeginTijd,
                                `planning`.EindTijd,
                                `activiteit`.ID,
                                `activiteit`.Naam,
                                `planning`.`Gebruiker_ID`,
                                `planning`.`Organisatie_ID`,
                                `planning`.`Rol_ID`
                                FROM `kpl_activiteit_event_tijd`
                                LEFT JOIN `event-tijd` ON kpl_activiteit_event_tijd.event_tijd_ID = `event-tijd`.ID
                                LEFT JOIN `activiteit` ON kpl_activiteit_event_tijd.activiteit_ID = `activiteit`.ID
                                RIGHT JOIN `planning` ON kpl_activiteit_event_tijd.kpl_activiteit_event_tijd_ID  = `planning`.activiteit_event_tijd_ID 
                                WHERE`event-tijd`.Event_ID=:eventid AND `planning`.Gebruiker_ID=:userid

                    UNION

                    SELECT kpl_activiteit_event_tijd.kpl_activiteit_event_tijd_ID,
                                    kpl_activiteit_event_tijd.event_tijd_ID,
                                    kpl_activiteit_event_tijd.BeginTijd,
                                    kpl_activiteit_event_tijd.EindTijd,
                                    `activiteit`.ID,
                                    `activiteit`.Naam,
                                    NULL as Gebruiker_ID,
                                    NULL as Organisatie_ID,
                                    NULL as Rol_ID
                                    FROM `kpl_activiteit_event_tijd`
                                    LEFT JOIN `event-tijd` ON kpl_activiteit_event_tijd.event_tijd_ID = `event-tijd`.ID
                                    LEFT JOIN `activiteit` ON kpl_activiteit_event_tijd.activiteit_ID = `activiteit`.ID
                                    WHERE`event-tijd`.Event_ID=:eventid

                    ) as t
                GROUP BY t.kpl_activiteit_event_tijd_ID";

        $stmt = $db->prepare($sql);

        if (!$stmt->execute(['eventid' => $id, 'userid' => $gebruiker_id])) {
            die('Query failed: ' . implode(' ', $stmt->errorInfo()));
        }

        $activities = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $activity = new ActivityModel($row['kpl_activiteit_event_tijd_ID'], $row['ID'], $row['event_tijd_ID'],
             $row['Naam'], $row['BeginTijd'], $row['EindTijd'], $row['Gebruiker_ID'], $row['Organisatie_ID'], $row['Rol_ID']);
            $activities[] = $activity;
        }
        return $activities;
    }

    public static function getEventById(int $id) {
        $mysql = Conn::getInstance();
        $db = $mysql->getPDO();
    
        $sql = "SELECT event.ID, event.Eventnaam AS eventName, 
                    event.Info AS eventInfo, 
                    `event-tijd`.Datum AS eventDate,
                    event.HoofdEvent AS hoofdEventID,
                    event.Organisator AS organisator,
                    `event-tijd`.Land AS Land,
                    `event-tijd`.Plaats AS Plaats,
                    `event-tijd`.Huisnummer AS Huisnummer,
                    `event-tijd`.Postcode AS Postcode,
                    `event-tijd`.Straatnaam AS Straatnaam,
                    `event-tijd`.Sector AS Sector,
                    event.Banner AS Banner
                FROM event 
                LEFT OUTER JOIN `event-tijd` ON event.ID=`event-tijd`.Event_ID
                ";
        $stmt = $db->prepare($sql);

        if (!$stmt->execute()) {
            die('Query failed: ' . implode(' ', $stmt->errorInfo()));
        }
    
        $events = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $event = new EventModel(
                (int)$row['organisator'],
                $row['eventName'],
                $row['eventInfo'],
                $row['Land'] ?? 'Unknown',
                $row['Plaats'] ?? 'Unknown',
                $row['Straatnaam'] ?? 'Unknown',
                $row['Huisnummer'] ?? 'Unknown',
                $row['Postcode'] ?? 'Unknown',
                $row['Sector'] ?? 'Unknown',
                [['date' => $row['eventDate'], 'startTime' => null, 'endTime' => null]], 
                $row['Banner'] ?? ''
            );
            $event->eventID = $row['ID'];
            $event->hoofdEventID = $row['hoofdEventID'];
            return $event;
        }
    }
}
