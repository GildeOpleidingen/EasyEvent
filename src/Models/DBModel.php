<?php

namespace App\Models;

use App\Conn;

class DBModel
{
    protected $db;
    protected $conn;
    
    public function __construct()
    {
        $this->conn = new Conn('10.250.0.103',  'easyevent', 'a[ez-4.wBhai48M8', 'easyevent');
        $this->db = $this->conn->getConnection();
    }

    public function prepare()
    {
        return $this->db->getConnection()->prepare();
    }
}