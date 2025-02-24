<?php

namespace App\Models;

use App\Conn;
use PDO;
// require __DIR__ . "/../Conn.php";

class EventsModel
{
    protected $db;

    private int $eventID;
    public string $eventName;
    public string $eventInfo;
    public string $eventPlace;
    private int $eventOrganizer;
    public string $eventBanner;
    public $Land;
    public $Plaats;
    public $Straatnaam;
    public $Postcode;
    public $eventTime = [];   //[[date, startTime,endTime],[date, startTime,endTime]]
    public $Sector;
    public $images = [];  //[[imageName,imageDescription],[imageName,imageDescription]]
    public $hoofdEventID;
    private $events = [];
    private $mysql;
    private $pdo;

    public function __construct(string $eventName, string $eventInfo, int $eventOrganizer, string $eventPlace, array $eventTime, string $eventBanner){
        $this->eventName = $eventName;
        $this->eventInfo = $eventInfo;
        $this->eventOrganizer = $eventOrganizer; 
        $this->eventPlace = $eventPlace;
        $this->eventTime[] = $eventTime;
        $this->eventBanner = $eventBanner;

        $mysql = Conn::getInstance();
        $pdo = $mysql->getPDO();

        // sql to push event to db
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
    public function addSector(string $sector){
        $this->Sector = $sector;
    }
    public function addImage(array $image){
        $this->images[] = $image;
    }
    public function addHoofdEventID(array $hoofdEventID){
        $this->hoofdEventID = $this->hoofdEventID;
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
    public function getSector(){
        return $this->Sector;
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
                $event = new EventsModel($title,$description,$location,$date,$banner);
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
            $event = new self(
                $row['eventName'],
                $row['eventInfo'],
                $row['Organisator'],
                '', // eventLocatie (mist in query)
                [['date' => $row['eventDate'], 'startTime' => null, 'endTime' => null]], 
                $row['Banner']
            );
            $event->eventID = $row['ID'];
            $event->hoofdEventID = $row['hoofdEventID'];
            //$event->setEventOrganizer(4);
            $events[] = $event;
            
        }
    
        return $events;
    }
    
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