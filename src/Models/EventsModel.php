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

    public static function getMainEvents() {
        $mysql = Conn::getInstance();
        $db = $mysql->getPDO();

        $sql = "SELECT 
                    event.ID, event.EventNaam AS eventName, 
                    event.Info AS eventInfo, 
                    GROUP_CONCAT(`event-tijd`.Datum SEPARATOR ',') AS eventDate,
                    event.HoofdEvent AS hoofdEventID
                FROM 
                    event 
                LEFT OUTER JOIN `event-tijd` ON event.ID=`event-tijd`.Event_ID
                GROUP BY event.ID";

        $stmt = $db->prepare($sql);

        if (!$stmt->execute()) {
            die('Query failed: ' . implode(' ', $stmt->errorInfo()));
        }

        $events = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $eventDates = [];
            if (isset($row['eventDate']))
            {
                $dates = explode(',', $row['eventDate']);
                foreach ($dates as $date) {
                    $eventDates[] = ['date' => $date, 'startTime' => null, 'endTime' => null];
                }
            }
            $event = new EventModel(
                $row['eventName'],
                $row['eventInfo'],
                '',
                $eventDates,
                ''
            );
            $event->addEventID($row['ID']);
            $event->hoofdEventID = $row['hoofdEventID'];
            $events[] = $event;
        }

        return $events;
    }

    public static function generateEvents() {
        $mysql = Conn::getInstance();
        $db = $mysql->getPDO();
    
        $sql = "SELECT 
                    event.ID, event.EventNaam AS eventName, 
                    event.Info AS eventInfo, 
                    `event-tijd`.Datum AS eventDate,
                    event.HoofdEvent AS hoofdEventID
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
                '', // eventLocatie (mist in query)
                [['date' => $row['eventDate'], 'startTime' => null, 'endTime' => null]], 
                '' // eventBanner (mist in query)
            );
            $event->eventID = $row['ID'];
            $event->hoofdEventID = $row['hoofdEventID'];
            $events[] = $event;
        }
    
        return $events;
    }
}
