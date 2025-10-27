<?php

namespace App\Controllers;

use App\Controller;
use App\Conn;
use App\Models\RolModel;
use App\Models\SingleEventModel;
use App\Models\UserModel;
use App\Models\PlanningsModel;
use App\Models\BeheerHomeModel;

class BeheerHomeController extends Controller {

    public function index() {

        $user = unserialize($_SESSION['gebruiker']);

        $bhModel = new BeheerHomeModel();
        $bhModel->roles = $user->getRoles();
        $bhModel->firstName = $user->getVoornaam();

        $bevoegd = false;

        foreach ($bhModel->roles as $role) {
            if ($role->getName() == 'Admin' || $role->getName() == 'Organisator') {
                $bevoegd = true;
            }
        }

        if (!$bevoegd) {
            $this->redirect('/events');
            exit();
        }

        $this->render('beheer/home', (array)$bhModel);
    }
}