<?php

namespace App\Models;

use App;
use Dotenv\Dotenv;
use PDO;
use PDOException;


class DBModel
{
    protected $db;
    
    public function __construct()
    {
        $dotenv = Dotenv::createImmutable(__DIR__ . '/../../', '.env');
        $dotenv->load();

        $host = $_ENV['DB_HOST'];
        $dbname = $_ENV['DB_NAME'];
        $username = $_ENV['DB_USER'];
        $password = $_ENV['DB_PASS'];

        try{
            $this->db = new PDO("mysql:host=$host;dbname=$dbname", $username, $password, [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
            ]);
        } catch (PDOException $ex){
            echo $ex->getMessage();
        }
    }
}
?>
