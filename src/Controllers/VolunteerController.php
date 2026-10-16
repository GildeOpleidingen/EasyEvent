<?php

namespace App\Controllers;

use App\Controller;
use App\Models\VolunteerModel;
use Throwable;

class VolunteerController extends Controller
{
    public function index(): void
    {
        try {
            $activities = (new VolunteerModel())->getOpenActivities();
            $this->render('vrijwilligers', ['activities' => $activities]);
        } catch (Throwable $error) {
            http_response_code(503);
            error_log('Volunteer opportunities could not be loaded.');
            $this->render('vrijwilligers', [
                'activities' => [],
                'databaseUnavailable' => true,
            ]);
        }
    }
}
