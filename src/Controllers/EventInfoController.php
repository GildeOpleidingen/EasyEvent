<?php

namespace App\Controllers;

use App\Controller;
use App\Conn;
use App\Models\RolModel;
use App\Models\SingleEventModel;
use App\Models\UserModel;
use App\Models\PlanningsModel;

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
        if (isset($_SESSION['gebruiker']))
        {
            $user = unserialize($_SESSION['gebruiker']);
            $eventModel->setGebruikerId($user->getId());

            $activities = $eventModel->getActivitiesByEventIdAndUserId($id, $user->getId());
            $active_roles = RolModel::getRolesByUserId($user->getId());
            $eventModel->setRoles($active_roles);

            $organisations = $eventModel->getOrganisations();
            $eventModel->setOrganisations($organisations);
        }
        else {
            $activities = $eventModel->getActivitiesByEventId($id);
        }

        $eventModel->setEvent($event);
        $eventModel->setActivities($activities);
        $this->render('event-info', (array)$eventModel);
    }

    public function update()
    {
        if (!isset($_POST['eventID'])) {
            header('Location: /events');
            exit();
        }

        if (!isset($_SESSION['gebruiker']))
        {
            header('Location: /events');
            exit();
        }

        $user = unserialize($_SESSION['gebruiker']);

        $id = intval($_POST['eventID']);

        $role = isset($_POST['role']) ? $_POST['role'] : null;
        $organisatieId = isset($_POST['organisation']) ? $_POST['organisation'] : null;
        $postedActivities = isset($_POST['activities']) ? $_POST['activities'] : null;
        $eventModel = new SingleEventModel();
        $activeActivities = $eventModel->getPlanningByEventIdAndUserId($id, $user->getId());
        $activities = $eventModel->getActivitiesByEventId($id);
        $planning = new PlanningsModel($user->getId(), $role, $postedActivities, $organisatieId, $activities, $activeActivities);

        if ($planning->validate()) {
            $event = $eventModel->getEventById($id);
            $eventModel->setEvent($event);
            $planning->sendPlanning($planning);
            $eventModel->setMessage('Gebruiker is toegevoegd aan de activiteit.');
            $this->redirect('/event-info?eventID='.$id . '');
        } else {
            $this->render('event-info', ['error' => 'Gebruiker kon niet worden toegevoegd.']);
        }
    }
}