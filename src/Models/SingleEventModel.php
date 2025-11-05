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

        $sql = "SELECT * FROM vereniging";

        $stmt = $db->prepare($sql);

        if (!$stmt->execute()) {
            die('Query failed: ' . implode(' ', $stmt->errorInfo()));
        }

        $organisations = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $organisation = new OrganisationModel($row['id'], $row['naam']);
            $organisations[] = $organisation;
        }

        return $organisations;
    }

    public static function getActivitiesByEventId(int $id)
    {
        $mysql = Conn::getInstance();
        $db = $mysql->getPDO();
        $sql = "SELECT aet.id as aet_ID,
                       aet.event_tijd_id,
                       aet.begin_tijd,
                       aet.eind_tijd,
                       a.id as Activiteit_ID,
                       a.naam,
                       a.locatie,
                       NULL as Gebruiker_ID,
                       NULL as Organisatie_ID,
                       NULL as Rol_ID
                       FROM `activiteit_event_tijd` aet
                       LEFT JOIN `event_tijd` et ON aet.event_tijd_id = et.id
                       LEFT JOIN `activiteit` a ON aet.activiteit_id = a.id
                       WHERE et.event_id = :eventid";

        $stmt = $db->prepare($sql);

        if (!$stmt->execute(['eventid' => $id])) {
            die('Query failed: ' . implode(' ', $stmt->errorInfo()));
        }

        $activities = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $activity = new ActivityModel();
            $activity->setActiviteitEventTijdId($row['aet_ID']);
            $activity->setActiviteitId($row['Activiteit_ID']);
            $activity->setEventTijdId($row['event_tijd_id']);
            $activity->setNaam($row['naam']);
            $activity->setBeginTijd($row['BeginTijd']);
            $activity->setEindTijd($row['EindTijd']);
            // $activity->setMaximumVrijwilligers($row['VrijwilligerAantal']);
            // $activity->setMaximumBegeleiders($row['BegeleiderAantal']);
            $activities[] = $activity;
        }
        return $activities;
    }

    public static function getPlanningByEventIdAndUserId(int $id, int $gebruiker_id)
    {
        $mysql = Conn::getInstance();
        $db = $mysql->getPDO();
        $sql = "SELECT aet.id as aet_ID,
                aet.event_tijd_id as et_ID,
                -- aet.VrijwilligerAantal,
                -- aet.BegeleiderAantal,
                p.begin_tijd,
                p.eind_tijd,
                a.id as Activiteit_ID,
                a.Naam,
                p.id as Planning_ID,
                p.gebruiker_id,
                p.vereniging_id,
                p.rol_id as Rol_ID
                FROM activiteit_event_tijd aet
                LEFT JOIN event_tijd et ON aet.event_tijd_id = et.id
                LEFT JOIN activiteit a ON aet.activiteit_ID = a.id
                RIGHT JOIN planning p ON aet.activiteit_event_tijd_id = p.activiteit_event_tijd_id 
                WHERE et.event_id = :eventid AND p.gebruiker_id = :userid";

        $stmt = $db->prepare($sql);

        if (!$stmt->execute(['eventid' => $id, 'userid' => $gebruiker_id])) {
            die('Query failed: ' . implode(' ', $stmt->errorInfo()));
        }

        $activities = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $activity = new ActivityModel();
            $activity->setActiviteitEventTijdId($row['aet_id']);
            $activity->setActiviteitId($row['Activiteit_ID']);
            $activity->setEventTijdId($row['et_id']);
            $activity->setNaam($row['naam']);
            $activity->setBeginTijd($row['begin_tijd']);
            $activity->setEindTijd($row['EindTijd']);
            // $activity->setMaximumVrijwilligers($row['VrijwilligerAantal']);
            // $activity->setMaximumBegeleiders($row['BegeleiderAantal']);
            $activity->setGebruikerID($row['gebruiker_id']);
            $activity->setOrganisationID($row['vereniging_id']);
            $activity->setRolID($row['Rol_ID']);
            $activity->setPlannedID($row['Planning_ID']);
            $activities[] = $activity;
        }
        return $activities;
    }

    public static function getActivitiesByEventIdAndUserId(int $id, int $gebruiker_id)
    {
        $mysql = Conn::getInstance();
        $db = $mysql->getPDO();

        $sql = "SELECT aet.id AS aet_id,
                       aet.event_tijd_id AS aet_et_id,
                       p.id AS planning_id,
                       aet.begin_tijd,
                       aet.eind_tijd,
                       a.id AS activiteit_id,
                       a.naam,
                       p.gebruiker_id,
                       p.vereniging_id,
                       p.rol_id
                FROM activiteit_event_tijd as aet
                JOIN event_tijd AS et ON aet.event_tijd_id = et.id
                JOIN activiteit AS a ON aet.activiteit_id = a.id
                LEFT JOIN planning as p ON p.activiteit_event_tijd_id = aet.id AND p.gebruiker_id = :userid
                WHERE et.event_id = :eventid
        "

        $sql = "SELECT t.aet_ID, t.event_tijd_id, t.id, t.begin_tijd, t.eind_tijd, t.activiteit_id, t.naam, t.gebruiker_id, t.vereniging_id, t.rol_id
                FROM (SELECT    aet.id as aet_ID,
                                aet.event_tijd_id,
                                p.id as Planning_ID,
                                p.begin_tijd,
                                p.eind_tijd,
                                -- aet.VrijwilligerAantal,
                                -- aet.BegeleiderAantal,
                                a.id as Activiteit_ID,
                                a.naam,
                                p.gebruiker_id,
                                p.vereniging_id,
                                p.rol_id
                                FROM activiteit_event_tijd aet
                                LEFT JOIN event_tijd et ON aet.event_tijd_id = et.id
                                LEFT JOIN activiteit a ON aet.activiteit_id = a.id
                                RIGHT JOIN planning p ON aet.activiteit_event_tijd_id  = p.activiteit_event_tijd_id
                                WHERE et.event_id = :eventid AND p.gebruiker_id = :userid

                    UNION

                    SELECT aet.activiteit_event_tijd_id,
                                    aet.event_tijd_id,
                                    null as ID,
                                    aet.begin_tijd,
                                    aet.eind_tijd,
                                    -- aet.VrijwilligerAantal,
                                    -- aet.BegeleiderAantal,
                                    a.id as Activiteit_ID,
                                    a.naam,
                                    NULL as Gebruiker_ID,
                                    NULL as Organisatie_ID,
                                    NULL as Rol_ID
                                    FROM `activiteit_event_tijd` aet
                                    LEFT JOIN `event-tijd` et ON aet.event_tijd_id = et.id
                                    LEFT JOIN `activiteit` a ON aet.activiteit_id = a.id
                                    WHERE et.event_id = :eventid

                    ) as t
                 GROUP BY t.activiteit_event_tijd_id, t.event_tijd_id, t.id, t.begin_tijd, t.eind_tijd, t.activiteit_id, t.naam, t.gebruiker_id, t.organisatie_id, t.rol_id";

        $stmt = $db->prepare($sql);

        if (!$stmt->execute(['eventid' => $id, 'userid' => $gebruiker_id])) {
            die('Query failed: ' . implode(' ', $stmt->errorInfo()));
        }

        $activities = [];
        $plannedActivities = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $activity = new ActivityModel();
            $activity->setActiviteitEventTijdId($row['activiteit_event_tijd_ID']);
            $activity->setActiviteitId($row['ActiviteitID']);
            $activity->setEventTijdId($row['event_tijd_ID']);
            $activity->setNaam($row['Naam']);
            $activity->setBeginTijd($row['BeginTijd']);
            $activity->setEindTijd($row['EindTijd']);
            $activity->setMaximumVrijwilligers($row['VrijwilligerAantal']);
            $activity->setMaximumBegeleiders($row['BegeleiderAantal']);
            $activity->setGebruikerID($row['Gebruiker_ID']);
            $activity->setOrganisationID($row['Organisatie_ID']);
            $activity->setRolID($row['Rol_ID']);
            $activity->setPlannedID($row['ID']);
            if ($activity->getPlannedID() !== null) {
                $plannedActivities[] = $activity;
            }
            $activities[] = $activity;
        }

        foreach ($plannedActivities as $pActivity) {
            foreach ($activities as $key => $activity) {
                if ($activity->getPlannedID() == null && $activity->getActivityID() === $pActivity->getActivityID()
                    && $activity->getID() === $pActivity->getID()
                    && $activity->getEventTijdID() === $pActivity->getEventTijdID()) {
                    unset($activities[$key]);
                }
            }
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
