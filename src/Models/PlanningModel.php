<?php

namespace App\Models;

use App\Conn;
use PDO;

class PlanningModel extends DBModel
{
    public int $gebruiker_id;
    public int $activiteit_eventtijd_id;
    public string $beginTijd;
    public string $eindTijd;
    public int $organisatieId;
    public float $gewerkteUren;

    public bool $betaalt = false;

    public bool $isGoedGekeurd = false;

    public function __construct(int $gebruiker_id, int $activiteit_eventtijd_id, string $beginTijd, string $eindTijd,
     int $organisatieId)
    {
        $this->gebruiker_id = $gebruiker_id;
        $this->activiteit_eventtijd_id = $activiteit_eventtijd_id;
        $this->beginTijd = $beginTijd;
        $this->eindTijd = $eindTijd;
        $this->organisatieId = $organisatieId;
    }

    public static function sendPlanning(PlanningModel $planning)
    {
        $mysql = Conn::getInstance();
        $db = $mysql->getPDO();
    
        // SQL to insert event data into the `event` table, now including `hoofdEvent`
        $sqlEvent = "INSERT INTO planning (Gebruiker_ID, activiteit_event_tijd_ID, BeginTijd, EindTijd, Organisatie_ID)
         VALUES (:gebruiker_id, :activiteit_eventtijd_id, :beginTijd, :eindTijd, :organisatie_ID)";

        // Prepare and execute the query for the `event` table
        $stmtEvent = $db->prepare($sqlEvent);
        $stmtEvent->bindParam(':gebruiker_id', $planning->gebruiker_id);
        $stmtEvent->bindParam(':activiteit_eventtijd_id', $planning->activiteit_eventtijd_id);
        $stmtEvent->bindParam(':beginTijd', $planning->beginTijd);
        $stmtEvent->bindParam(':eindTijd', $planning->eindTijd);
        $stmtEvent->bindParam(':organisatie_ID', $planning->organisatieId);

        if ($stmtEvent->execute()) {
            return "Successfully added planning!";
        }
        return "Insertion into `planning` table failed!";
    }
}
