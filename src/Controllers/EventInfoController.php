<?php

namespace App\Controllers;

use App\Controller;
use App\Conn;
use App\Models\SingleEventModel;
use App\Models\UserModel;

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
        $activities = $eventModel->getActivitiesByEventId($id);
        if (isset($_SESSION['gebruiker']))
        {
            $user = unserialize($_SESSION['gebruiker']);
            $eventModel->setGebruikerId($user->getId());
            
            $active_roles = $user->getRoles();
            $eventModel->setRoles($active_roles);

            $organisations = $eventModel->getOrganisations();
            $eventModel->setOrganisations($organisations);
        }

        $eventModel->setEvent($event);
        $eventModel->setActivities($activities);
        $this->render('event-info', (array)$eventModel);
    }

    public function update()
    {
        if (!isset($_GET['eventID'])) {
            header('Location: /events');
            exit();
        }

        $id = intval($_GET['eventID']);
        $role = isset($_POST['role']) ? $_POST['role'] : null;
        $activities = isset($_POST['activities']) ? $_POST['activities'] : null;

        // TODO validate Vrijwilliger aantal of Begeleider Aantal

        print_r($_POST['activities']);
        die();
    }
}