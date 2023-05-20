<?php
require('db.php');

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['id'])) {
    $id = $_GET['id'];
} else {
    $id = false;
}

if (!$id && $_SERVER['REQUEST_METHOD'] === 'GET') {
    header("Location: index.php");
} else {
    if ($_SERVER['REQUEST_METHOD'] === 'GET') {
        $sql = "DELETE FROM students WHERE id = '$id'";
        if ($conn->query($sql) === TRUE) {
            header("Location: index.php");
        } else {
            echo $conn->error;
        }
        $conn->close();
    }
}
