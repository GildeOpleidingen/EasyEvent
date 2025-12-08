<?php

namespace App\Models;

use App\Conn;
use PDO;

class EventModel
{
    public int $eventID;
    public string $eventName;
    public string $eventInfo;
    public string $Land;
    public string $Plaats;
    public string $Straatnaam;
    public string $Huisnummer;
    public string $Postcode;
    public int $eventOrganizer;
    public $eventSector = [];
    public $eventTimes = [];   //[[dates, startTimes,endTimes],[dates, startTimes,endTimes]]
    public $eventSectorInfo = []; //[[sectorName,sectorStarttime,sectorEndTime,Vrijwilligers],[sectorName,sectorStarttime,sectorEndTime,Vrijwilligers]]
    public $images = [];  //[[imageName,imageDescription],[imageName,imageDescription]]
    public $hoofdEventID;

    public function __construct(int $eventOrganizer = 0, string $eventName = '', string $eventInfo = '', string $Land = '', string $Plaats = '', string $Straatnaam = '', string $Huisnummer = '', string $Postcode = '', array $Sector = [], array $eventTimes = []){
        $this->eventOrganizer = $eventOrganizer;
        $this->eventName = $eventName;
        $this->eventInfo = $eventInfo;
        $this->Land = $Land;
        $this->Plaats = $Plaats;
        $this->Straatnaam = $Straatnaam;
        $this->Huisnummer = $Huisnummer;
        $this->Postcode = $Postcode;
        $this->eventSector = $Sector;
        $this->eventTimes = $eventTimes;
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
    public function setEventCountry(string $Land){
        $this->Land = $Land;
    }
    public function setEventPlace(string $Plaats){
        $this->Plaats = $Plaats;
    }
    public function setEventStreet(string $Straatnaam){
        $this->Straatnaam = $Straatnaam;
    }
    public function setEventHouseNumber(string $Huisnummer){
        $this->Huisnummer = $Huisnummer;
    }
    public function setEventPostcode(string $Postcode){
        $this->Postcode = $Postcode;
    }
    public function setEventSector(string $Sector){
        $this->eventSector[] = $Sector;
    }
    public function setEventOrganizer(int $eventOrganizer){
        $this->eventOrganizer = $eventOrganizer;
    }
    public function addEventTime(array $timeSlot){
        if (!empty($timeSlot) 
            && isset($timeSlot['dates'], $timeSlot['BeginTijd'], $timeSlot['EindTijd']) 
            && $timeSlot['dates'] !== '' && $timeSlot['BeginTijd'] !== '' && $timeSlot['EindTijd'] !== '') 
            {
            $this->eventTimes[] = $timeSlot;
        }
    }
    public function addEventSectorInfo(array $sectorInfo){
        $this->eventSectorInfo[] = $sectorInfo;
    }
    public function addImage(array $image){
        $this->images[] = $image;
    }
    public function addHoofdEventID(int $hoofdEventID){
        $this->hoofdEventID = $hoofdEventID;
    }
    public function addEventID(string $eventID){
        $this->eventID = $eventID;
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
    public function getEventCountry(){
        return $this->Land;
    }
    public function getEventPlace(){
        return $this->Plaats;
    }
    public function getEventStreet(){
        return $this->Straatnaam;
    }
    public function getEventHouseNumber(){
        return $this->Huisnummer;
    }
    public function getEventPostcode(){
        return $this->Postcode;
    }
    public function getEventSector(){
        return $this->eventSector;
    }
    public function getEventOrganizer(){
        return $this->eventOrganizer;
    }
    public function getEventTime(){
        return $this->eventTimes;
    }
    public function getEventSectorInfo(){
        return $this->eventSectorInfo;
    }
    public function getImages(){
        return $this->images;
    }
    public function getHoofdEventID(){
        return $this->hoofdEventID;
    }

    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    // functions
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    public static function hasRole(array $activities, RolModel $rol)
    {
        foreach($activities as $activity)
        {
            if ($activity->hasRole() && $rol->getID() == $activity->getRolID())
            {
                return true;
            }
        }
        
        return false;
    }

    public static function hasOrganisation(array $activities, OrganisationModel $organisation)
    {
        foreach($activities as $activity)
        {
            if ($activity->hasOrganisation() && $organisation->getID() == $activity->getOrganisationID())
            {
                return true;
            }
        }
        return false;
    }

    public function validateModel() {
        //event
        $title;
        $description;
        $date = [];
        $location = [];
        $banner;

        // geen post gebruik eigenschappen van de class
        if (isset($_POST['title']) && isset($_POST['description']) && isset($_POST['date']) && isset($_POST['location']) && isset($_POST['banner'])) {
            // checks for invalid input for title
            if (preg_match("/[éèêüåäöçñØ,.\-\':;!?\/\\\[\]()&@*#+\-=£€\$¥|~]/u",$_POST['title'])) {
                $title = htmlspecialchars($_POST['title']);
            }
            // checks for invalid input for description
            if (preg_match("/[éèêüåäöçñØ,.\-\':;!?\/\\\[\]()&@*#+\-=£€\$¥|~]/u",$_POST['description'])) {
                $description = htmlspecialchars($_POST['description']);
            }
            // checks for invalid input for placename
            if (isset($_POST['Placename[]']) && preg_match("/[éèêüåäöçñØ,.\-\'&\s]/u",$_POST['Placename[]'])) {
                $location = htmlspecialchars($_POST['Placename']);
            }
            if (isset($_POST['date[]']) && isset($_POST['begin-time[]']) && isset($_POST['end-time[]'])) {
                
            }
            if (isset($_POST['Country']) && $_POST['Country'] == "Netherland") {
                if (isset($_POST['Address']) && !preg_match("/^\d{4}\s[A-Z]{2}$/", $_POST['Address'])) {
                    $errors[] = "De postcode moet bestaan uit 4 cijfers, een spatie, en 2 hoofdletters.";
                }
            } else if (isset($_POST['Country']) && $_POST['Country'] == "België"){
                if (isset($_POST['Address']) && !preg_match("/^\d{4}$/", $_POST['Address'])) {
                    $errors[] = "De postcode moet bestaan uit 4 cijfers";
                }
            } else if (isset($_POST['Country']) && $_POST['Country'] == "Duitsland"){
                if (isset($_POST['Address']) && !preg_match("/^\d{5}$/", $_POST['Address'])) {
                    $errors[] = "De postcode moet bestaan uit 5 cijfers";
                }
            } else if (isset($_POST['Country']) && $_POST['Country'] == "Luxemburg"){
                if (isset($_POST['Address']) && !preg_match("/^\d{4}$/", $_POST['Address'])) {
                    $errors[] = "De postcode moet bestaan uit 4 cijfers";
                }
            }
            if (isset($_POST['banner'])) {
                $img = file_get_contents($_POST['banner']);
                $data = base64_encode($img);
            }
            if (!$title && !$description && !$location && !$date && !$banner) {
                $event = new EventModel($title,$description,$location,$date,$banner);
            }
        } 

        if (isset($_POST["activityName1"]) && isset($_POST["activityTime1"]) && isset($_POST["activityPeople1"])){
            $activityCount++;
            if (preg_match("/[éèêüåäöçñØ,.\-\':;!?\/\\\[\]()&@*#+\-=£€\$¥|~]/u",$_POST['activityTitle'])) {
                $description = htmlspecialchars($_POST['activityTitle']);
            }
            if (isset($_POST['activityTime1[]'])) {
                 $date[] = $_POST['date[]'];    
            }
            if (isset($POST['activityPeople1'])){
                $activityPeople = htmlspecialchars($_POST['activityPeople1']);
            }
        } 
        if (!empty($errors)) {
            return $errors;
        }
        return [];
    }
    
    public static function sendEvent(EventModel $event)
    {
        $mysql = Conn::getInstance();
        $db = $mysql->getPDO();
        
        // SQL to insert event data into the `event` table, now including `hoofdEvent`
        $sqlEvent = "INSERT INTO event (naam, beschrijving, organisator_id) VALUES (:eventName, :eventInfo, :eventOrganisator)";

        // Prepare and execute the query for the `event` table
        $stmtEvent = $db->prepare($sqlEvent);
        $stmtEvent->bindParam(':eventName', $event->eventName);
        $stmtEvent->bindParam(':eventInfo', $event->eventInfo);
        $stmtEvent->bindParam(':eventOrganisator', $event->eventOrganizer);

        if ($stmtEvent->execute()) {
            error_log("Event insertion successful: " . json_encode($event));
            // Retrieve the last inserted ID for the event
            $event->eventID = $db->lastInsertId();
            // Insert each time slot into the `event_tijd` table
            $sqlEventTime = "INSERT INTO `event_tijd` 
                             (event_id, land, plaatsnaam, straatnaam, huisnummer, postcode, datum, begin_tijd, eind_tijd) 
                             VALUES (:eventID, :Land, :Plaats, :Straatnaam, :Huisnummer, :Postcode, :date, :BeginTijd, :EindTijd)";
 
            $stmtEventTime = $db->prepare($sqlEventTime);

            foreach ($event->eventTimes as $slot) {
                $stmtEventTime->bindParam(':eventID', $event->eventID);
                $stmtEventTime->bindParam(':Land', $event->Land);
                $stmtEventTime->bindParam(':Plaats', $event->Plaats);
                $stmtEventTime->bindParam(':Straatnaam', $event->Straatnaam);
                $stmtEventTime->bindParam(':Huisnummer', $event->Huisnummer);
                $stmtEventTime->bindParam(':Postcode', $event->Postcode);

                $stmtEventTime->bindParam(':date', $slot['date']);
                $stmtEventTime->bindParam(':BeginTijd', $slot['BeginTime']);
                $stmtEventTime->bindParam(':EindTijd', $slot['EndTime']);

                if (!$stmtEventTime->execute()) {
                    // Rollback if the time slot insertion fails
                    return "The time slot insertion failed!";
                }
            }
            // echo "Successfully added event and all time slots!";
            // return "Successfully added event and all time slots!";

            $sqlSector = "INSERT INTO sector_event
                          (event_id, sector_id)
                          VALUES (:EventID, :SectorID)";

            $stmtSector = $db->prepare($sqlSector);

            foreach ($event->eventSector as $key => $value) {
                $stmtSector->bindParam(':EventID', $event->eventID);
                $stmtSector->bindParam(':SectorID', $value);

                if (!$stmtSector->execute()) {
                    return "The sector insertion failed!";
                }
            }
        }
        error_log("Event insertion failed: " . implode(", ", $stmtEvent->errorInfo()));
        // echo "Insertion into `event` table failed!";
        return "Insertion into `event` table failed!";
    }

    public function sendActivity()
    {
        
    }

}

