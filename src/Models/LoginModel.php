<?php

namespace App\Models;

use PDO;
use PDOException;
require_once __DIR__ . '/../../functions/rate_limiting.php';
class LoginModel extends DBModel
{

    function __construct() {
        parent::__construct();
    }

public function login($gebruikersnaam, $wachtwoord): string
{
    if (empty($gebruikersnaam) || empty($wachtwoord)) {
        return "Vul zowel e-mail als wachtwoord in.";
    }

    // client ip mail
    $ip = $_SERVER['REMOTE_ADDR'] ?? 'unknown';
    $email = strtolower($gebruikersnaam);

    // rate limit
    checkRateLimit($this->db, $ip, $email, 5, 300, "Te veel pogingen. Probeer het over 5 minuten opnieuw.");


    try {
        $stmt = $this->db->prepare("SELECT * FROM `gebruiker` WHERE `E-mail` = :email");
        $stmt->bindParam(':email', $gebruikersnaam);
        $stmt->execute();

        $gebruiker = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($gebruiker && password_verify($wachtwoord, $gebruiker['Wachtwoord'])) {

            if (session_status() === PHP_SESSION_NONE) {
                session_start();
            }

            $stmt = $this->db->prepare("SELECT * FROM `event` WHERE `Organisator` = :userID");
            $stmt->bindParam(':userID', $gebruiker['ID']);
            $stmt->execute();
            
            $gebruikerModel = new UserModel();
            $gebruikerModel->setUserData($gebruiker);
            $_SESSION['gebruiker'] = serialize($gebruikerModel);
            $_SESSION['Gebruikersnaam'] = $gebruiker['E-mail'];
            $_SESSION['GebruikersID'] = $gebruiker['ID'];

            $stmtRol = $this->db->prepare(
                "SELECT rol_ID FROM `kpl_gebruiker_rol` WHERE gebruiker_ID = :gebruikerID"
            );
            $stmtRol->bindParam(':gebruikerID', $gebruiker['ID']);
            $stmtRol->execute();

            $rollen = $stmtRol->fetchAll(PDO::FETCH_COLUMN);
            $_SESSION['RolID'] = $rollen;

            return 'events'; // success, redirect to events
        } else {
            return "Inlog gegevens zijn incorrect, probeer het opnieuw.";
        }
    } catch (PDOException $e) {
        error_log("Fout bij inloggen: " . $e->getMessage());
        return "Er is een fout opgetreden. Probeer het later opnieuw.";
    }
}
                $gebruiker = $stmt->fetch(PDO::FETCH_ASSOC);
                if ($gebruiker) {
                    if (password_verify($wachtwoord, $gebruiker['Wachtwoord'])) {
                        $stmt = $this->db->prepare("SELECT * FROM `event` WHERE `Organisator` = :userID");
                        $stmt->bindParam(':userID', $gebruiker['ID']);
                        $stmt->execute();

                        $gebruikerModel = new UserModel();
                        $gebruikerModel->setUserData($gebruiker);
                        $_SESSION['gebruiker'] = serialize($gebruikerModel);
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


public function getDb(): \PDO
{
    return $this->db;
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
