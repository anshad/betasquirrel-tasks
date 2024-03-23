<?php
include_once '../database/Database.php';
include_once '../model/Department.php';

use OneHRMS\model\Department;

if (isset($_GET['id']) && !empty($_GET['id'])) {
    $db = OneHRMS\database\Database::connect();

    $department = new Department($db);
    $id = $_GET['id'];

    if ($department->delete($id)) {
        OneHRMS\database\Database::close();
        header('Location: index.php');
        exit;
    } else {
        echo 'Error deleting department.';
    }
}