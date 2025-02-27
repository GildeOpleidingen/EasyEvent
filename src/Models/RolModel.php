<?php

namespace App\Models;

use App\Conn;
use PDO;

class RolModel extends DBModel
{
    public int $id;
    public int $gebruiker_id;
    public string $name;

    public function __construct(int $id, int $gebruiker_id, string $name)
    {
        $this->id = $id;
        $this->gebruiker_id = $gebruiker_id;
        $this->name = $name;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getID()
    {
        return $this->id;
    }
}
