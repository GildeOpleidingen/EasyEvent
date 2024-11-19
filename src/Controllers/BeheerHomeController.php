<?php

namespace App\Controllers;

use App\Controller;

class BeheerHomeController extends Controller {
    public function index() {
        $this->render('beheer/home');
    }
}