<?php

namespace App\Models;

use App\Conn;
use PDO;

class KledingModel extends DBModel
{
    public int $id;
    public string $kledingmaat;

    public function __construct()
    {
    }

    public function getKledingmaat()
    {
        return $this->kledingmaat;
    }
    public function setKledingmaat($value)
    {
        $this->kledingmaat = $value;
    }

    public function getID()
    {
        return $this->id;
    }
    public function setId($value)
    {
        $this->id = $value;
    }

    public static function getAllKledingMaten()
    {
        $mysql = Conn::getInstance();
        $db = $mysql->getPDO();

        $sql = "SELECT ID, kledingmaat FROM kleding";

        $stmt = $db->prepare($sql);

        if (!$stmt->execute()) {
            die('Query failed: ' . implode(' ', $stmt->errorInfo()));
        }

        $kledingmaten = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $kledingmaat = new KledingModel();
            $kledingmaat->setId($row['ID']);
            $kledingmaat->setKledingmaat($row['kledingmaat']);
            $kledingmaten[] = $kledingmaat;
        }
        return $kledingmaten;
    }
}
