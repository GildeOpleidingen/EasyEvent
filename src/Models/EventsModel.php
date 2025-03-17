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
<<<<<<< HEAD
    
    public static function sendEvent(EventsModel $event)
    {
        $mysql = Conn::getInstance();
        $db = $mysql->getPDO();
    
        // SQL to insert event data into the `event` table, now including `hoofdEvent`
        $sqlEvent = "INSERT INTO event (Eventnaam, Info, Banner, Organisator) VALUES (:eventName, :eventInfo, :eventBanner, :eventOrganizer)";

        // Prepare and execute the query for the `event` table
        $stmtEvent = $db->prepare($sqlEvent);
        $stmtEvent->bindParam(':eventName', $event->eventName);
        $stmtEvent->bindParam(':eventInfo', $event->eventInfo);
        $stmtEvent->bindParam(':eventBanner', $event->eventBanner);
        $stmtEvent->bindParam(':eventOrganizer', $event->eventOrganizer);

        if ($stmtEvent->execute()) {
            // Retrieve the last inserted ID for the event
            $event->eventID = $db->lastInsertId();

            // Insert each time slot into the `event-tijd` table
            $sqlEventTime = "INSERT INTO `event-tijd` (Event_ID, Land, Plaats, Straatnaam, Huisnummer, Postcode, Datum, BeginTijd, EindTijd, sector) 
                            VALUES (:eventID, :Land, :Plaats, :Straatnaam, :Huisnummer, :Postcode, :date, :BeginTijd, :EindTijd, :Sector)";

            $stmtEventTime = $db->prepare($sqlEventTime);

            foreach ($event->eventTime as $timeSlot) {
                $stmtEventTime->bindParam(':eventID', $event->eventID);
                $stmtEventTime->bindParam(':Land', $event->Land);
                $stmtEventTime->bindParam(':Plaats', $event->Plaats);
                $stmtEventTime->bindParam(':Straatnaam', $event->Straatnaam);
                $stmtEventTime->bindParam(':Huisnummer', $event->Huisnummer);
                $stmtEventTime->bindParam(':Postcode', $event->Postcode);
                $stmtEventTime->bindParam(':date', $timeSlot['date']);
                $stmtEventTime->bindParam(':BeginTijd', $timeSlot['BeginTijd']);
                $stmtEventTime->bindParam(':EindTijd', $timeSlot['EindTijd']);
                $stmtEventTime->bindParam(':Sector', $event->Sector);

                if (!$stmtEventTime->execute()) {
                    // Rollback if the time slot insertion fails
                    return "The time slot insertion failed!";
                }
            }
            return "Successfully added event and all time slots!";
        }
        return "Insertion into `event` table failed!";
    }

}
=======
}
>>>>>>> 04c7575d5c74a360487d6f42df0fce296542eed7
