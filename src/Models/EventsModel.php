<?php

namespace App\Models;

use App\Conn;
use PDO;

class EventsModel extends DBModel
{
    public $events;

    public function __construct()
    {

    }

    public function setEvents(array $events){
        $this->events = $events;
    }

    public function getEvents(){
        return $this->events;
    }

    public static function generateEvents() {
        $mysql = Conn::getInstance();
        $db = $mysql->getPDO();
    
        $sql = "SELECT 
                    event.ID, event.EventNaam AS eventName, 
                    event.Info AS eventInfo, 
                    Organisator,
                    `event-tijd`.Datum AS eventDate,
                    event.HoofdEvent AS hoofdEventID,
                    Banner
                FROM 
                    event 
                LEFT OUTER JOIN `event-tijd` ON event.ID=`event-tijd`.Event_ID";

        $stmt = $db->prepare($sql);

        if (!$stmt->execute()) {
            die('Query failed: ' . implode(' ', $stmt->errorInfo()));
        }
    
        $events = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $event = new EventModel(
                $row['eventName'],
                $row['eventInfo'],
                $row['Organisator'],
                '', // eventLocatie (mist in query)
                [['date' => $row['eventDate'], 'startTime' => null, 'endTime' => null]], 
                $row['Banner']
            );
            $event->eventID = $row['ID'];
            $event->hoofdEventID = $row['hoofdEventID'];
            $events[] = $event;
        }
    
        return $events;
    }
}
