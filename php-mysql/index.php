<?php include_once('partials/header.php'); ?>

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
                    <h2 class="mb-3">Employees</h2>
                    <hr />
                </div>
            </div>
            <div class="text-end">
                <a href="add-employee.php" class="btn btn-primary btn-sm">Add Employee</a>
            </div>
            <table class="table table-striped mt-3">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>First Name</th>
                        <th>Last Name</th>
                        <th>Email</th>
                        <th>Salary</th>
                        <th>Department</th>
                        <th class="text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    include_once 'Database/Database.php';
                    include_once 'Model/Employee.php';

                    $database = new OneHRMS\database\Database();
                    $db = $database->connect();

                    $employee = new OneHRMS\Model\Employee($db);

                    $result = $employee->listAll();

                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td>" . $row['id'] . "</td>";
                            echo "<td>" . $row['first_name'] . "</td>";
                            echo "<td>" . $row['last_name'] . "</td>";
                            echo "<td>" . $row['email'] . "</td>";
                            echo "<td>" . $row['salary'] . "</td>";
                            echo "<td>" . $row['department'] . "</td>";
                            echo "<td class='text-end'>
                                <a href='add-employee.php?id=" . $row['id'] . "' class='btn btn-warning btn-sm'>
                                Edit
                                </a>
                                <a href='delete-employee.php?id=" . $row['id'] . "' class='btn btn-danger btn-sm' onclick='return confirmDelete()'>Delete</a>
                            </td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='6' class='text-center'>No employees found</td></tr>";
                    }

                    $db->close();
                    ?>
                </tbody>
            </table>
        </div>
    </div>
    <?php include_once('partials/footer.php'); ?>

</body>
</body>

</html>