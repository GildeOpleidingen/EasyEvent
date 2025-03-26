<?php

namespace App\Controllers;

use App\Controller;
use App\Models\EventsModel;
use App\Models\UsersModel;

class UserController extends Controller {
    public function index() {
        $this->render("beheer/user-overzicht");
    }

}