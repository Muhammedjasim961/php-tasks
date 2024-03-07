<?php

namespace OneHRMS\Model;

class BaseModel {

    protected $conn;

    public function  __construct($db)
    {

        $this->conn = $db;
    }
}