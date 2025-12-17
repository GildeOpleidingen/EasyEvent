<?php

namespace App\Models;

use App\Conn;
use PDO;

class ActivityModel extends DBModel
{
    public int $activiteit_id;
    public int $event_tijd_id;
    public int $activiteit_event_tijd_id;
    public int $maximum_vrijwilligers;
    public int $maximum_begeleiders;
    public ?int $plannedID;
    public ?int $gebruikerID;
    public ?int $organisationID;
    public ?int $rolID;
    public string $locatie;
    public string $naam;
    public string $beginTijd;
    public string $eindTijd;

    public function __construct($naam, $beginTijd, $eindTijd, $aantalPersonen)
    {
        $this->naam = $naam;
        $this->beginTijd = $beginTijd;
        $this->eindTijd = $eindTijd;
        $this->maximum_vrijwilligers = $aantalPersonen;
    }

    public function hasUser() { return isset($this->gebruikerID) && !is_null($this->gebruikerID); }
    public function hasRole() { return isset($this->rolID) && !is_null($this->rolID); }
    public function hasOrganisation() { return isset($this->organisationID) && !is_null($this->organisationID); }
    public function getName() { return $this->naam; }
    public function getOrganisationID() { return $this->organisationID; }
    public function getRolID() { return $this->rolID; }
    public function getLocatie() { return $this->locatie; }
    public function getActivityID() { return $this->activiteit_id; }
    public function getID() { return $this->activiteit_event_tijd_id; }
    public function getEventTijdID() { return $this->event_tijd_id; }
    public function getBeginTijd() { return $this->beginTijd; }
    public function getEindTijd() { return $this->eindTijd; }
    public function getPlannedID() { return $this->plannedID; }

    public function setActiviteitId(int $activiteit_id): void { $this->activiteit_id = $activiteit_id; }
    public function setEventTijdId(int $event_tijd_id): void { $this->event_tijd_id = $event_tijd_id; }
    public function setActiviteitEventTijdId(int $activiteit_event_tijd_id): void { $this->activiteit_event_tijd_id = $activiteit_event_tijd_id; }
    public function setMaximumVrijwilligers(int $maximum_vrijwilligers): void { $this->maximum_vrijwilligers[] = $maximum_vrijwilligers; }
    public function setMaximumBegeleiders(int $maximum_begeleiders): void { $this->maximum_begeleiders = $maximum_begeleiders; }
    public function setPlannedID(?int $plannedID): void { $this->plannedID = $plannedID; }
    public function setGebruikerID(?int $gebruikerID): void { $this->gebruikerID = $gebruikerID; }
    public function setOrganisationID(?int $organisationID): void { $this->organisationID = $organisationID; }
    public function setRolID(?int $rolID): void { $this->rolID = $rolID; }
    public function setLocatie(string $locatie): void { $this->locatie = $locatie; }
    public function setNaam($naam): void { $this->naam = $naam; }
    public function setBeginTijd($beginTijd): void { $this->beginTijd = $beginTijd; }
    public function setEindTijd($eindTijd): void { $this->eindTijd = $eindTijd; }

    public static function sendActivity(ActivityModel $activity)
    {
        $eventID = $_GET['eventId'];
        

        $mysql = Conn::getInstance();
        $db = $mysql->getPDO();

        // get event_tijd_id
        $sqlET = "SELECT id FROM `event_tijd` WHERE event_id = :eventID";
        $stmtET = $db->prepare($sqlET);
        $stmtET->bindParam(':eventID', $eventID);
        $stmtET->execute();
        $activity->event_tijd_id = $stmtET->fetchColumn();

        
            $sqlActivity = "INSERT INTO activiteit (naam) VALUES (:activityName)";

            $stmtActivity = $db->prepare($sqlActivity);
            $stmtActivity->bindParam(':activityName', $activity->naam);

            if ($stmtActivity->execute()) {
                $activity->activiteit_id = $db->lastInsertId();

                $sqlActivityTime = "INSERT INTO `activiteit_event_tijd`
                                    (activiteit_id, event_tijd_id, begin_tijd, eind_tijd, aantal_personen)
                                    VALUES (:ActivityID, :EventTijdID, :BeginTijd, :EindTijd, :AantalPersonen)";
                
                $stmtActivityTime = $db->prepare($sqlActivityTime);

                $stmtActivityTime->bindParam(':ActivityID', $activity->activiteit_id);
                $stmtActivityTime->bindParam(':EventTijdID', $activity->event_tijd_id);
                $stmtActivityTime->bindParam(':BeginTijd', $activity->beginTijd);
                $stmtActivityTime->bindParam(':EindTijd', $activity->eindTijd);
                $stmtActivityTime->bindParam(':AantalPersonen', $activity->maximum_vrijwilligers);

                if (!$stmtActivityTime->execute()) {
                    return "Something went wrong please try again!";
                }
            }


    }
        

    public static function getActiviteitByID(int $activiteitId): array {
        $mysql = Conn::getInstance();
        $pdo = $mysql->getPDO();
        $sql = "SELECT  a.naam,
                        a.id,
                        aet.begin_tijd,
                        aet.eind_tijd
                FROM activiteit a
                LEFT JOIN activiteit_event_tijd aet on aet.activiteit_id = a.id
                WHERE a.id = :activiteitid
                ORDER BY a.naam
        ";

        $stmt = $pdo->prepare($sql);
        
        if (!$stmt->execute(['activiteitid' => $activiteitId])) {
            die('Query failed: ' . implode(' ', $stmt->errorInfo()));
        }

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public static function getActiviteitenByEventId(int $eventId): array 
    {
        $mysql = Conn::getInstance();
        $pdo = $mysql->getPDO();
        $sql = "SELECT a.naam           as activiteitNaam,
                       a.id             as activiteitID,
                       aet.begin_tijd   as activiteitBeginTijd,
                       aet.eind_tijd    as activiteitEindTijd
                FROM `activiteit_event_tijd` aet
                JOIN `event_tijd` et on et.id = aet.event_tijd_id
                JOIN activiteit a on a.id = aet.activiteit_id
                JOIN `event` e on e.id = et.event_id
                WHERE e.id = :eventid
                ORDER by a.naam
                ";

        $stmt = $pdo->prepare($sql);

        if (!$stmt->execute(['eventid' => $eventId])) {
            die('Query failed: ' . implode(' ', $stmt->errorInfo()));
        }

        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
