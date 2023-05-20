<?php
require('db.php');
require('head.php');
?>

<body>

    <?php
    require('navbar.php');
    ?>
    <div class="container">
        <?php
        require('sidebar.php');
        ?>
        <div class="content">
            <div class="heading">
                <h2><u>View Student Details</u></h2>
            </div>
            <div>
                <?php
                if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['id'])) {
                    $id = $_GET['id'];
                } else {
                    $id = false;
                }

                if (!$id && $_SERVER['REQUEST_METHOD'] === 'GET') {
                    header("Location: index.php");
                } else {
                    $isError = false;
                    if ($_SERVER['REQUEST_METHOD'] === 'GET') {
                        $sql = "SELECT * FROM students WHERE id = '$id'";

                        $result = $conn->query($sql);
                        $row = $result->fetch_assoc();

                        $firstName = $row['first_name'];
                        $lastName = $row['last_name'];
                        $mobile = $row['mobile'];
                        $email = $row['email'];
                        $branch = $row['branch'];
                        $address = $row['address'];
                        $additionalSubjects = json_decode($row['additional_subjects']);
                        $hostelFacility = $row['is_hostel_opted'];
                    }
                    $conn->close();
                }
                ?>

            </div>
            <div class="form-container">

                <div class="row-container">
                    <div class="input-container"></div>
                    <div class="input-container"></div>
                </div>

                <div class="row-container">
                    <div class="input-container">
                        <label for="first_name">
                            First Name :
                        </label>
                        <p><?php echo $firstName; ?></p>
                    </div>
                    <div class="input-container">
                        <label for="last_name">
                            Last Name :
                        </label>
                        <p><?php echo $lastName; ?></p>
                    </div>
                </div>
                <div class="row-container">
                    <div class="input-container">
                        <label for="mobile">Mobile :</label>
                        <p><?php echo $mobile; ?></p>
                    </div>
                    <div class="input-container">
                        <label for="email">Email :</label>
                        <p><?php echo $email; ?></p>
                    </div>
                </div>
                <div class="row-container">
                    <div class="input-container">
                        <label for="branch">Branch :</label>
                        <p><?php echo $branch; ?></p>
                    </div>
                    <div class="input-container">
                        <label>Opted for hostel facility :</label>
                        <p><?php echo $hostelFacility == 1 ? 'Yes' : 'No'; ?></p>
                    </div>
                </div>
                <div class="row-container">
                    <div class="input-container">
                        <label>Additional Subjects Opted: </label>
                        <p><?php echo join(', ', $additionalSubjects); ?></p>
                    </div>
                </div>
                <div class="row-container">
                    <div class="input-container">
                        <label for="address">
                            Permanent Address :
                        </label>
                        <p><?php echo $address; ?></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="js/script.js"></script>
</body>

</html>