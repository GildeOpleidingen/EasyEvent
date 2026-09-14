<?php

namespace App\Controllers;

use App\Controller;

class HomeController extends Controller
{
    public function index()
    {
        
        if (isset($_SESSION['Gebruikeremail'])) {
            header('Location: /events');
            exit();
        }

        $this->render('home');
    }
}