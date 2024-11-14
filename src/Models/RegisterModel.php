<?php

namespace App\Models;

use App;

class RegisterModel
{
    protected $db;
    
    public function __construct()
    {
        $this->db = new \PDO('mysql:host=10.250.0.103;dbname=easyevent', 'easyevent', 'a[ez-4.wBhai48M8', [
            \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION
        ]);
    }

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
    public function register($voornaam, $achternaam, $telefoon, $email, $wachtwoord)
    {
        try {
            
            $hashedPassword = password_hash($wachtwoord, PASSWORD_DEFAULT);

            //bereid de query
            $stmt = $this->db->prepare("INSERT INTO `gebruiker` (Voornaam, Achternaam, Telefoon, `E-mail`, Wachtwoord, Gebruikersnaam, Rol) 
                                        VALUES (:voornaam, :achternaam, :telefoon, :email, :wachtwoord, :gebruikersnaam, :rol)");
            
            $rol = "gebruiker";

            $stmt->bindParam(':voornaam', $voornaam);
            $stmt->bindParam(':achternaam', $achternaam);
            $stmt->bindParam(':telefoon', $telefoon);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':wachtwoord', $hashedPassword);
            $stmt->bindParam(':gebruikersnaam', $email);
            $stmt->bindParam('rol', $rol);

            $stmt->execute();
        } catch (\PDOException $e) {
            echo "Fout bij registratie: " . $e->getMessage();
        }
    }
}
