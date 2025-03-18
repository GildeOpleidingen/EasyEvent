<?php

namespace App\Models;

use App\Conn;
use PDO;

class UserModel
{
    private $id;
    private $voornaam;
    private $achternaam;
    private $email;
    private $telefoon;
    private $postcode;
    private $roles;
    private $plaatsnaam;
    private $huisnummer;

    public function __construct(array $data)
    {
        $this->id = $data['ID'] ?? null;
        $this->voornaam = $data['Voornaam'] ?? null;
        $this->achternaam = $data['Achternaam'] ?? null;
        $this->email = $data['E-mail'] ?? null;
        $this->telefoon = $data['Telefoon'] ?? null;
        $this->postcode = $data['Postcode'] ?? null;
        $this->roles = isset($data['ID']) ? RolModel::getRolesByUserId($data['ID']) : [];
        $this->plaatsnaam = $data['Plaatsnaam'] ?? null;
        $this->huisnummer = $data['Huisnummer'] ?? null;
    }

        public function getId()
    {
        return $this->id;
    }

    public static function getById($id)
    {
        $db = Conn::getPDO();
        $stmt = $db->prepare("SELECT * FROM gebruiker WHERE Id = ?");
        $stmt->execute([$id]);
        $userData = $stmt->fetch(PDO::FETCH_ASSOC);

        return $userData ? new self($userData) : null;
    }

    public function updateTelefoon($newPhone)
    {
        $db = Conn::getPDO();
        $stmt = $db->prepare("UPDATE gebruiker SET Telefoon = ? WHERE Id = ?");
        $stmt->execute([$newPhone, $this->id]);
        $this->telefoon = $newPhone;
    }

    public function updateAdresGegevens($newPostCode, $newCity, $newHouseNumber)
    {
        $db = Conn::getPDO();

        $query = "UPDATE gebruiker SET ";

        $updateVelden = [];

        if (!empty($newPostCode)) {
            $updateVelden[] = "Postcode = :postcode";
        }

        if (!empty($newCity)) {
            $updateVelden[] = "Plaatsnaam = :plaatsnaam";
        }

        if (!empty($newHouseNumber)) {
            $updateVelden[] = "Huisnummer = :huisnummer";
        }

        $query .= implode(', ', $updateVelden);
        $query .= " WHERE Id = :id"; 
        $stmt = $db->prepare($query);

        if (!empty($newPostCode)) {
            $stmt->bindParam(':postcode', $newPostCode);
        }
        if (!empty($newCity)) {
            $stmt->bindParam(':plaatsnaam', $newCity);
        }
        if (!empty($newHouseNumber)) {
            $stmt->bindParam(':huisnummer', $newHouseNumber);
        }

        $stmt->bindParam(':id', $this->id);
        $stmt->execute();

        $this->postcode = $newPostCode;
        $this->plaatsnaam = $newCity;
        $this->huisnummer = $newHouseNumber;
    }

}
