<?php

namespace App\Controllers;

use App\Controller;

class BeheerEventAanmakenController extends Controller {
    public function index() {
        $this->render("beheer/event-aanmaken");
    }
}