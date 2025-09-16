<?php

namespace App\Models;

use PDO;
use PDOException;

class DBModel
{
    protected $db;
    
    public function __construct()
    {
$host = $_ENV['DB_HOST'] ?? 'db';
$dbname = $_ENV['DB_NAME'] ?? 'easyevent';
$username = $_ENV['DB_USER'] ?? 'Admin';
$password = $_ENV['DB_PASS'] ?? 'Admin';


        try {
            $this->db = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password, [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
            ]);
        } catch (PDOException $ex) {
            echo "Database connection failed: " . $ex->getMessage();
        }
    }
}
