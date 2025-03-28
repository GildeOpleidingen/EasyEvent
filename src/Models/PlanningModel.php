<?php

namespace App\Models;

use App\Conn;
use PDO;

class PlanningModel extends DBModel
{
    public ActivityModel $activity;
    public UserModel $user;

    public EventModel $event;

    public int $activiteit_event_tijd_id;
    public string $beginTijd;
    public string $eindTijd;
    public string $betaalt;
    public string $isGoedGekeurd;

    public function __construct()
    {
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

    public function setActiviteitEventTijdId(int $activiteit_event_tijd_id): void
    {
        $this->activiteit_event_tijd_id = $activiteit_event_tijd_id;
    }

    public function setBeginTijd(string $beginTijd): void
    {
        $this->beginTijd = $beginTijd;
    }

    public function setEindTijd(string $eindTijd): void
    {
        $this->eindTijd = $eindTijd;
    }

    public function getActivity(): ActivityModel
    {
        return $this->activity;
    }

    public function setActivity(ActivityModel $activity): void
    {
        $this->activity = $activity;
    }

    public function getUser(): UserModel
    {
        return $this->user;
    }

    public function setUser(UserModel $user): void
    {
        $this->user = $user;
    }

    public function getEvent(): EventModel
    {
        return $this->event;
    }

    public function setEvent(EventModel $event): void
    {
        $this->event = $event;
    }

    public function getBetaalt(): string
    {
        return $this->betaalt;
    }

    public function setBetaalt(string $betaalt): void
    {
        $this->betaalt = $betaalt;
    }

    public function getIsGoedGekeurd(): string
    {
        return $this->isGoedGekeurd;
    }

    public function setIsGoedGekeurd(string $isGoedGekeurd): void
    {
        $this->isGoedGekeurd = $isGoedGekeurd;
    }
}
