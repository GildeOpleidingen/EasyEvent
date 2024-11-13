<?php

namespace App\Controllers;

use App\Controller;

class EventInfoController extends Controller
{
    public function index()
    {

        $this->render('event-info');
    }
}