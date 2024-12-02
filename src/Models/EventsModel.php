<?php

namespace App\Models;

use App;

class EventsModel
{
    protected $db;
    
    private int $eventID;
    public string $eventName;
    public string $eventInfo;
    public string $eventPlace;
    private int $eventOrganizer;
    public string $eventBanner;
    public $eventTime = [];   //[[startTime,endTime],[startTime,endTime]]
    public $eventSectorInfo = []; //[[sectorName,sectorStarttime,sectorEndTime,Vrijwilligers],[sectorName,sectorStarttime,sectorEndTime,Vrijwilligers]]
    public $images = [];  //[[imageName,imageDescription],[imageName,imageDescription]]

    public function __construct(string $eventName, string $eventInfo, string $eventBanner, string $eventPlace, array $eventTime){
        $this->eventName = $eventName;
        $this->eventInfo = $eventInfo;
        $this->eventBanner = $eventBanner;
        $this->eventPlace = $eventPlace;
        $this->eventTime[] = $eventTime;
    }

    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    // Setters
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    public function setEventName(string $eventName){
        $this->eventName = $eventName;
    }
    public function setEventInfo(string $eventInfo){
        $this->eventInfo = $eventInfo;
    }
    public function setEventPlace(string $eventPlace){
        $this->eventPlace = $eventPlace;
    }
    public function setEventOrganizer(int $eventOrganizer){
        $this->eventOrganizer = $eventOrganizer;
    }
    public function setEventBanner(string $eventBanner){
        $this->eventBanner = $eventBanner;
    }
    public function addEventTime(array $timeSlot){
        $this->eventTime[] = $timeSlot;
    }
    public function addEventSectorInfo(array $sectorInfo){
        $this->eventSectorInfo[] = $sectorInfo;
    }
    public function addImage(array $image){
        $this->images[] = $image;
    }
    
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    // Getters
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    public function getEventID(){
        return $this->eventID;
    }
    public function getEventName(){
        return $this->eventName;
    }
    public function getEventInfo(){
        return $this->eventInfo;
    }
    public function getEventPlace(){
        return $this->eventPlace;
    }
    public function getEventOrganizer(){
        return $this->eventOrganizer;
    }
    public function getEventBanner(){
        return $this->eventBanner;
    }
    public function getEventTime(){
        return $this->eventTime;
    }
    public function getEventSectorInfo(){
        return $this->eventSectorInfo;
    }
    public function getImages(){
        return $this->images;
    }

    public static function generateEvents(){
        $sql = "SELECT 
            event.ID, 
            event.Eventnaam, 
            event.Info, 
            `event-tijd`.Datum
        FROM 
            event
        JOIN 
            `event-tijd` 
        ON 
            event.ID = `event-tijd`.Event_ID;";
    }
    public function sendEvent(int $subEventID = null)
    {
        // SQL to insert event data into the `event` table, now including `subEvent`
        $sqlEvent = "INSERT INTO event (Eventnaam, Info, Plaats, Organisator, subEvent) VALUES (:eventName, :eventInfo, :eventPlace, :eventOrganizer, :subEvent)";

        // Prepare and execute the query for the `event` table
        $stmtEvent = $this->db->prepare($sqlEvent);
        $stmtEvent->bindParam(':eventName', $this->eventName);
        $stmtEvent->bindParam(':eventInfo', $this->eventInfo);
        $stmtEvent->bindParam(':eventPlace', $this->eventPlace);
        $stmtEvent->bindParam(':eventOrganizer', $this->eventOrganizer);
        $stmtEvent->bindParam(':subEvent', $subEventID);

        if ($stmtEvent->execute()) {
            // Retrieve the last inserted ID for the event
            $this->eventID = $this->db->lastInsertId();

            // Insert each time slot into the `event-tijd` table
            $sqlEventTime = "INSERT INTO `event-tijd` (Event_ID, Datum, BeginTijd, EindTijd) 
                            VALUES (:eventID, :date, :startTime, :endTime)";

            $stmtEventTime = $this->db->prepare($sqlEventTime);

            foreach ($this->eventTime as $timeSlot) {
                $stmtEventTime->bindParam(':eventID', $this->eventID);
                $stmtEventTime->bindParam(':date', $timeSlot['date']);
                $stmtEventTime->bindParam(':startTime', $timeSlot['startTime']);
                $stmtEventTime->bindParam(':endTime', $timeSlot['endTime']);

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