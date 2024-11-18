<?php

namespace App;

class Conn {
    private $server;
    private $username;
    private $password;
    private $dbname;
    private $conn;

    public function __construct($server, $username, $password, $dbname) {
        $this->server = $server;
        $this->username = $username;
        $this->password = $password;
        $this->dbname = $dbname;
        
        try {
            $this->conn = new PDO("mysql:host={$this->server};dbname={$this->dbname}", $this->username, $this->password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            $this->conn = null;
            echo "Connection failed: " . $e->getMessage();
            error_log($e, 3, 'error.log');
        }
    }

    public function getConnection() {
        return $this->conn;
    }

    public function disconnect() {
        $this->conn = null;
    }
}

$server = "10.250.0.103";
$username = "easyevent";
$password = "a[ez-4.wBhai48M8";
$dbname = "easyevent";

$database = new Conn($server, $username, $password, $dbname);
$conn = $database->getConnection();