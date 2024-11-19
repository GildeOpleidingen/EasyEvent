<?php

namespace App\Controllers;

use App\Controller;

class EventsController extends Controller
{
    public function index()
    {

        $this->render('events');
    }

    
}