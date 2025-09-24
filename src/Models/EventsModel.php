<?php

namespace App\Models;

use App\Conn;
use PDO;

class EventsModel extends DBModel
{
    public $events;
    public $roles;

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
                 0,
                $row['eventName'],
                $row['eventInfo'],
                '',
                '',
                '',
                '',
                '',
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
    
        $sql = "SELECT event.ID, event.Eventnaam AS eventName, 
                    event.Info AS eventInfo, 
                    `event-tijd`.Datum AS eventDate,
                    event.HoofdEvent AS hoofdEventID,
                    event.Organisator AS organisator,
                    `event-tijd`.Land AS Land,
                    `event-tijd`.Plaats AS Plaats,
                    `event-tijd`.Huisnummer AS Huisnummer,
                    `event-tijd`.Postcode AS Postcode,
                    `event-tijd`.Straatnaam AS Straatnaam,
                    `event-tijd`.Sector AS Sector,
                    event.Banner AS Banner
                FROM event 
                LEFT OUTER JOIN `event-tijd` ON event.ID=`event-tijd`.Event_ID
                ";
        $stmt = $db->prepare($sql);

        if (!$stmt->execute()) {
            die('Query failed: ' . implode(' ', $stmt->errorInfo()));
        }
    
        $events = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $event = new EventModel(
                (int)$row['organisator'],
                $row['eventName'],
                $row['eventInfo'],
                $row['Land'] ?? 'Unknown',
                $row['Plaats'] ?? 'Unknown',
                $row['Straatnaam'] ?? 'Unknown',
                $row['Huisnummer'] ?? 'Unknown',
                $row['Postcode'] ?? 'Unknown',
                $row['Sector'] ?? 'Unknown',
                [['date' => $row['eventDate'], 'startTime' => null, 'endTime' => null]], 
                $row['Banner'] ?? ''
            );
            $event->eventID = $row['ID'];
            $event->hoofdEventID = $row['hoofdEventID'];
            $events[] = $event;
        }
    
        return $events;
    }
}
