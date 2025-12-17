<?php

namespace App\Controllers;

use App\Controller;
use App\Models\PlanningsModel;
use App\Models\ActivityModel;

class PlanningController extends Controller
{
    public function index()
    {
        if (!isset($_GET['activiteitID'])) {
            $this->redirect('/beheer/event');
            exit();
        }
        if (!isset($_SESSION['gebruiker']))
        {
            $this->redirect('/login');
            exit();
        }
 
        $activiteitID = $_GET['activiteitID'];
        $activity = ActivityModel::getActiviteitById($activiteitID);
        $planning = PlanningsModel::getPlanning($activiteitID);

        $this->render('/beheer/planning-overzicht', [
            'id' => $activiteitID,
            'activity' => $activity,
            'planning' => $planning
        ]);
    }

    public function activiteitIndex() {
        if (!isset($_GET['eventID'])) {
            $this->redirect('/beheer/event');
            exit();
        }
        if (!isset($_SESSION['gebruiker']))
        {
            $this->redirect('/login');
            exit();
        }

        $eventid = $_GET['eventID'];
        $activiteiten = ActivityModel::getActiviteitenByEventId($eventid);

        $this->render('/beheer/activiteiten-overzicht', [
            'activiteiten' => $activiteiten,
            'eventid' => $eventid
        ]);
    }
}
