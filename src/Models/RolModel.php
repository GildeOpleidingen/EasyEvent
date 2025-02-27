<?php

namespace App\Models;

use App\Conn;
use PDO;

class RolModel extends DBModel
{
    public int $id;
    public int $gebruiker_id;
    public string $name;

    public function __construct(int $id, string $name)
    {
        $this->id = $id;
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

    public static function getAllRoles()
    {
        $mysql = Conn::getInstance();
        $db = $mysql->getPDO();

        $sql = "SELECT ID, Rol FROM Rol";

        $stmt = $db->prepare($sql);

        if (!$stmt->execute()) {
            die('Query failed: ' . implode(' ', $stmt->errorInfo()));
        }

        $roles = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $role = new RolModel($row['rol_ID'],  $row['Rol']);
            $roles[] = $role;
        }
        return $roles;
    }

    public static function getRoleIDByName($roleName)
    {
        $mysql = Conn::getInstance();
        $db = $mysql->getPDO();

        $sql = "SELECT ID FROM rol WHERE Rol = :rolName";

        $stmt = $db->prepare($sql);
        
        if (!$stmt->execute(['rolName' => $roleName])) {
            die('Query failed: ' . implode(' ', $stmt->errorInfo()));
        }

        $rolID = null;
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $rolID = $row['ID'];
        }
        return $rolID;
    }

    public static function getRolesByUserId($id)
    {
        $mysql = Conn::getInstance();
        $db = $mysql->getPDO();

        $sql = "SELECT `rol_ID` FROM `kpl_gebruiker_rol` WHERE `gebruiker_ID` = :gebruikerID";

        $stmt = $db->prepare($sql);

        if (!$stmt->execute(['gebruikerID' => $id])) {
            die('Query failed: ' . implode(' ', $stmt->errorInfo()));
        }

        $roleIDs = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $roleIDs[] = $row['rol_ID'];
        }
        return $roleIDs;
    }
}
