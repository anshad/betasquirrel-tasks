<?php
$serverName = "localhost";
$username = "root";
$password = "";
$database = "school";


$conn = new mysqli($serverName, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
