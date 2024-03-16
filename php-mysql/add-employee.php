<?php
require_once 'database/Database.php';
require_once 'model/Employee.php';

$db = OneHRMS\database\Database::connect();

$employee = new OneHRMS\model\Employee($db);
$errors = [];
$data = [
    'first_name' =>  '',
    'last_name' =>  '',
    'email' => '',
    'salary' => '',
    'department' => ''
];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $data = [
        'first_name' =>  $_POST['first_name'],
        'last_name' =>  $_POST['last_name'],
        'email' => $_POST['email'],
        'salary' => $_POST['salary'],
        'department' => $_POST['department']
    ];

    $employee->first_name = $data['first_name'];
    $employee->last_name = $data['last_name'];
    $employee->email = $data['email'];
    $employee->salary = $data['salary'];
    $employee->department = $data['department'];

    $errors = $employee->validate($data);

    if (count($errors) === 0) {
        $result = isset($_POST['id']) ? $employee->update($_POST['id']) : $employee->add();

        if ($result) {
            header('Location: index.php');
            exit;
        } else {
            echo 'Error in saving employee.';
        }
    }
} else if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['id'])) {
    $employee_id = $_GET['id'];

    $existing_employee = $employee->findOne($employee_id);
    if ($existing_employee) {
        $data = $existing_employee;
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>One HRMS | Manage Employees</title>
    <?php include_once('partials/header.php'); ?>
</head>

<body>
    <?php include_once('partials/navbar.php'); ?>
    <div class="d-flex">
        <?php include_once('partials/sidebar.php'); ?>
        <div class="container-fluid main-content">
            <div class="row">
                <div class="col mt-3">
                    <h2 class="mb-3">
                        <?php if (isset($employee_id)) : ?>
                            Edit Employee
                        <?php else : ?>
                            Add Employee
                        <?php endif; ?>
                    </h2>
                    <hr />
                </div>
            </div>

            <div class="row">
                <div class="col">
                    <?php if ($errors) : ?>
                        <div class="alert alert-danger">
                            <?php foreach ($errors as $error) : ?>
                                <p><?php echo $error; ?></p>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                    <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" id="employee-form">
                        <?php if (isset($employee_id)) : ?>
                            <input type="hidden" name="id" value="<?php echo $employee_id; ?>" />
                        <?php endif; ?>
                        <div class="row">
                            <div class="col-sm-12 col-md-6 mb-3">
                                <div class="form-group">
                                    <label for="first-name">First Name: <span class="required-asterisk">*</span></label>
                                    <input type="text" class="form-control" name="first_name" id="first-name" value="<?php echo htmlspecialchars($data['first_name']); ?>" required />
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-6 mb-3">
                                <div class="form-group">
                                    <label for="last-name">Last Name: <span class="required-asterisk">*</span></label>
                                    <input type="text" class="form-control" name="last_name" id="last-name" value="<?php echo htmlspecialchars($data['last_name']); ?>" required />
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <div class="form-group mb-3">
                                    <label for="email">Email: <span class="required-asterisk">*</span></label>
                                    <input type="email" class="form-control" name="email" id="email" value="<?php echo htmlspecialchars($data['email']); ?>" required />
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group mb-3">
                                    <label for="salary">Salary:</label>
                                    <input type="number" class="form-control" name="salary" id="salary" value="<?php echo htmlspecialchars($data['salary']); ?>" />
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="department">Department:</label>
                                    <input type="text" class="form-control" name="department" id="department" value="<?php echo htmlspecialchars($data['department']); ?>" />
                                </div>
                            </div>
                        </div>
                        <button type="button" class="btn btn-warning" onclick="resetForm()">Clear</button>
                        <button type="submit" class="btn btn-success">
                            <?php if (isset($employee_id)) : ?>
                                Update
                            <?php else : ?>
                                Save
                            <?php endif; ?>
                        </button>

                    </form>
                </div>
            </div>

        </div>
    </div>
    <?php
    OneHRMS\database\Database::close();
    include_once('partials/footer.php');
    ?>
</body>

</html>