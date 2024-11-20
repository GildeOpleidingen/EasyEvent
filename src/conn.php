<?php

namespace App;

use PDO;
use PDOException;

class Conn
{
    private string $server;
    private string $username;
    private string $password;
    private string $dbname;
    private ?PDO $conn = null;

    // Constructor to initialize the connection parameters
    public function __construct(
        string $server = "10.250.0.103",
        string $username = "easyevent",
        string $password = "a[ez-4.wBhai48M8",
        string $dbname = "easyevent"
    ) {
        $this->server = $server;
        $this->username = $username;
        $this->password = $password;
        $this->dbname = $dbname;

        // Automatically attempt connection during instantiation
        $this->connect();
    }

    // Establish a database connection
    private function connect(): void
    {
        try {
            $this->conn = new PDO(
                "mysql:host={$this->server};dbname={$this->dbname}",
                $this->username,
                $this->password
            );
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            $this->conn = null;
            error_log("Database connection failed: " . $e->getMessage(), 3, 'error.log');
        }
    }

    // Get the current connection
    public function getConnection(): ?PDO
    {
        return $this->conn;
    }

    // Disconnect from the database
    public function disconnect(): void
    {
        $this->conn = null;
    }

    // Reconnect with new credentials
    public function reconnect(string $server, string $username, string $password, string $dbname): void
    {
        $this->server = $server;
        $this->username = $username;
        $this->password = $password;
        $this->dbname = $dbname;

        $this->connect();
    }
}

// Example Usage
try {
    // Instantiate with default parameters
    $database = new Conn();
    $conn = $database->getConnection();

    if ($conn) {
        echo "Connected successfully!";
    } else {
        echo "Connection failed. Check error.log for details.";
    }

    // Optional: Reconnect with new credentials
    $database->reconnect("new_host", "new_user", "new_pass", "new_dbname");
} catch (Exception $e) {
    error_log("Unexpected error: " . $e->getMessage(), 3, 'error.log');
}
