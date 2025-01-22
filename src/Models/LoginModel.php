<?php

namespace App\Models;

use PDO;
use PDOException;

class LoginModel
{
    protected $db;

    public function __construct()
    {
        try {
            $this->db = new PDO('mysql:host=10.250.0.103;dbname=easyevent;charset=utf8mb4', 'easyevent', 'a[ez-4.wBhai48M8', [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
            ]);
        } catch (PDOException $e) {
            error_log("Database Connection Error: " . $e->getMessage());
            die("Er is een fout opgetreden. Probeer het later opnieuw.");
        }
    }

    public function login($gebruikersnaam, $wachtwoord)
    {
        if (!empty($gebruikersnaam) && !empty($wachtwoord)) {
            try {
                $stmt = $this->db->prepare("SELECT * FROM `gebruiker` WHERE `E-mail` = :email");
                $stmt->bindParam(':email', $gebruikersnaam);
                $stmt->execute();

                $gebruiker = $stmt->fetch(PDO::FETCH_ASSOC);

                if ($gebruiker) {
                    if (password_verify($wachtwoord, $gebruiker['Wachtwoord'])) {
                        $_SESSION['Gebruikersnaam'] = $gebruiker['E-mail'];
                        $_SESSION['GebruikersID'] = $gebruiker['ID'];
                        return 'events';
                    } else {
                        return 'invalid'; 
                    }
                } else {
                    return 'invalid'; 
                }
            } catch (PDOException $e) {
                error_log("Fout bij inloggen: " . $e->getMessage());
                return 'invalid';
            }
        }

        return 'invalid'; 
    }

    public function getUserByEmail($email)
    {
        try {
            $stmt = $this->db->prepare("SELECT * FROM `gebruiker` WHERE `E-mail` = :email");
            $stmt->bindParam(':email', $email);
            $stmt->execute();

            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Fout bij het ophalen van gebruiker: " . $e->getMessage());
            return false;
        }
    }

    public function userExists($email)
    {
        try {
            $stmt = $this->db->prepare("SELECT COUNT(*) FROM `gebruiker` WHERE `E-mail` = :email");
            $stmt->bindParam(':email', $email);
            $stmt->execute();

            return $stmt->fetchColumn() > 0;
        } catch (PDOException $e) {
            error_log("Fout bij het controleren van gebruiker: " . $e->getMessage());
            return false;
        }
    }
}
