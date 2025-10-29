<?php

namespace App\Models;

use App\Conn;
use PDO;

class EventEditModel extends DBModel
{
    public $event;

    public static function getEventByID($eventID) {
        $eventID = $_GET['eventID'] ?? null;
        
        if (!is_numeric($eventID)) {
            die('Invalid event ID.');
        }
        
        $mysql = Conn::getInstance();
        $db = $mysql->getPDO();
            
        $query = "SELECT * FROM `event` WHERE `ID` = :eventID";
        $sqlstmt = $db->prepare($query);
        $sqlstmt->bindParam(':eventID', $eventID, PDO::PARAM_INT);

        if (!$sqlstmt->execute()) {
            die('Query failed: ' . implode(' ', $sqlstmt->errorInfo()));
        }

        return $sqlstmt->fetch(PDO::FETCH_ASSOC);
    }
}