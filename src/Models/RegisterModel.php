<?php

namespace App\Models;

use App;

class RegisterModel extends DBModel
{
    

    //controleert of de gebruiker al bestaat
    public function userExists($email)
    {
        try {
            $stmt = $this->db->prepare("SELECT * FROM `gebruiker` WHERE `E-mail` = :email");
            $stmt->bindParam(':email', $email);
            $stmt->execute();
            
            return $stmt->rowCount() > 0;
        } catch (\PDOException $e) {
            echo "fout bij controleren of gebruiker bestaat: " . $e->getMessage();
        }
    }

    //registreren gebruiker in de db
    public function register($voornaam, $achternaam, $telefoon, $email, $wachtwoord, $verif)
    {
        try {
            
            $hashedPassword = password_hash($wachtwoord, PASSWORD_DEFAULT);

            //bereid de query
            $stmt = $this->db->prepare("INSERT INTO `gebruiker` (Voornaam, Achternaam, Telefoon, `E-mail`, Wachtwoord, Gebruikersnaam, Rol, is_geverifieerd) 
                                        VALUES (:voornaam, :achternaam, :telefoon, :email, :wachtwoord, :gebruikersnaam, :rol, :is_geverifieerd)");
            
            $rol = 1;
            $is_geverifieerd = 1;

            $stmt->bindParam(':voornaam', $voornaam);
            $stmt->bindParam(':achternaam', $achternaam);
            $stmt->bindParam(':telefoon', $telefoon);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':wachtwoord', $hashedPassword);
            $stmt->bindParam(':gebruikersnaam', $email);
            $stmt->bindParam('rol', $rol);
            $stmt->bindparam('is_geverifieerd', $is_geverifieerd);

            $stmt->execute();
        } catch (\PDOException $e) {
            echo "Fout bij registratie: " . $e->getMessage();
        }
    }
}
