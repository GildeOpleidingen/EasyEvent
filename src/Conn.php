<?php

namespace App;

use PDO;
use PDOException;

class Conn
{
    private string $server = "127.0.0.1";
    private string $username = "easyevent";
    private string $password = "a[ez-4.wBhai48M8";
    private string $dbname = "easyevent";
    private static ?Conn $instance = null;
    private ?PDO $pdo;

    // Constructor to initialize the connection parameters
    private function __construct(){
        try{
            $this->pdo = new PDO("mysql:host=$this->server;dbname=$this->dbname", $this->username, $this->password);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $ex){
            echo $ex->getMessage();
        }
    }

    public static function getInstance() : Database{
        if (!self::$instance) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public static function getPDO(){
        return self::$instance->pdo;
    }
}
?>