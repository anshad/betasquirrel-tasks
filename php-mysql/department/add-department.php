<?php
require_once '../database/Database.php';
require_once '../model/Department.php';

$db = OneHRMS\database\Database::connect();

$department = new OneHRMS\model\Department($db);
$errors = [];
$data = [
    'name' => '',
];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $data = [
        'name' => $_POST['name']
    ];

    $department->name = $data['name'];

    $errors = $department->validate($data);

    if (count($errors) === 0) {
        $result = isset($_POST['id']) ? $department->update($_POST['id']) : $department->add();

        if ($result) {
            header('Location: index.php');
            exit;
        } else {
            echo 'Error in saving department.';
        }
    }
} else if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['id'])) {
    $department_id = $_GET['id'];

    $existing_department = $department->findOne($department_id);
    if ($existing_department) {
        $data = $existing_department;
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">
    <title>One HRMS | Manage Departments</title>
    <?php include_once ('../partials/header.php'); ?>
</head>

<body>
    <?php include_once ('../partials/navbar.php'); ?>
    <div class="d-flex">
        <?php include_once ('../partials/sidebar.php'); ?>
        <div class="container-fluid main-content">
            <div class="row">
                <div class="col mt-3">
                    <h2 class="mb-3">
                        <?php if (isset($department_id)): ?>
                        Edit Department
                        <?php else: ?>
                        Add Department
                        <?php endif; ?>
                    </h2>
                    <hr />
                </div>
            </div>

            <div class="row">
                <div class="col">
                    <?php if ($errors): ?>
                    <div class="alert alert-danger">
                        <?php foreach ($errors as $error): ?>
                        <p><?php echo $error; ?></p>
                        <?php endforeach; ?>
                    </div>
                    <?php endif; ?>
                    <form method="POST"
                          action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>"
                          id="department-form">
                        <?php if (isset($department_id)): ?>
                        <input type="hidden"
                               name="id"
                               value="<?php echo $department_id; ?>" />
                        <?php endif; ?>
                        <div class="row">
                            <div class="col-sm-12 col-md-12 mb-3">
                                <div class="form-group">
                                    <label for="name">Department Name: <span class="required-asterisk">*</span></label>
                                    <input type="text"
                                           class="form-control"
                                           name="name"
                                           id="name"
                                           value="<?php echo htmlspecialchars($data['name']); ?>"
                                           required />
                                </div>
                            </div>

                        </div>

                        <button type="button"
                                class="btn btn-warning"
                                onclick="resetForm('department-form')">Clear</button>
                        <button type="submit"
                                class="btn btn-success">
                            <?php if (isset($department_id)): ?>
                            Update
                            <?php else: ?>
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
        include_once ('../partials/footer.php');
    ?>
</body>

</html>