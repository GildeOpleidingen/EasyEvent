<?php

namespace App\Models;

require_once './config/conn.php';

class RegisterModel
{
    protected $db;
    
    public function __construct()
    {
        $this->db = new \PDO('mysql:host=10.250.0.103;dbname=easyevent', 'easyevent', 'a[ez-4.wBhai48M8'); 
    }
    
    public function register($Voornaam, $Achternaam, $Telefoon, $Email, $Wachtwoord)
{
    $stmt = $this->db->prepare("SELECT * FROM `Gebruiker` WHERE Email = :email");
    $stmt->bindParam(':email', $Email);
    $stmt->execute();
    
    $existingUserCount = $stmt->rowCount();
    
    if ($existingUserCount > 0) {
        return $existingUserCount;
    } else {
        $stmt = $this->db->prepare("INSERT INTO `Gebruiker` (Voornaam, Achternaam, Telefoon, Email, Wachtwoord) 
                                          VALUES (:voornaam, :achternaam, :telefoon, :email, :wachtwoord)");
        $insertStmt->bindParam(':voornaam', $Voornaam);
        $insertStmt->bindParam(':achternaam', $Achternaam);
        $insertStmt->bindParam(':telefoon', $Telefoon);
        $insertStmt->bindParam(':email', $Email);
        $insertStmt->bindParam(':wachtwoord', $Wachtwoord);
        $insertStmt->execute();
        
        return 0;
    }
}

}
?>