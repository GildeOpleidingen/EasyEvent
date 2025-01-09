<?php

namespace App\Models;

class User
{
    private $id;
    private $voornaam;
    private $achternaam;
    private $email;
    private $telefoon;
    private $instellingen;
    private $postcode;
    private $plaatsnaam;
    private $rol;
    private $wachtwoord;
    private $gebruikersnaam;
    private $profielFoto;
    private $huisnummer;
    private $isGeverifieerd;
    private $token;

    
    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function getVoornaam()
    {
        return $this->voornaam;
    }

    public function setVoornaam($voornaam)
    {
        $this->voornaam = $voornaam;
    }

    public function getAchternaam()
    {
        return $this->achternaam;
    }

    public function setAchternaam($achternaam)
    {
        $this->achternaam = $achternaam;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function setEmail($email)
    {
        $this->email = $email;
    }

    public function getTelefoon()
    {
        return $this->telefoon;
    }

    public function setTelefoon($telefoon)
    {
        $this->telefoon = $telefoon;
    }

    public function getInstellingen()
    {
        return $this->instellingen;
    }

    public function setInstellingen($instellingen)
    {
        $this->instellingen = $instellingen;
    }

    public function getPostcode()
    {
        return $this->postcode;
    }

    public function setPostcode($postcode)
    {
        $this->postcode = $postcode;
    }

    public function getPlaatsnaam()
    {
        return $this->plaatsnaam;
    }

    public function setPlaatsnaam($plaatsnaam)
    {
        $this->plaatsnaam = $plaatsnaam;
    }

    public function getRol()
    {
        return $this->rol;
    }

    public function setRol($rol)
    {
        $this->rol = $rol;
    }

    public function getWachtwoord()
    {
        return $this->wachtwoord;
    }

    public function setWachtwoord($wachtwoord)
    {
        $this->wachtwoord = $wachtwoord;
    }

    public function getGebruikersnaam()
    {
        return $this->gebruikersnaam;
    }

    public function setGebruikersnaam($gebruikersnaam)
    {
        $this->gebruikersnaam = $gebruikersnaam;
    }

    public function getProfielFoto()
    {
        return $this->profielFoto;
    }

    public function setProfielFoto($profielFoto)
    {
        $this->profielFoto = $profielFoto;
    }

    public function getHuisnummer()
    {
        return $this->huisnummer;
    }

    public function setHuisnummer($huisnummer)
    {
        $this->huisnummer = $huisnummer;
    }

    public function getIsGeverifieerd()
    {
        return $this->isGeverifieerd;
    }

    public function setIsGeverifieerd($isGeverifieerd)
    {
        $this->isGeverifieerd = $isGeverifieerd;
    }

    public function getToken()
    {
        return $this->token;
    }

    public function setToken($token)
    {
        $this->token = $token;
    }
}
