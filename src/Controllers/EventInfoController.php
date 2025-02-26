<?php

namespace App\Controllers;

use App\Controller;
use App\Conn;
use App\Models\SingleEventModel;

class EventInfoController extends Controller
{
    public function index()
    {
        if (!isset($_GET['eventID'])) {
            header('Location: /events');
            exit();
        }

        $id = intval($_GET['eventID']);
        $eventModel = new SingleEventModel();
        $event = $eventModel->getEventById($id);
        if (!$event) {
            $this->render('event-info', ['error' => 'Dit event model bestaat niet']);
        } 
        $eventModel->setEvent($event);
        $this->render('event-info', (array)$eventModel);
    }
}