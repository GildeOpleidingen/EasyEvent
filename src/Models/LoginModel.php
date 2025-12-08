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
        $stmt = $this->db->prepare("SELECT * FROM `gebruiker` WHERE `email` = :email");
        $stmt->bindParam(':email', $gebruikersnaam);
        $stmt->execute();

        $gebruiker = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($gebruiker && password_verify($wachtwoord, $gebruiker['wachtwoord'])) {

            if (session_status() === PHP_SESSION_NONE) {
                session_start();
            }

            $_SESSION['Gebruikersemail'] = $gebruiker['email'];
            $_SESSION['GebruikersID'] = $gebruiker['id'];

            $stmtRol = $this->db->prepare(
                "SELECT rol_id FROM `gebruiker_rol` WHERE gebruiker_id = :gebruikerID"
            );
            $stmtRol->bindParam(':gebruikerID', $gebruiker['id']);
            $stmtRol->execute();

            $rollen = $stmtRol->fetchAll(PDO::FETCH_COLUMN);
            $_SESSION['RolID'] = $rollen;

            return 'events'; // success, redirect to events
        } else {
            return "Inlog gegevens zijn incorrect, probeer het opnieuw.";
        }
    } catch(Exception $e) {
        error_log("Fout bij inloggen: " . $e->getMessage());
        return 'Fout bij inloggen';
    }
}

public function getDb(): \PDO
{
    return $this->db;
}



    public function getUserByEmail($email)
    {
        try {
            $stmt = $this->db->prepare("SELECT * FROM `gebruiker` WHERE `email` = :email");
            $stmt = $this->db->prepare("SELECT * FROM `gebruiker` WHERE `email` = :email");
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
            $stmt = $this->db->prepare("SELECT COUNT(*) FROM `gebruiker` WHERE `email` = :email");
            $stmt = $this->db->prepare("SELECT COUNT(*) FROM `gebruiker` WHERE `email` = :email");
            $stmt->bindParam(':email', $email);
            $stmt->execute();

            return $stmt->fetchColumn() > 0;
        } catch (PDOException $e) {
            error_log("Fout bij het controleren van gebruiker: " . $e->getMessage());
            return false;
        }
    }
}
