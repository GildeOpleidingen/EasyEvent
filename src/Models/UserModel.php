<?php

namespace App\Models;

class UserModel
{
    private $id;
    private $voornaam;
    private $achternaam;
    private $email;
    private $telefoon;
    private $postcode;
    private $rol;

    public function __construct(array $data)
    {
        $this->id = $data['ID'] ?? null;
        $this->voornaam = $data['Voornaam'] ?? null;
        $this->achternaam = $data['Achternaam'] ?? null;
        $this->email = $data['E-mail'] ?? null;
        $this->telefoon = $data['Telefoon'] ?? null;
        $this->postcode = $data['Postcode'] ?? null;
        $this->rol = $data['Rol'] ?? null;
    }

    public function getId() { return $this->id; }
    public function getVoornaam() { return $this->voornaam; }
    public function setVoornaam($voornaam) { $this->voornaam = $voornaam; }

    public function getAchternaam() { return $this->achternaam; }
    public function setAchternaam($achternaam) { $this->achternaam = $achternaam; }

    public function getEmail() { return $this->email; }
    public function setEmail($email) { $this->email = $email; }

    public function getTelefoon() { return $this->telefoon; }
    public function setTelefoon($telefoon) { $this->telefoon = $telefoon; }

    public function getPostcode() { return $this->postcode; }
    public function setPostcode($postcode) { $this->postcode = $postcode; }

    public function getRol() { return $this->rol; }
    public function setRol($rol) { $this->rol = $rol; }
}
