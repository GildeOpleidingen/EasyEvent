<?php

namespace App\Controllers;

use App\Controller;

class EventsController extends Controller
{
    public function index()
    {

        $this->render('events');
    }

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
}