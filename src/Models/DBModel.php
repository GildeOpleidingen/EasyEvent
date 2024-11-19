<?php

namespace App\Models;

use App;

class DBModel
{
    protected $db;
    
    public function __construct()
    {
        $this->db = new \PDO('mysql:host=10.250.0.103;dbname=easyevent', 'easyevent', 'a[ez-4.wBhai48M8', [
            \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION
        ]);
    }
}