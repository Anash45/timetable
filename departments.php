<?php
require 'functions.php';
// Handle form submission
if(!isAdmin()){
    header('Location: timetables.php');
    exit();
}
$info = '';
if (isset($_GET['delete'])) {
    try {
        $department = getDepartmentById($_GET['delete']);
        if ($department) {
            $check = deleteDepartmentById($_GET['delete']);
            if ($check) {
                $info = '<div class="alert alert-success alert-dismissible fade show" role="alert">
                        Department deleted successfully.
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                      </div>';
            } else {
                $info = '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                        An error occurred.
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                      </div>';
            }
        } else {
            $info = '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                    Department not found.
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                  </div>';
        }
    } catch (Exception $e) {
        // Handle the exception
        $info = '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                An error occurred: There are other db tables associated with it.
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
              </div>';
    }
}
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['departmentName'])) {
        $departmentName = $_POST['departmentName'];

        if (getDepartmentByName($departmentName)) {
            $info = '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                    Department already exists.
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                  </div>';
        } else {
            $data = array('department_name' => $departmentName);
            // Add department
            $result = addDepartment($data);

            // Display error or success message in Bootstrap alert
            if ($result) {
                $info = '<div class="alert alert-success alert-dismissible fade show" role="alert">
                    Department added successfully.
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                  </div>';
            } else {
                $info = '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                    An error occurred.
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                  </div>';
            }
        }
    }
}
?>
<!doctype html>
<html lang="en">

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="">
        <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
        <meta name="generator" content="Hugo 0.84.0">
        <title>University Timetable</title>
        <!-- Bootstrap core CSS -->
        <link href="./assets/css/bootstrap.min.css" rel="stylesheet">
        <link rel="stylesheet" href="./assets/fontawesome/css/all.css">
        <link href="./assets/css/style.css" rel="stylesheet">
    </head>

    <body>
        <?php include 'header.php'; ?>
        <div class="container-fluid">
            <div class="row">
                <?php include 'sidebar.php'; ?>
                <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
                    <div
                        class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                        <h1 class="h2">Departments</h1>
                        <!-- Button trigger modal -->
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                            data-bs-target="#addDepartmentModal"> Add Department </button>
                    </div>
                    <?php echo $info; ?>
                    <div class="card shadow">
                        <div class="card-body">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Name</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $departments = getAllDepartments();
                                    if ($departments) {
                                        foreach ($departments as $department) {
                                            echo "<tr>";
                                            echo "<td>" . $department['department_id'] . "</td>";
                                            echo "<td>" . $department['department_name'] . "</td>";
                                            echo "<td>
                                            <a href='edit_department.php?id=" . $department['department_id'] . "' class='btn btn-primary btn-sm'><i class='fa fa-edit'></i></a>
                                            <a onclick='return confirm(\"Do you really want to delete?\")' href='?delete=" . $department['department_id'] . "' class='btn btn-danger btn-sm'><i class='fa fa-trash'></i></a>
                                        </td>";
                                            echo "</tr>";
                                        }
                                    } else {
                                        echo "<tr><td colspan='3'>No departments found</td></tr>";
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </main>
            </div>
        </div>
        <!-- Modal -->
        <div class="modal fade" id="addDepartmentModal" tabindex="-1" aria-labelledby="addDepartmentModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addDepartmentModalLabel">Add Department</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form method="POST">
                            <div class="mb-3">
                                <label for="departmentName" class="form-label">Department Name:</label>
                                <input type="text" class="form-control" id="departmentName" name="departmentName"
                                    required>
                            </div>
                            <button type="submit" class="btn btn-primary">Add Department</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <script src="./assets/js/jquery-3.6.1.min.js"></script>
        <script src="./assets/js/bootstrap.bundle.min.js"></script>
        <script src="./assets/js/script.js"></script>
    </body>

</html>