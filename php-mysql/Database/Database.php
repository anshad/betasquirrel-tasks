<?php

namespace OneHRMS\database;

use mysqli;

class Database
{
    private static $host = '127.0.0.1';
    private static $dbName = 'one-hrms';
    private static $username = 'root';
    private static $password = 'root';
    private static $conn;

    public static function connect()
    {
        self::$conn = null;

        try {
            self::$conn = new mysqli(self::$host, self::$username, self::$password, self::$dbName);

            if (self::$conn->connect_error) {
                throw new \Exception('Connection failed: ' . self::$conn->connect_error);
            }
        } catch (\Exception $e) {
            echo 'Error connecting to database: ' . $e->getMessage();
            exit;
        }

        return self::$conn;
    }

    public static function close()
    {
        if (self::$conn !== null) {
            self::$conn->close();
            self::$conn = null;
        }
    }
}