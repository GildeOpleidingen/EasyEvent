<?php

namespace App\Models;

use App; 


class LoginModel{
    
    protected $db;
    
    public function __construct()
    {
        $this->db = new \PDO('mysql:host=10.250.0.103;dbname=easyevent', 'easyevent', 'a[ez-4.wBhai48M8', [
            \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION
        ]);
    }

    public function login()
    {
        if (isset($_REQUEST['Gebruikersnaam']) && isset($_REQUEST['wachtwoord'])) {
            $gebruikersnaam = $_REQUEST['Gebruikersnaam'];
            $wachtwoord = $_REQUEST['wachtwoord'];
            if ($gebruikersnaam ===$Gebruikersnaam && $wachtwoord === $wachtwoord) {
                return 'events';
            }
        }

        return 'invalid';
    }
}