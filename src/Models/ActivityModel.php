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
    public string $naam;
    public string $beginTijd;
    public string $eindTijd;

    public function __construct(int $activiteit_event_tijd_id, int $activiteit_id, int $event_tijd_id,
     string $naam, string $beginTijd, string $eindTijd, int $maximum_vrijwilligers, int $maximum_begeleiders,
     ?int $plannedID, ?int $gebruikerID, ?int $organisationID, ?int $rolID)
    {
        $this->activiteit_id = $activiteit_id;
        $this->event_tijd_id = $event_tijd_id;
        $this->plannedID = $plannedID;
        $this->gebruikerID = $gebruikerID;
        $this->organisationID = $organisationID;
        $this->rolID = $rolID;
        $this->activiteit_event_tijd_id = $activiteit_event_tijd_id;
        $this->maximum_vrijwilligers = $maximum_vrijwilligers;
        $this->maximum_begeleiders = $maximum_begeleiders;
        $this->naam = $naam;
        $this->beginTijd = $beginTijd;
        $this->eindTijd = $eindTijd;
    }

    public function hasUser()
    {
        return isset($this->gebruikerID) && !is_null($this->gebruikerID);
    }

    public function hasRole()
    {
        return isset($this->rolID) && !is_null($this->rolID);
    }

    public function hasOrganisation()
    {
        return isset($this->organisationID) && !is_null($this->organisationID);
    }

    public function getName()
    {
        return $this->naam;
    }

    public function getOrganisationID()
    {
        return $this->organisationID;
    }

    public function getRolID()
    {
        return $this->rolID;
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
