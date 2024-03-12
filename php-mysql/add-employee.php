<?php
include_once 'Database/Database.php';
include_once 'Model/Employee.php';

$message = '';
$errors = [];
$form_data = [
    'first_name' => '',
    'last_name' => '',
    'email' => '',
    'salary' => '',
    'department' => ''
];

$database = new OneHRMS\Database\Database();
$db = $database->connect();

$employee = new OneHRMS\Model\Employee($db);

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['id'])) {
    $employee_id = $_GET['id'];
    $existing_employee = $employee->findOne($employee_id);
    if ($existing_employee) {
        $form_data = $existing_employee;
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $form_data = [
        'first_name' => $_POST['first_name'],
        'last_name' => $_POST['last_name'],
        'email' => $_POST['email'],
        'salary' => $_POST['salary'],
        'department' => $_POST['department']
    ];

    $employee->first_name = $data['first_name'];
    $employee->last_name = $data['last_name'];
    $employee->email = $data['email'];
    $employee->salary = $data['salary'];
    $employee->department = $data['department'];

    $errors = $employee->validate($form_data);

    if (count($errors) === 0) {
        $success = isset($_POST['id']) ? $employee->update($_POST['id']) : $employee->add();
        if ($result) {
            header('Location: index.php');
            exit;
        } else {
            $message = 'Error in saving employee.';
        }
    }
}
include_once('partials/header.php');
?>

<body>
    <?php
    include_once('partials/navbar.php');
    ?>
    <div class="d-flex">
        <?php
        include_once('partials/sidebar.php');
        ?>
        <div class="container-fluid main-content">
            <div class="row">
                <div class="col mt-3">
                    <h2 class="mb-3">
                        <?php if (isset($employee_id)) {
                            echo "Edit Employee";
                        } else {
                            echo "Add New Employee";
                        } ?>
                    </h2>
                    <hr />
                </div>
            </div>
            <?php if ($message) : ?>
                <div class="alert alert-danger"><?php echo $message; ?></div>
            <?php endif; ?>
            <?php foreach ($errors as $error) : ?>
                <div class="alert alert-danger"><?php echo $error; ?></div>
            <?php endforeach; ?>
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST" id="employee-form">
                <?php if (isset($employee_id)) : ?>
                    <input type="hidden" name="id" value="<?php echo $employee_id; ?>" />
                <?php endif; ?>
                <div class="row">
                    <div class="col">
                        <div class="form-group mb-3">
                            <label for="first_name">First Name:</label>
                            <input type="text" class="form-control" name="first_name" id="first_name" value="<?php echo htmlspecialchars($form_data['first_name']); ?>" required />
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-group mb-3">
                            <label for="last_name">Last Name:</label>
                            <input type="text" class="form-control" name="last_name" id="last_name" value="<?php echo htmlspecialchars($form_data['last_name']); ?>" required />
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <div class="form-group mb-3">
                            <label for="email">Email:</label>
                            <input type="email" class="form-control" name="email" id="email" required />
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-group mb-3">
                            <label for="salary">Salary:</label>
                            <input type="number" class="form-control" name="salary" id="salary" required />
                        </div>
                    </div>
                </div>


                <div class="form-group mb-3">
                    <label for="department">Department:</label>
                    <input type="text" class="form-control" name="department" id="department" required />
                </div>
                <button type="reset" class="btn btn-warning">Clear</button>
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
    <?php
    $db->close();
    include_once('partials/footer.php');
    ?>
</body>
</body>

</html>