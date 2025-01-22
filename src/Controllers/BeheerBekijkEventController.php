<?php

namespace App\Controllers;

use App\Controller;

class BeheerBekijkEventController extends Controller {
    public function index() {
        $this->render('beheer/bekijk-events');
    }
}