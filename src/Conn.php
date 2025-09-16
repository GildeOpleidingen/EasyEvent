<?php

namespace App
{
    use PDO;
    use PDOException;

    class Conn
    {
        private static ?Conn $instance = null;
        private ?PDO $pdo = null;

        
        private function __construct(){
$host = $_ENV['DB_HOST'] ?? 'db';
$dbname = $_ENV['DB_NAME'] ?? 'easyevent';
$username = $_ENV['DB_USER'] ?? 'Admin';
$password = $_ENV['DB_PASS'] ?? 'Admin';


            try {
                $this->pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password, [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
                ]);
            } catch (PDOException $ex) {
                echo "Database connection failed: " . $ex->getMessage();
            }
        }

        public static function getInstance() : ?Conn {
            if (!self::$instance) {
                self::$instance = new self();
            }
            return self::$instance;
        }

        public static function getPDO() : ?PDO {
            return self::getInstance()->pdo;
        }
    }
}
