<?php

namespace App\Controllers;

use App\Controller;

class LoginController extends Controller
{
    public function index()
    {

        $this->render('login');
    }

    public function __construct()
{
    $this->model = new \App\Models\LoginModel();
}

public function invoke(){
    $reslt = $this->model->login(); 

    if($reslt == "login"){}

}

}