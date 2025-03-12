<?php

namespace App\Models;

use App\Conn;
use PDO;

class ActivityModel extends DBModel
{
    public int $activiteit_id;
    public int $event_tijd_id;
    public int $activiteit_event_tijd_id;
    public ?int $gebruikerID;
    public ?int $organisationID;
    public string $name;
    public string $beginTijd;
    public string $eindTijd;

    public function __construct(int $activiteit_event_tijd_id, int $activiteit_id, int $event_tijd_id,
     string $name, string $beginTijd, string $eindTijd, ?int $gebruikerID, ?int $organisationID)
    {
        $this->activiteit_id = $activiteit_id;
        $this->event_tijd_id = $event_tijd_id;
        $this->gebruikerID = $gebruikerID;
        $this->organisationID = $organisationID;
        $this->activiteit_event_tijd_id = $activiteit_event_tijd_id;
        $this->name = $name;
        $this->beginTijd = $beginTijd;
        $this->eindTijd = $eindTijd;
    }

    public function hasUser()
    {
        return !is_null($this->gebruikerID);
    }

    public function getName()
    {
        return $this->name;
    }

    public function getOrganisationID()
    {
        return $this->organisationID;
    }

    public function getActivityID()
    {
        return $this->activiteit_id;
    }

    public function getID()
    {
        return $this->activiteit_event_tijd_id;
    }

    public function getBeginTijd()
    {
        return $this->beginTijd;
    }

    public function getEindTijd()
    {
        return $this->eindTijd;
    }
}
