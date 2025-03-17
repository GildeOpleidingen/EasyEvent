<?php

namespace App\Models;

use App\Conn;
use PDO;

class PlanningsModel extends DBModel
{
    public int $gebruiker_id;
    public int $rol_id;
    public array $planningModels = [];
    public int $organisatieId;
    public float $gewerkteUren;

    public bool $betaalt = false;

    public bool $isGoedGekeurd = false;

    public function __construct(int $gebruiker_id, int $rol_id, array $plannedModels, int $organisatieId)
    {
        $this->gebruiker_id = $gebruiker_id;
        $this->rol_id = $rol_id;
        foreach($plannedModels as $plannedModel) {
            if (isset($plannedModel['checked']))
            {
                $this->planningModels[] = new PlanningModel($plannedModel['checked'], $plannedModel['startTime'], $plannedModel['endTime']);
            }
        }
        $this->organisatieId = $organisatieId;
    }

    public function validate()
    {
        // TODO validate Vrijwilliger aantal of Begeleider Aantal
        return true;
    }

    public static function sendPlanning(PlanningsModel $planning)
    {
        $mysql = Conn::getInstance();
        $db = $mysql->getPDO();
    
        foreach($planning->planningModels as $planningModel) {
            // SQL to insert event data into the `event` table, now including `hoofdEvent`
            $sqlEvent = "INSERT INTO planning (Gebruiker_ID, activiteit_event_tijd_id, BeginTijd, EindTijd, Organisatie_ID)
            VALUES (:gebruiker_id, :activiteit_eventtijd_id, :beginTijd, :eindTijd, :organisatie_ID)";

            // Prepare and execute the query for the `event` table
            $stmtEvent = $db->prepare($sqlEvent);
            $stmtEvent->bindParam(':gebruiker_id', $planning->gebruiker_id);
            $stmtEvent->bindParam(':activiteit_eventtijd_id', $planningModel->activiteit_event_tijd_id);
            $stmtEvent->bindParam(':beginTijd', $planningModel->beginTijd);
            $stmtEvent->bindParam(':eindTijd', $planningModel->eindTijd);
            $stmtEvent->bindParam(':organisatie_ID', $planning->organisatieId);

            if (!$stmtEvent->execute()) {
                return "Insertion into `planning` table failed!";
            }
        }

        if ($stmtEvent->execute()) {
            return "Successfully added planning!";
        }
        return "Insertion into `planning` table failed!";
    }
}
