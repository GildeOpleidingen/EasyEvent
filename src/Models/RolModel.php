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

        $sql = "SELECT id, Rol FROM rol";

        $stmt = $db->prepare($sql);

        if (!$stmt->execute()) {
            die('Query failed: ' . implode(' ', $stmt->errorInfo()));
        }

        $roles = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $role = new RolModel();
            $role->setid($row['id']);
            $role->setName($row['rol']);
            $roles[] = $role;
        }
        return $roles;
    }

    public static function getRoleIDByName($roleName)
    {
        $mysql = Conn::getInstance();
        $db = $mysql->getPDO();

        $sql = "SELECT id FROM rol WHERE rol = :rolName";

        $stmt = $db->prepare($sql);
        
        if (!$stmt->execute(['rolName' => $roleName])) {
            die('Query failed: ' . implode(' ', $stmt->errorInfo()));
        }

        $rolID = null;
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $rolID = $row['id'];
        }
        return $rolID;
    }

    public static function getRolesByUserId($id)
    {
        $mysql = Conn::getInstance();
        $db = $mysql->getPDO();

        $sql = "SELECT `rol_id`, `Rol` FROM `gebruiker_rol` LEFT JOIN `rol` ON gebruiker_rol.rol_id = `rol`.ID WHERE `gebruiker_id` = :gebruikerID";

        $stmt = $db->prepare($sql);

        if (!$stmt->execute(['gebruikerID' => $id])) {
            die('Query failed: ' . implode(' ', $stmt->errorInfo()));
        }

        $roles = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $role = new RolModel();
            $role->setid($row['rol_id']);
            $role->setName($row['Rol']);
            $roles[] = $role;
        }
        return $roles;
    }
}
