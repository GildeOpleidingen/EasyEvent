<?php

namespace App\Models;

use App\Conn;
use PDO;

class SingleEventModel extends DBModel
{
    public $event;
    public $activities;

    public function __construct()
    {

    }

    public function setEvent(EventModel $event){
        $this->event = $event;
    }

    public function getEvent(){
        return $this->event;
    }

    public function setActivities(array $activities){
        $this->activities = $activities;
    }

    public function getActivities(){
        return $this->activities;
    }

    public static function getActivitiesById(int $id)
    {
        $mysql = Conn::getInstance();
        $db = $mysql->getPDO();

        $sql = "SELECT * FROM planning
                LEFT JOIN `event-tijd` ON planning.Event_Tijd_ID = `event-tijd`.ID
                LEFT JOIN `activiteit` ON planning.ActiviteitID = `activiteit`.ID
                WHERE`event-tijd`.Event_ID=:eventid";

        $stmt = $db->prepare($sql);

        if (!$stmt->execute(['eventid' => $id])) {
            die('Query failed: ' . implode(' ', $stmt->errorInfo()));
        }

        $activities = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $activity = new ActivityModel($row['Naam']);
            $activities[] = $activity;
        }

        return $activities;
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
