<?php

namespace App\Controllers;

use App\Controller;

class RegisterController extends Controller
{
    public function index()
    {

        $this->render('register');
    }
}