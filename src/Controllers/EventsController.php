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
        $user = unserialize($_SESSION['gebruiker']);
        
        $eventModel = new EventsModel();
        
        $eventModel->roles = $user->getRoles();
        
        $events = $eventModel->generateEvents();
        $eventModel->setEvents($events);
        $this->render('events', (array)$eventModel);
    }

    public function delete() {
        if (!isset($_GET['userID'])) {
            $this->redirect('/beheer/event');
            exit();
        }
        if (!isset($_SESSION['gebruiker']))
        {
            $this->redirect('/login');
            exit();
        }
        $id = intval($_GET['userID']);
        EventsModel::delete($id);
        $this->redirect('/beheer/event');
    }
}
