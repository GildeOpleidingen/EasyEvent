<?php

namespace App\Controllers;

use App\Controller;
use App\Models\PlanningsModel;

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
        // $id = intval($_GET['eventID']);
        // $user = unserialize($_SESSION['gebruiker']);
        // $planningsModel = new PlanningsModel($user->getId(), -1, [], -1, [], []);
        // $plannedActivities = $planningsModel->getPlanning($id);
        // $planningsModel->setActivities($plannedActivities);
        $this->render('/beheer/planning-overzicht', [
        //     'planningsModel' => (array)$planningsModel,
        //     // 'activities' => $plannedActivities
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

        $this->render('/beheer/activiteiten-overzicht', [

        ]);
    }
}
