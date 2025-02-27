<?php

namespace App\Models;

use App\Conn;
use PDO;

class ActivityModel extends DBModel
{
    public int $id;
    public string $name;
    public string $beginTijd;
    public string $eindTijd;

    public function __construct(int $id, string $name, string $beginTijd, string $eindTijd)
    {
        $this->id = $id;
        $this->name = $name;
        $this->beginTijd = $beginTijd;
        $this->eindTijd = $eindTijd;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getID()
    {
        return $this->id;
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
