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
        <h2>Students</h2>
        <a href="admission.php" class="link-btn">Add Student</a>
      </div>
      <div class="table-container">
        <table class="list-table">
          <tr>
            <th>R. No</th>
            <th>Full Name</th>
            <th>Branch</th>
            <th>Mobile</th>
            <th>Email</th>
            <th>Actions</th>
          </tr>
          <?php

          $sql = "SELECT * FROM students";
          $result = $conn->query($sql);

          if ($result->num_rows > 0) {

            while ($row = $result->fetch_assoc()) { ?>
              <tr>
                <td><?php echo $row['id']; ?></td>
                <td><?php echo $row['first_name'] . ' ' . $row['last_name']; ?></td>
                <td><?php echo $row['branch']; ?></td>
                <td><?php echo $row['mobile']; ?></td>
                <td><?php echo $row['email']; ?></td>
                <td>
                  <a class="button" href="edit.php?id=<?php echo $row['id'];  ?>">
                    <i class="fa-solid fa-pencil"></i>
                  </a>
                  <a class="button" href="view.php?id=<?php echo $row['id'];  ?>">
                    <i class="fa-solid fa-eye"></i>
                  </a>
                  <a class="button" href="delete.php?id=<?php echo $row['id'];  ?>" onclick="return confirm('Are you sure to delete?');">
                    <i class="fa-solid fa-trash"></i>
                  </a>


                </td>
              </tr>
            <?php }
          } else { ?>
            <tr>
              <td colspan="6">No Records Found!</td>
            </tr>
          <?php
          }

          $conn->close();
          ?>
        </table>
      </div>
    </div>
  </div>
  <script src="js/script.js"></script>
</body>

</html>