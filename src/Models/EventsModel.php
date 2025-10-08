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
                    event.id, event.naam AS eventName, 
                    event.beschrijving AS eventInfo, 
                    GROUP_CONCAT(`event_tijd`.datum SEPARATOR ',') AS eventDate,
                    event.hoofd_event AS hoofdEventID
                FROM 
                    event 
                LEFT OUTER JOIN `event_tijd` ON event.id=`event_tijd`.event_id
                GROUP BY event.id";

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
                [],
                $eventDates,
                ''
            );
            $event->addEventID($row['id']);
            $event->hoofdEventID = $row['hoofdEventID'];
            $events[] = $event;
        }

        return $events;
    }

    public static function generateEvents() {
        $mysql = Conn::getInstance();
        $db = $mysql->getPDO();
    
        $sql = "SELECT e.id, 
                    e.naam           AS eventName, 
                    e.beschrijving   AS eventInfo, 
                    et.datum         AS eventDate,
                    e.hoofd_event    AS hoofdEventID,
                    e.organisator_id AS organisator,
                    et.land          AS Land,
                    et.plaatsnaam    AS Plaats,
                    et.straatnaam    AS Straatnaam,
                    et.huisnummer    AS Huisnummer,
                    et.postcode      AS Postcode,
                    sagg.sector_ids  AS SectorIDs
                FROM event e
                LEFT JOIN `event_tijd` et 
                    ON e.id = et.event_id
                LEFT JOIN (
                    SELECT  
                        event_id,
                        GROUP_CONCAT(DISTINCT sector_id ORDER BY sector_id SEPARATOR ', ') AS sector_ids
                    FROM sector_event
                    GROUP BY event_id
                ) sagg
                    ON sagg.event_id = e.id;
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
                $row['Sector'] ?? [],
                [['date' => $row['eventDate'], 'startTime' => null, 'endTime' => null]], 
            );
            $event->eventID = $row['id'];
            $event->hoofdEventID = $row['hoofdEventID'];
            $events[] = $event;
        }
    
        return $events;
    }
}
