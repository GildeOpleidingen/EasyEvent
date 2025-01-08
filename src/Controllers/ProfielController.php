<?php
namespace App\Controllers;

use App\Controller;

class ProfielController extends Controller
{
    private $model;

    public function index() {
        $this->render('profiel');
    
    }


}