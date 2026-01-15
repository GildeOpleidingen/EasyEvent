<?php
namespace App\Controllers;

use App\Models\InschrijfModel;
use App\Controller;

class InschrijfController extends Controller
{
    public function inschrijven(): void
    {
        if (!isset($_SESSION['gebruiker'], $_POST['event_id'], $_POST['event_tijd_ids'])) {
            $this->redirect('/events');
        }

        $user = unserialize($_SESSION['gebruiker']);
        $gebruikerId = $user->getId();
        $eventId = (int)$_POST['event_id'];
        $eventTijdIds = array_map('intval', $_POST['event_tijd_ids']);

        $model = new InschrijfModel();
        $model->inschrijven($gebruikerId, $eventTijdIds);

        $this->redirect('/events');
    }

    public function uitschrijven(): void
    {
        if (!isset($_SESSION['gebruiker'], $_GET['event_id'])) {
            $this->redirect('/events');
        }

        $user = unserialize($_SESSION['gebruiker']);
        $gebruikerId = $user->getId();
        $eventId = (int)$_GET['event_id'];

        $model = new InschrijfModel();
        $model->uitschrijven($gebruikerId, $eventId);

        $this->redirect('/events');
    }
}
