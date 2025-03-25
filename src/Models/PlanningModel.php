<?php

namespace App\Models;

use App\Conn;
use PDO;

class PlanningModel extends DBModel
{
    public int $activiteit_event_tijd_id;
    public string $beginTijd;
    public string $eindTijd;

    public function __construct(int $activiteit_event_tijd_id, string $beginTijd, string $eindTijd)
    {
        $this->activiteit_event_tijd_id = $activiteit_event_tijd_id;
        $this->beginTijd = $beginTijd;
        $this->eindTijd = $eindTijd;
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
