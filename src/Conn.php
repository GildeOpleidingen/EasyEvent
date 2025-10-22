<?php

namespace App
{

    use PDO;
    use PDOException;
    use Dotenv\Dotenv;
    
    class Conn
    {
        private static ?Conn $instance = null;
        private ?PDO $pdo = null;

        // Constructor to initialize the connection parameters
        private function __construct(){
            $dotenv = Dotenv::createImmutable(__DIR__ . '/../', '.env');
            $dotenv->load();
            $host = $_ENV['DB_HOST'];
            $dbname = $_ENV['DB_NAME'];
            $username = $_ENV['DB_USER'];
            $password = $_ENV['DB_PASS'];

            try{
                $this->pdo = new \PDO("mysql:host=$host;dbname=$dbname", $username, $password, [
                    \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION
                ]);
            } catch (PDOException $ex){
                echo $ex->getMessage();
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
?>