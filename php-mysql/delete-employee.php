<?php
include_once 'database/Database.php';
include_once 'model/Employee.php';

use OneHRMS\model\Employee;

if (isset($_GET['id']) && !empty($_GET['id'])) {
    $db = OneHRMS\database\Database::connect();

    $employee = new Employee($db);
    $id = $_GET['id'];

    if ($employee->delete($id)) {
        OneHRMS\database\Database::close();
        header("Location: index.php");
        exit;
    } else {
        echo "Error deleting employee.";
    }
}
