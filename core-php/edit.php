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
                <h2><u>Update Student Details</u></h2>
            </div>
            <div>
                <?php

                function sanitizeField($field)
                {
                    $field = trim($field);
                    $field = stripcslashes($field);
                    $field = htmlspecialchars($field);
                    return $field;
                }

                if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['id'])) {
                    $id = $_GET['id'];
                } else if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                    $id = $_POST['id'];
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

                    $firstNameError = '';
                    $lastNameError = '';
                    $mobileError = '';
                    $emailError = '';
                    $branchError = '';
                    $addressError = '';

                    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                        $firstName = sanitizeField($_POST['first_name']);
                        $lastName = sanitizeField($_POST['last_name']);
                        $mobile = sanitizeField($_POST['mobile']);
                        $email = sanitizeField($_POST['email']);
                        $branch = sanitizeField($_POST['branch']);
                        $address = sanitizeField($_POST['address']);
                        $additionalSubjects = isset($_POST['additional_subjects']) ? $_POST['additional_subjects'] : [];
                        $hostelFacility = sanitizeField($_POST['hostel_facility']);

                        if (empty($firstName)) {
                            $firstNameError = 'First Name is mandatory!';
                            $isError = true;
                        }

                        if (empty($lastName)) {
                            $lastNameError = 'Last Name is mandatory!';
                            $isError = true;
                        }

                        if (empty($mobile)) {
                            $mobileError = 'Mobile Number is mandatory!';
                            $isError = true;
                        }

                        if (empty($email)) {
                            $emailError = 'Email Address is mandatory!';
                            $isError = true;
                        }

                        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                            $emailError = "Invalid email format";
                            $isError = true;
                        }

                        if (empty($branch)) {
                            $branchError = 'Branch is mandatory!';
                            $isError = true;
                        }

                        if (empty($address)) {
                            $addressError = 'Address is mandatory!';
                            $isError = true;
                        }

                        if (!$isError) {
                            $sql = "UPDATE `students` SET `first_name` = '" . $firstName . "', `last_name` = '" . $lastName . "', `mobile` = '" . $mobile . "', `email` = '" . $email . "', `branch` = '" . $branch . "', `is_hostel_opted` = '" . $hostelFacility . "', `address` = '" . $address . "', `additional_subjects` = '" . json_encode($additionalSubjects) . "' WHERE id = '" . $id . "'";

                            if ($conn->query($sql) === TRUE) {
                                header("Location: index.php");
                            } else {
                                echo $conn->error;
                            }
                        }

                        $conn->close();
                    }
                }
                ?>

            </div>
            <div class="form-container">
                <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                    <div class="row-container">
                        <div class="input-container"></div>
                        <div class="input-container"></div>
                    </div>

                    <div class="row-container">
                        <div class="input-container">
                            <input type="hidden" name="id" value=<?php echo $id; ?> />
                            <label for="first_name">
                                First Name <span class="red-text">*</span> :
                            </label>
                            <input type="text" name="first_name" required id="first_name" placeholder="Enter your first name" value="<?php echo $firstName; ?>" class="<?php echo isset($firstNameError) && !empty($firstNameError) ? 'error-input' : ''; ?>" />

                            <?php if (isset($firstNameError) && !empty($firstNameError)) { ?>
                                <div class="error">
                                    <?php echo $firstNameError; ?>
                                </div>
                            <?php } ?>

                        </div>
                        <div class="input-container">
                            <label for="last_name">
                                Last Name <span class="red-text">*</span> :
                            </label>
                            <input type="text" name="last_name" id="last_name" required placeholder="Enter your last name" class="<?php echo isset($lastNameError) && !empty($lastNameError) ? 'error-input' : ''; ?>" value="<?php echo $lastName; ?>" />
                            <?php if (isset($lastNameError) && !empty($lastNameError)) { ?>
                                <div class="error">
                                    <?php echo $lastNameError; ?>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                    <div class="row-container">
                        <div class="input-container">
                            <label for="mobile">Mobile <span class="red-text">*</span> :</label>
                            <input type="tel" name="mobile" id="mobile" required pattern="[6-9]{1}[0-9]{9}" placeholder="[6-9]00000000" class="<?php echo isset($mobile_error) && !empty($mobile_error) ? 'error-input' : ''; ?>" value="<?php echo $mobile; ?>" />
                            <?php if (isset($mobile_error) && !empty($mobile_error)) { ?>
                                <div class="error">
                                    <?php echo $mobile_error; ?>
                                </div>
                            <?php } ?>
                        </div>
                        <div class="input-container">
                            <label for="email">Email <span class="red-text">*</span> :</label>
                            <input type="email" name="email" id="email" required placeholder="Enter your email address" class="<?php echo isset($emailError) && !empty($emailError) ? 'error-input' : ''; ?>" value="<?php echo $email; ?>" />
                            <?php if (isset($emailError) && !empty($emailError)) { ?>
                                <div class="error">
                                    <?php echo $emailError; ?>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                    <div class="row-container">
                        <div class="input-container">
                            <label for="branch">Branch <span class="red-text">*</span> :</label>
                            <select name="branch" id="branch" required class="<?php echo isset($branchError) && !empty($branchError) ? 'error-input' : ''; ?>">
                                <option>Select branch you like</option>
                                <option value="Computer Science" <?php echo $branch == 'Computer Science' ? 'selected' : '';  ?>>Computer Science</option>
                                <option value="Electronics" <?php echo $branch == 'Electronics' ? 'selected' : '';  ?>>Electronics</option>
                                <option value="Mechanical" <?php echo $branch == 'Mechanical' ? 'selected' : '';  ?>>Mechanical</option>
                            </select>
                            <?php if (isset($branchError) && !empty($branchError)) { ?>
                                <div class="error">
                                    <?php echo $branchError; ?>
                                </div>
                            <?php } ?>
                        </div>
                        <div class="input-container">
                            <label>Do you need hostel facility :</label>
                            <label class="wrapper">
                                <input type="radio" name="hostel_facility" value="1" <?php echo $hostelFacility == 1 ? 'checked' : '';  ?> />
                                Yes
                            </label>
                            <label class="wrapper">
                                <input type="radio" name="hostel_facility" value="0" <?php echo !$hostelFacility ? 'checked' : '';  ?> />
                                No
                            </label>
                        </div>
                    </div>
                    <div class="row-container">
                        <div class="input-container">
                            <label>Choose Additional Subjects: </label>
                            <label class="wrapper check-wrapper">
                                <input type="checkbox" name="additional_subjects[]" value="Cyber Security" <?php echo in_array('Cyber Security', $additionalSubjects) ? 'checked' : ''; ?> />
                                Cyber Security
                            </label>
                            <label class="wrapper check-wrapper">
                                <input type="checkbox" name="additional_subjects[]" value="Artificial Intelligence" <?php echo in_array('Artificial Intelligence', $additionalSubjects) ? 'checked' : ''; ?> />
                                Artificial Intelligence
                            </label>
                            <label class="wrapper check-wrapper">
                                <input type="checkbox" name="additional_subjects[]" value="Blockchain" <?php echo in_array('Blockchain', $additionalSubjects) ? 'checked' : ''; ?> />
                                Blockchain
                            </label>
                            <label class="wrapper check-wrapper">
                                <input type="checkbox" name="additional_subjects[]" value="IoT" <?php echo in_array('IoT', $additionalSubjects) ? 'checked' : ''; ?> />
                                IoT
                            </label>
                            <label class="wrapper check-wrapper">
                                <input type="checkbox" name="additional_subjects[]" value="Robotics" <?php echo in_array('Robotics', $additionalSubjects) ? 'checked' : ''; ?> />
                                Robotics
                            </label>
                        </div>
                    </div>
                    <div class="row-container">
                        <div class="input-container">
                            <label for="address">
                                Permanent Address <span class="red-text">*</span> :
                            </label>
                            <textarea name="address" required id="address" rows="5" placeholder="Enter Address" class="<?php echo isset($addressError) && !empty($addressError) ? 'error-input' : ''; ?>"><?php echo $address; ?></textarea>
                            <?php if (isset($addressError) && !empty($addressError)) { ?>
                                <div class="error">
                                    <?php echo $addressError; ?>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                    <div class="row-container btn-container">
                        <button type="submit" class="button-save">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script src="js/script.js"></script>
</body>

</html>