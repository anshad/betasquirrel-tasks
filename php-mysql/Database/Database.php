<?php

namespace OneHRMS\database;

use mysqli;

class Database
{
    private $host = "127.0.0.1";
    private $dbName = 'one-hrms';
    private $username = "root";
    private $password = "root";
    private $conn;

    public function connect()
    {
        $this->conn = null;
        $this->conn = new mysqli($this->host, $this->username, $this->password, $this->dbName);

        if ($this->conn->connect_error) {
            die("Connection failed: " . $this->conn->connect_error);
        }

        return $this->conn;
    }
}
