<?php

namespace App\Models;

use App\Conn;
use PDO;

class RolModel extends DBModel
{
    public int $id;
    public string $name;

    public function __construct()
    {
    }

    public function getName()
    {
        return $this->name;
    }

    public function setName($value)
    {
        $this->name = $value;
    }

    public function getID()
    {
        return $this->id;
    }

    public function setId($value)
    {
        $this->id = $value;
    }
    
    public static function getAllRoles()
    {
        $mysql = Conn::getInstance();
        $db = $mysql->getPDO();

        $sql = "SELECT ID, Rol FROM rol";

        $stmt = $db->prepare($sql);

        if (!$stmt->execute()) {
            die('Query failed: ' . implode(' ', $stmt->errorInfo()));
        }

        $roles = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $role = new RolModel();
            $role->setid($row['ID']);
            $role->setName($row['Rol']);
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

        $sql = "SELECT `rol_ID`, `Rol` FROM `kpl_gebruiker_rol` LEFT JOIN `rol` ON kpl_gebruiker_rol.rol_ID = `rol`.ID WHERE `gebruiker_ID` = :gebruikerID";

        $stmt = $db->prepare($sql);

        if (!$stmt->execute(['gebruikerID' => $id])) {
            die('Query failed: ' . implode(' ', $stmt->errorInfo()));
        }

        $roles = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $role = new RolModel();
            $role->setid($row['rol_ID']);
            $role->setName($row['Rol']);
            $roles[] = $role;
        }
        return $roles;
    }
}
