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


    }


}

?>