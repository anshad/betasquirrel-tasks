<?php
include_once 'database/Database.php';
include_once 'model/Employee.php';

use OneHRMS\database\Database;
use OneHRMS\model\Employee;

if (isset($_GET['id']) && !empty($_GET['id'])) {
    $database = new Database();
    $db = $database->connect();

    $employee = new Employee($db);
    $id = $_GET['id'];

    if ($employee->delete($id)) {
        $db->close();
        header("Location: index.php");
        exit;
    } else {
        echo "Error deleting employee.";
    }
}
