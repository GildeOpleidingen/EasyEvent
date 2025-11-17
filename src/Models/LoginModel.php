<?php

namespace App\Models;

use PDO;
use PDOException;

class LoginModel extends DBModel
{

    function __construct() {
        parent::__construct();
    }

    public function login($email, $wachtwoord)
    {
        if (!empty($email) && !empty($wachtwoord)) {
            try {
                $stmt = $this->db->prepare("SELECT * FROM `gebruiker` WHERE `email` = :email");
                $stmt->bindParam(':email', $email);
                $stmt->execute();

                $gebruiker = $stmt->fetch(PDO::FETCH_ASSOC);
                if ($gebruiker) {
                    if (password_verify($wachtwoord, $gebruiker['wachtwoord'])) {
                        $_SESSION['GebruikerEmail'] = $gebruiker['email'];
                        $_SESSION['GebruikersID'] = $gebruiker['id'];
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
            $stmt->bindParam(':email', $email);
            $stmt->execute();

            return $stmt->fetchColumn() > 0;
        } catch (PDOException $e) {
            error_log("Fout bij het controleren van gebruiker: " . $e->getMessage());
            return false;
        }
    }
}
