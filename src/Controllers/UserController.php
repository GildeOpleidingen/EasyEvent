<?php

namespace App\Controllers;

use App\Controller;
use App\Models\EventsModel;
use App\Models\UserModel;

class UserController extends Controller {
    public function index(): void {
        $usermodel = new UserModel();
        $this->render("beheer/user-overzicht", (array)$usermodel);
    }
}