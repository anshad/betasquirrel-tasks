<?php
include_once 'Database/Database.php';
include_once 'Model/Employee.php';

use OneHRMS\Database\Database;
use OneHRMS\Model\Employee;

if (isset($_GET['id']) && !empty($_GET['id'])) {
    $database = new Database();
    $db = $database->connect();

    $employee = new Employee($db);
    $id = $_GET['id'];

    if ($employee->delete($id)) {
        header("Location: index.php");
        exit;
    } else {
        echo "Error deleting employee.";
    }
}
