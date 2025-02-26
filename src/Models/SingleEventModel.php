<?php

namespace App\Models;

use App\Conn;
use PDO;

class SingleEventModel extends DBModel
{
    public $event;

    public function __construct()
    {

    }

    public function setEvent(EventModel $event){
        $this->event = $event;
    }

    public function getEvent(){
        return $this->event;
    }

    public static function getEventById(int $id) {
        $mysql = Conn::getInstance();
        $db = $mysql->getPDO();
    
        $sql = "SELECT 
                    event.ID, event.EventNaam AS eventName, 
                    event.Info AS eventInfo, 
                    `event-tijd`.Datum AS eventDate,
                    event.HoofdEvent AS hoofdEventID
                FROM 
                    event 
                LEFT OUTER JOIN `event-tijd` ON event.ID=`event-tijd`.Event_ID
                WHERE event.ID=:eventid";

        $stmt = $db->prepare($sql);

        if (!$stmt->execute(['eventid' => $id])) {
            die('Query failed: ' . implode(' ', $stmt->errorInfo()));
        }
    
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $event = new EventModel(
                $row['eventName'],
                $row['eventInfo'],
                '', // eventLocatie (mist in query)
                [['date' => $row['eventDate'], 'startTime' => null, 'endTime' => null]], 
                '' // eventBanner (mist in query)
            );
            $event->eventID = $row['ID'];
            $event->hoofdEventID = $row['hoofdEventID'];
            return $event;
        }
    }
}
