<?php
require 'functions.php';
if(!isAdmin()){
    header('Location: timetables.php');
    exit();
}
// Handle form submission
$info = '';
if (isset($_GET['delete'])) {
    try {
        if (getProgramById($_GET['delete'])) {
            $check = deleteProgramById($_GET['delete']);
            if ($check) {
                $info = '<div class="alert alert-success alert-dismissible fade show" role="alert">
                    Program deleted successfully.
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                  </div>';
            } else {
                $info = '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                    An error occurred.
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                  </div>';
            }
        }
    } catch (Exception $e) {
        // Handle the exception
        $info = '<div class="alert alert-danger alert-dismissible fade show" role="alert">
            An error occurred: There are other db tables associated with it.
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>';
    }
}
// Handle form submission for adding a program
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['programName'], $_POST['departmentId'])) {
        $programName = $_POST['programName'];
        $departmentId = $_POST['departmentId'];

        // Check if program with the same name already exists
        $program = getProgramByName($programName);
        if ($program && $program['department_id'] == $departmentId) {
            $info = '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                        Program already exists for this department.
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>';
        } else {
            // Add program
            $data = array(
                'program_name' => $programName,
                'department_id' => $departmentId
            );
            $result = addProgram($data);

            // Display error or success message in Bootstrap alert
            if ($result) {
                $info = '<div class="alert alert-success alert-dismissible fade show" role="alert">
                            Program added successfully.
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
                        <h1 class="h2">Programs</h1>
                        <!-- Button trigger modal -->
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                            data-bs-target="#addProgramModal"> Add Program </button>
                    </div>
                    <?php echo $info; ?>
                    <div class="card shadow">
                        <div class="card-body">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Name</th>
                                        <th>Department</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $programs = getAllPrograms(); // Assuming you have a function to fetch programs
                                    if ($programs) {
                                        foreach ($programs as $program) {
                                            $department_id = $program['department_id'];
                                            $department = getDepartmentById($department_id);
                                            echo "<tr>";
                                            echo "<td>" . $program['program_id'] . "</td>";
                                            echo "<td>" . $program['program_name'] . "</td>";
                                            echo "<td>" . $department['department_name'] . "</td>";
                                            echo "<td>
                                                <a href='edit_program.php?id=" . $program['program_id'] . "' class='btn btn-primary btn-sm'><i class='fa fa-edit'></i></a>
                                                <a onclick='return confirm(\"Do you really want to delete?\")' href='?delete=" . $program['program_id'] . "' class='btn btn-danger btn-sm'><i class='fa fa-trash'></i></a>
                                            </td>";
                                            echo "</tr>";
                                        }
                                    } else {
                                        echo "<tr><td colspan='4'>No programs found</td></tr>";
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
        <div class="modal fade" id="addProgramModal" tabindex="-1" aria-labelledby="addProgramModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addProgramModalLabel">Add Program</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form method="POST">
                            <div class="mb-3">
                                <label for="programName" class="form-label">Program Name:</label>
                                <input type="text" class="form-control" id="programName" name="programName" required>
                            </div>
                            <div class="mb-3">
                                <label for="departmentId" class="form-label">Department:</label>
                                <select class="form-select" id="departmentId" name="departmentId" required>
                                    <option value="">Select Department</option>
                                    <!-- Fetch departments from database and populate options -->
                                    <?php
                                    // Include your database connection and department CRUD functions here
                                    $departments = getAllDepartments(); // Assuming you have a function to fetch departments
                                    if ($departments) {
                                        foreach ($departments as $department) {
                                            echo '<option value="' . $department['department_id'] . '">' . $department['department_name'] . '</option>';
                                        }
                                    }
                                    ?>
                                </select>
                            </div>
                            <button type="submit" class="btn btn-primary">Add Program</button>
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