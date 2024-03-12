<?php

namespace OneHRMS\model;

class BaseModel
{
    protected $conn;

    public function __construct($db)
    {
        $this->conn = $db;
    }
}
