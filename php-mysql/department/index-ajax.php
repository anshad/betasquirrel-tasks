<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">
    <title>One HRMS | Departments</title>
    <?php include_once ('../partials/header.php'); ?>
</head>

<body>
    <?php include_once ('../partials/navbar.php'); ?>
    <div class="d-flex">
        <?php include_once ('../partials/sidebar.php'); ?>
        <div class="container-fluid main-content">
            <!-- page heading -->
            <div class="row">
                <div class="col mt-3">
                    <h2 class="mb-3">Departments</h2>
                    <hr />
                </div>
            </div>
            <!-- add button -->
            <div class="text-end">
                <button class="btn btn-primary btn-sm"
                        onclick="showModal()">Add Department</button>
            </div>
            <!-- search -->
            <div class="row mt-4 mb-2">
                <div class="col">
                    <form action=""
                          method="GET"
                          id="search-form">

                        <div class="input-group">
                            <select class="form-select"
                                    name="searchField"
                                    id="search-field">
                                <option value="name">
                                    Department Name
                                </option>
                            </select>
                            <select class="form-select"
                                    name="searchType"
                                    id="search-type">
                                <option value="contains">
                                    Contains
                                </option>
                                <option value="starts_with">
                                    Starts with
                                </option>

                                <option value="ends_with">
                                    Ends with
                                </option>
                                <option value="equals">
                                    Equals
                                </option>
                                <option value="greater">
                                    Greater than
                                </option>
                                <option value="less">
                                    Less than
                                </option>
                                <option value="between">
                                    Between
                                </option>
                            </select>
                            <input type="text"
                                   class="form-control"
                                   name="searchValue"
                                   id="search-value"
                                   placeholder="Search value..." />
                            <input id="search-value2"
                                   style="display: none;"
                                   type="text"
                                   class="form-control"
                                   name="searchValue2"
                                   placeholder="Second value..." />
                            <button class="btn btn-primary"
                                    type="button"
                                    onclick="search()">Search</button>
                        </div>
                    </form>
                </div>
            </div>
            <!-- table list and sorting -->
            <table class="table table-striped mt-3"
                   id="departments-table">
                <thead>
                    <tr>
                        <th class="sortable"
                            data-column="id"
                            onclick="sort('id')">
                            ID <span class="sort-icon"></span>
                        </th>
                        <th class="sortable"
                            data-column="name"
                            onclick="sort('name')">
                            Department Name <span class="sort-icon"></span>
                        </th>
                        <th class="text-end">Actions</th>
                    </tr>
                </thead>
                <tbody id="departments-table-body">
                </tbody>
            </table>
            <!-- pagination -->
            <nav class="text-center">
                <ul class="pagination justify-content-center"
                    id="pagination">
                </ul>
            </nav>
        </div>
    </div>
    <!-- Bootstrap Modal for Add/Edit Department -->
    <div class="modal fade"
         id="departmentModal"
         tabindex="-1"
         aria-labelledby="departmentModalLabel"
         aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"
                        id="departmentModalLabel">Add Department</h5>
                    <button type="button"
                            class="btn-close"
                            data-bs-dismiss="modal"
                            aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- alert -->
                    <div class="row">
                        <div class="col mt-3">
                            <div id="alert-container"></div>
                        </div>
                    </div>
                    <form id="department-form">
                        <input type="hidden"
                               id="department-id" />
                        <div class="mb-3">
                            <label for="department-name"
                                   class="form-label">Department Name</label>
                            <input type="text"
                                   class="form-control"
                                   id="department-name"
                                   required />
                        </div>
                        <button type="submit"
                                class="btn btn-success float-end">Save</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <?php include_once ('../partials/footer.php'); ?>
    <script src="../assets/js/department.js"></script>
</body>

</html>