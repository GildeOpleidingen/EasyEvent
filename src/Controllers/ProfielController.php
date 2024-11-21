<?php
namespace App\Controllers;

use App\Controller;

class ProfielController extends Controller {
    public function index() {
        $this->render('profiel');
    }
}