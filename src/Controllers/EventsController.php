<?php

namespace App\Controllers;

use App\Controller;
use App\Conn;
use App\Models\EventsModel;

class EventsController extends Controller
{
    public function adminIndex() {
        $eventModel = new EventsModel();
        $events = $eventModel->getMainEvents();
        $eventModel->setEvents($events);
        $this->render('beheer/event-overzicht', (array)$eventModel);
    }

    public function index()
    {
        $eventModel = new EventsModel();
        $events = $eventModel->generateEvents();
        $eventModel->setEvents($events);
        $this->render('events', (array)$eventModel);
    }
}