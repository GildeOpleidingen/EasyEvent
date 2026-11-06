<?php

namespace App\Controllers;

use App\Controller;
use App\Models\VolunteerModel;

class VolunteerController extends Controller
{
    public function index(): void
    {
        try {
            $volunteerModel = new VolunteerModel();
            $activities = $volunteerModel->getOpenActivities();

            $this->render('vrijwilligers', [
                'activities' => $activities,
                'databaseUnavailable' => false
            ]);

        } catch (\Throwable $error) {

            error_log('Vrijwilligerspagina: ' . $error->getMessage());

            $this->render('vrijwilligers', [
                'activities' => [],
                'databaseUnavailable' => true
            ]);
        }
    }
}
