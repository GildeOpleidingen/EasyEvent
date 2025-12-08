<?php

namespace App\Models;

use App;

class RegisterModel extends DBModel
{
    

    //controleert of de gebruiker al bestaat
    public function userExists($email)
    {
        try {
            $stmt = $this->db->prepare("SELECT * FROM `gebruiker` WHERE `email` = :email");
            $stmt->bindParam(':email', $email);
            $stmt->execute();
            
            return $stmt->rowCount() > 0;
        } catch (\PDOException $e) {
            echo "fout bij controleren of gebruiker bestaat: " . $e->getMessage();
        }
    }

    
    //registreren gebruiker in de db
    public function register($voornaam, $achternaam, $telefoon, $email, $wachtwoord, $verif = 1)
    {
        try {
            
            $hashedPassword = password_hash($wachtwoord, PASSWORD_DEFAULT);

            //bereid de query
            $stmt = $this->db->prepare("INSERT INTO `gebruiker` (voornaam, achternaam, telefoon, email, wachtwoord, geverifieerd) 
                                        VALUES (:voornaam, :achternaam, :telefoon, :email, :wachtwoord, :is_geverifieerd)");

            $stmt->bindParam(':voornaam', $voornaam);
            $stmt->bindParam(':achternaam', $achternaam);
            $stmt->bindParam(':telefoon', $telefoon);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':wachtwoord', $hashedPassword);
            $stmt->bindparam(':is_geverifieerd', $verif);

            if($stmt->execute())
            {
                $last_id = $this->db->lastInsertId();

                //Koppel de gebruiker rol aan deze nieuwe gebruiker.
                $rol = RolModel::getRoleIDByName('Gebruiker');
                $stmt = $this->db->prepare("INSERT INTO `gebruiker_rol`(`gebruiker_id`, `rol_id`) VALUES (:gebruikerId, :rolId)");
                $stmt->bindParam('gebruikerId', $last_id);
                $stmt->bindParam('rolId', $rol);
                $stmt->execute();
            }
        } catch (\PDOException $e) {
            echo "Fout bij registratie: " . $e->getMessage();
        }
    }
}
