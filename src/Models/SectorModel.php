<?php

namespace App\Models;

use App\Conn;
use PDO;

class SectorModel extends DBModel
{
    public int $id;
    public string $sector;

    public function construct() {}
    public function getSector() {
        return $this->sector;
    }
    public function setSector($value) {
        $this->sector = $value;
    }

    public function getId() {
        return $this->id;
    }

    public function setId($value) {
        $this->id = $value;
    }

    public static function getAllSectors() {
        $mysql = Conn::getInstance();
        $db = $mysql->getPDO();

        $sql = 'SELECT id, naam FROM sector';

        $stmt = $db->prepare($sql);

        if (!$stmt->execute()) {
            die('Query failed: ' . implode(' ', $stmt->errorInfo()));
        }

        $sectors = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $sector = new SectorModel();
            $sector->setId($row['id']);
            $sector->setSector($row['naam']);
            $sectors[] = $sector;
        }
        return $sectors;
    }

}