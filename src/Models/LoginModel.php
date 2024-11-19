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

    public function login($gebruikersnaam, $wachtwoord)
    {
        if (isset($gebruikersnaam) && isset($wachtwoord)) {
            try {
                // Haal gebruiker op met de ingevoerde gebruikersnaam (email)
                $stmt = $this->db->prepare("SELECT * FROM `gebruiker` WHERE `E-mail` = :email");
                $stmt->bindParam(':email', $gebruikersnaam);
                $stmt->execute();
    
                $gebruiker = $stmt->fetch(\PDO::FETCH_ASSOC);
    
                if ($gebruiker) {
                    // Controleer het wachtwoord
                    if (password_verify($wachtwoord, $gebruiker['Wachtwoord'])) {
                        $_SESSION['Gebruikersnaam'] = $gebruikersnaam;
                        $_SESSION['GebruikersID'] = $gebruiker['ID'];
                        return 'events';
                    } else {
                        return 'invalid'; // Wachtwoord onjuist
                    }
                } else {
                    return 'invalid'; // Geen gebruiker gevonden
                }
            } catch (\PDOException $e) {
                echo "Fout bij controleren of gebruiker bestaat: " . $e->getMessage();
            }
        }
    
        return 'invalid'; // Geen gebruikersnaam of wachtwoord opgegeven
    }
    
}