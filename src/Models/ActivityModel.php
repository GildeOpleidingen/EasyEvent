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

    public function __construct()
    {
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

    public function getEventTijdID()
    {
        return $this->event_tijd_id;
    }

    public function getBeginTijd()
    {
        return $this->beginTijd;
    }

    public function getEindTijd()
    {
        return $this->eindTijd;
    }

    public function getPlannedID()
    {
        return $this->plannedID;
    }

    public function setActiviteitId(int $activiteit_id): void
    {
        $this->activiteit_id = $activiteit_id;
    }

    public function setEventTijdId(int $event_tijd_id): void
    {
        $this->event_tijd_id = $event_tijd_id;
    }

    public function setActiviteitEventTijdId(int $activiteit_event_tijd_id): void
    {
        $this->activiteit_event_tijd_id = $activiteit_event_tijd_id;
    }

    public function setMaximumVrijwilligers(int $maximum_vrijwilligers): void
    {
        $this->maximum_vrijwilligers = $maximum_vrijwilligers;
    }

    public function setMaximumBegeleiders(int $maximum_begeleiders): void
    {
        $this->maximum_begeleiders = $maximum_begeleiders;
    }

    public function setPlannedID(?int $plannedID): void
    {
        $this->plannedID = $plannedID;
    }

    public function setGebruikerID(?int $gebruikerID): void
    {
        $this->gebruikerID = $gebruikerID;
    }

    public function setOrganisationID(?int $organisationID): void
    {
        $this->organisationID = $organisationID;
    }

    public function setRolID(?int $rolID): void
    {
        $this->rolID = $rolID;
    }

    public function setNaam(string $naam): void
    {
        $this->naam = $naam;
    }

    public function setBeginTijd(string $beginTijd): void
    {
        $this->beginTijd = $beginTijd;
    }

    public function setEindTijd(string $eindTijd): void
    {
        $this->eindTijd = $eindTijd;
    }
}
