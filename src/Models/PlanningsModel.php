<?php

namespace App\Models;

use App\Conn;
use PDO;

class PlanningsModel extends DBModel
{
    public int $gebruiker_id;
    public int $rol_id;
    public array $planningModels = [];
    public array $defaultActivities = [];
    public array $oldActivities = [];
    public int $organisatieId;
    public float $gewerkteUren;

    public bool $betaalt = false;

    public bool $isGoedGekeurd = false;

    public function __construct(int $gebruiker_id, int $rol_id, array $plannedModels, int $organisatieId, array $defaultActivities, array $oldActivities)
    {
        $this->gebruiker_id = $gebruiker_id;
        $this->rol_id = $rol_id;
        $this->defaultActivities = $defaultActivities;
        $this->oldActivities = $oldActivities;
        foreach($plannedModels as $plannedModel) {
            if (isset($plannedModel['checked']))
            {
                $this->planningModels[] = new PlanningModel($plannedModel['checked'], $plannedModel['startTime'], $plannedModel['endTime']);
            }
        }
        $this->organisatieId = $organisatieId;
    }

    public static function removeOldPlannedModels(array $oldActivities)
    {
        $idsToDelete = [];
        foreach ($oldActivities as $activity)
        {
            $idsToDelete[] = $activity->getPlannedID();
        }
        if (empty($idsToDelete))
        {
            return true;
        }
        $mysql = Conn::getInstance();
        $db = $mysql->getPDO();
        $placeholders = implode(',', array_fill(0, count($idsToDelete), '?'));
        $sql = "DELETE FROM planning WHERE id IN ($placeholders)";
        $stmt = $db->prepare($sql);
        if ($stmt->execute($idsToDelete)) {
            return "Successfully removed planning!";
        }
        return "removed from `planning` table failed!";
    }

    public function validate()
    {
        // remove all $oldActivities
        $this->removeOldPlannedModels($this->oldActivities);

        // Get al Roles
        $roles = RolModel::getRolesByUserId($this->gebruiker_id);

        // Valideer de rollen
        $activeRoles = [];
        foreach($roles as $role)
        {
            if ($role->getID() == $this->rol_id)
            {
                $activeRoles[] = true;
            }
        }
        // There are no roles selected.
        if (!in_array("true", $activeRoles))
        {
            return false;
        }

        foreach($this->defaultActivities as $default)
        {
            foreach($this->planningModels as $plannedModel)
            {
                if ($plannedModel->getID() == $default->getID())
                {
                    // Als de ingeplande starttijd voor het geplande starttijd is.
                    // Als de ingeplande starttijd voorbij het geplande eindtijd is.
                    if ($plannedModel->getBeginTijd() < $default->getBeginTijd() || $plannedModel->getBeginTijd() > $default->getEindTijd())
                    {
                        return false;
                    }
                    // Als de ingeplande eindtijd na de geplande eindtijd is.
                    // Als de ingeplande eindtijd voor de geplande start tijd is.
                    if ($plannedModel->getEindTijd() > $default->getEindTijd() || $plannedModel->getEindTijd() < $default->getBeginTijd())
                    {
                        return false;
                    }
                }
            }
        }


        return true;
    }

    public static function sendPlanning(PlanningsModel $planning)
    {
        if (empty($planning->planningModels)){
            return true;
        }
        $mysql = Conn::getInstance();
        $pdo = $mysql->getPDO();
        $sql = "INSERT INTO planning (Gebruiker_ID, activiteit_event_tijd_id, BeginTijd, EindTijd, Organisatie_ID, Rol_ID) VALUES ";

        $placeholders = [];
        $params = [];
        foreach ($planning->planningModels as $index => $planningModel) {
            // For each row, add a set of placeholders and parameters
            $placeholders[] = "(:gebruiker_id{$index}, :activiteit_eventtijd_id{$index}, :beginTijd{$index}, :eindTijd{$index}, :organisatie_ID{$index}, :rol_ID{$index})";

            // Bind the parameters dynamically
            $params[":gebruiker_id{$index}"] = $planning->gebruiker_id;
            $params[":activiteit_eventtijd_id{$index}"] = $planningModel->activiteit_event_tijd_id;
            $params[":beginTijd{$index}"] = $planningModel->beginTijd;
            $params[":eindTijd{$index}"] = $planningModel->eindTijd;
            $params[":organisatie_ID{$index}"] = $planning->organisatieId;
            $params[":rol_ID{$index}"] = $planning->rol_id;
        }
        $sql .= implode(", ", $placeholders);
        $stmt = $pdo->prepare($sql);
        if ($stmt->execute($params)) {
            return "Successfully added planning!";
        }
        return "Insertion into `planning` table failed!";
    }
}
