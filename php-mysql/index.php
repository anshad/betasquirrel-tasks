<?php
$page = isset($_GET['page']) ? (int) $_GET['page'] : 1;

$sort = isset($_GET['sort']) ? $_GET['sort'] : null;
$order = isset($_GET['order']) ? $_GET['order'] : 'ASC';

$searchField = isset($_GET['searchField']) ? $_GET['searchField'] : null;
$searchType = isset($_GET['searchType']) ? $_GET['searchType'] : null;
$searchValue = isset($_GET['searchValue']) ? $_GET['searchValue'] : null;

$searchValue2 = isset($_GET['searchValue2']) ? $_GET['searchValue2'] : null;

function generateHrefQuery($page, $searchField, $searchType, $searchValue, $searchValue2, $sortField, $sortOrder = 'asc')
{
    return "?sort=$sortField&order=$sortOrder&page=$page&searchField=$searchField&searchType=$searchType&searchValue=" . urlencode($searchValue ? $searchValue : '') . '&searchValue2=' . urlencode($searchValue2 ? $searchValue2 : '') . '';
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">
    <title>One HRMS | Employees</title>
    <?php include_once ('partials/header.php'); ?>
</head>

<body>
    <?php include_once ('partials/navbar.php'); ?>
    <div class="d-flex">
        <?php include_once ('partials/sidebar.php'); ?>
        <div class="container-fluid main-content">
            <div class="row">
                <div class="col mt-3">
                    <h2 class="mb-3">Employees</h2>
                    <hr />
                </div>
            </div>
            <div class="text-end">
                <a href="add-employee.php"
                   class="btn btn-primary btn-sm">Add Employee</a>
            </div>

            <div class="row mt-4 mb-2">
                <div class="col">
                    <form action=""
                          method="GET"
                          id="search-form">
                        <input type="hidden"
                               name="sort"
                               value="<?= $sort ?>" />
                        <input type="hidden"
                               name="order"
                               value="<?= $order ?>" />
                        <input type="hidden"
                               name="page"
                               value="1" />
                        <div class="input-group">
                            <select class="form-select"
                                    name="searchField">
                                <option value="first_name"
                                        <?php echo $searchField === 'first_name' ? 'selected' : ''; ?>>
                                    First Name
                                </option>
                                <option value="last_name"
                                        <?php echo $searchField === 'last_name' ? 'selected' : ''; ?>>
                                    Last Name
                                </option>
                                <option value="email"
                                        <?php echo $searchField === 'email' ? 'selected' : ''; ?>>
                                    Email
                                </option>
                                <option value="salary"
                                        <?php echo $searchField === 'salary' ? 'selected' : ''; ?>>
                                    Salary
                                </option>
                                <option value="department"
                                        <?php echo $searchField === 'department' ? 'selected' : ''; ?>>
                                    Department
                                </option>
                            </select>
                            <select class="form-select"
                                    name="searchType"
                                    id="searchType"
                                    onchange="toggleBetweenInput()">
                                <option value="contains"
                                        <?php echo $searchType === 'contains' ? 'selected' : ''; ?>>
                                    Contains
                                </option>
                                <option value="starts_with"
                                        <?php echo $searchType === 'starts_with' ? 'selected' : ''; ?>>
                                    Starts with
                                </option>

                                <option value="ends_with"
                                        <?php echo $searchType === 'ends_with' ? 'selected' : ''; ?>>
                                    Ends with
                                </option>
                                <option value="equals"
                                        <?php echo $searchType === 'equals' ? 'selected' : ''; ?>>
                                    Equals
                                </option>
                                <option value="greater"
                                        <?php echo $searchType === 'greater' ? 'selected' : ''; ?>>
                                    Greater than
                                </option>
                                <option value="less"
                                        <?php echo $searchType === 'less' ? 'selected' : ''; ?>>
                                    Less than
                                </option>
                                <option value="between"
                                        <?php echo $searchType === 'between' ? 'selected' : ''; ?>>
                                    Between
                                </option>
                            </select>
                            <input type="text"
                                   class="form-control"
                                   name="searchValue"
                                   placeholder="Search value..."
                                   value='<?php echo $searchValue; ?>' />

                            <input id="betweenValue"
                                   style="display: <?php echo $searchValue2 ? 'block' : 'none' ?>;"
                                   type="text"
                                   class="form-control"
                                   name="searchValue2"
                                   placeholder="Second value..."
                                   value='<?php echo $searchValue2; ?>' />

                            <button class="btn btn-primary"
                                    type="submit">Search</button>
                        </div>
                    </form>
                </div>
            </div>

            <table class="table table-striped mt-3">
                <thead>
                    <tr>
                        <th>
                            ID
                            <a
                               href="<?php echo generateHrefQuery($page, $searchField, $searchType, $searchValue, $searchValue2, 'id'); ?>">&uarr;</a>
                            |
                            <a
                               href="<?php echo generateHrefQuery($page, $searchField, $searchType, $searchValue, $searchValue2, 'id', 'desc'); ?>">&darr;</a>
                        </th>
                        <th>
                            First Name
                            <a
                               href="<?php echo generateHrefQuery($page, $searchField, $searchType, $searchValue, $searchValue2, 'first_name'); ?>">&uarr;</a>
                            |
                            <a
                               href="<?php echo generateHrefQuery($page, $searchField, $searchType, $searchValue, $searchValue2, 'first_name', 'desc'); ?>">&darr;</a>
                        </th>
                        <th>
                            Last Name
                            <a
                               href="<?php echo generateHrefQuery($page, $searchField, $searchType, $searchValue, $searchValue2, 'last_name'); ?>">&uarr;</a>
                            |
                            <a
                               href="<?php echo generateHrefQuery($page, $searchField, $searchType, $searchValue, $searchValue2, 'last_name', 'desc'); ?>">&darr;</a>
                        </th>
                        <th>
                            Email
                            <a
                               href="<?php echo generateHrefQuery($page, $searchField, $searchType, $searchValue, $searchValue2, 'email'); ?>">&uarr;</a>
                            |
                            <a
                               href="<?php echo generateHrefQuery($page, $searchField, $searchType, $searchValue, $searchValue2, 'email', 'desc'); ?>">&darr;</a>
                        </th>
                        <th>
                            Salary
                            <a
                               href="<?php echo generateHrefQuery($page, $searchField, $searchType, $searchValue, $searchValue2, 'salary'); ?>">&uarr;</a>
                            |
                            <a
                               href="<?php echo generateHrefQuery($page, $searchField, $searchType, $searchValue, $searchValue2, 'salary', 'desc'); ?>">&darr;</a>
                        </th>
                        <th>
                            Department
                            <a
                               href="<?php echo generateHrefQuery($page, $searchField, $searchType, $searchValue, $searchValue2, 'department'); ?>">&uarr;</a>
                            |
                            <a
                               href="<?php echo generateHrefQuery($page, $searchField, $searchType, $searchValue, $searchValue2, 'department', 'desc'); ?>">&darr;</a>
                        </th>
                        <th class="text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        require_once ('database/Database.php');
                        require_once ('model/Employee.php');

                        $itemsPerPage = 10;

                        $db = OneHRMS\database\Database::connect();

                        $employee = new OneHRMS\model\Employee($db);
                        $result = $employee->listAll($page, $itemsPerPage, $sort, $order, $searchField, $searchType, $searchValue, $searchValue2);

                        $totalCount = $employee->getTotalCount($searchField, $searchType, $searchValue, $searchValue2);
                        $totalPages = ceil($totalCount / $itemsPerPage);

                        $range = 2;
                        $start = max($page - $range, 1);
                        $end = min($page + $range, $totalPages);

                        if ($result && $result->num_rows > 0) {
                            while ($row = $result->fetch_object()) {
                                echo '<tr>';
                                echo '<td>' . $row->id . '</td>';
                                echo '<td>' . $row->first_name . '</td>';
                                echo '<td>' . $row->last_name . '</td>';
                                echo '<td>' . $row->email . '</td>';
                                echo '<td>' . $row->salary . '</td>';
                                echo '<td>' . $row->department . '</td>';
                                echo "<td class='text-end'>
                                        <a href='add-employee.php?id=" . $row->id . "' class='btn btn-warning btn-sm'>
                                            Edit
                                        </a>
                                        <a href='delete-employee.php?id=" . $row->id . "' class='btn btn-danger btn-sm' onclick='return confirmDelete()'>
                                            Delete
                                        </a>
                                     </td>";
                                echo '</tr>';
                            }
                        } else {
                            echo "<tr>
                                    <td colspan='7' class='text-center'>No records found!</td>
                                </tr>";
                        }

                        OneHRMS\database\Database::close();
                    ?>
                </tbody>
            </table>
            <nav class="text-center">
                <ul class="pagination justify-content-center">
                    <li class="page-item <?= ($page <= 1) ? 'disabled' : '' ?>">
                        <a class="page-link"
                           href="?page=<?= max($page - 1, 1) ?>&sort=<?= $sort ?>&order=<?= $order ?>&searchField=<?= $searchField ?>&searchType=<?= $searchType ?>&searchValue=<?= urlencode($searchValue ? $searchValue : '') ?>&searchValue2=<?= urlencode($searchValue2 ? $searchValue2 : '') ?>"
                           aria-label="Previous">
                            <span aria-hidden="true">&laquo;</span>
                        </a>
                    </li>

                    <?php
                        $start = max($start, 1);

                        for ($i = $start; $i <= $end; $i++):
                    ?>
                    <li class="page-item <?= ($i == $page) ? 'active' : '' ?>">
                        <a class="page-link"
                           href="?page=<?= $i ?>&sort=<?= $sort ?>&order=<?= $order ?>&searchField=<?= $searchField ?>&searchType=<?= $searchType ?>&searchValue=<?= urlencode($searchValue ? $searchValue : '') ?>&searchValue2=<?= urlencode($searchValue2 ? $searchValue2 : '') ?>"><?= $i ?></a>
                    </li>
                    <?php endfor; ?>

                    <li class="page-item <?= ($page >= $totalPages) ? 'disabled' : '' ?>">
                        <a class="page-link"
                           href="?page=<?= min($page + 1, $totalPages) ?>&sort=<?= $sort ?>&order=<?= $order ?>&searchField=<?= $searchField ?>&searchType=<?= $searchType ?>&searchValue=<?= urlencode($searchValue ? $searchValue : '') ?>&searchValue2=<?= urlencode($searchValue2 ? $searchValue2 : '') ?>"
                           aria-label="Next">
                            <span aria-hidden="true">&raquo;</span>
                        </a>
                    </li>
                </ul>
            </nav>
        </div>
    </div>
    <?php include_once ('partials/footer.php'); ?>
</body>

</html>