<?php
require 'functions.php';
if(!isLoggedIn()){
    header('Location: login.php');
    exit();
}
// Initialize info variable
$info = '';

// Handle program deletion
if (isset($_GET['delete']) && isAdmin()) {
    try {
        // Check if module with the given ID exists
        if (getModuleById($_GET['delete'])) {
            // Attempt to delete the module
            $check = deleteModuleById($_GET['delete']);
            if ($check) {
                // Module deleted successfully
                $info = '<div class="alert alert-success alert-dismissible fade show" role="alert">
                        Module deleted successfully.
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>';
            } else {
                // Error occurred during deletion
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

// Handle form submission for adding a module
if ($_SERVER["REQUEST_METHOD"] == "POST" && isAdmin()) {
    if (isset($_POST['moduleName'], $_POST['programId'], $_POST['semester'])) {
        $moduleName = $_POST['moduleName'];
        $programId = $_POST['programId'];
        $semester = $_POST['semester'];

        // Check if module with the same name already exists for this program and semester
        $module = getModuleByName($moduleName);
        if ($module && $module['program_id'] == $programId && $module['semester'] == $semester) {
            $info = '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                        Module already exists for this program and semester.
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>';
        } else {
            // Add module
            $data = array(
                'module_name' => $moduleName,
                'program_id' => $programId,
                'semester' => $semester
            );
            $result = addModule($data);

            // Display error or success message in Bootstrap alert
            if ($result) {
                $info = '<div class="alert alert-success alert-dismissible fade show" role="alert">
                            Module added successfully.
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
                        <h1 class="h2">Modules</h1>
                        <!-- Button trigger modal -->
                        <?php
                        if (isAdmin()) {
                            echo '<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addModuleModal">
                                    Add Module
                                </button>';
                        }
                        ?>
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
                                        <th>Program</th>
                                        <th>Semester</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    if (isAdmin()) {
                                        $modules = getAllModules();
                                    } elseif (isLecturer()) {
                                        $modules = getLecturerModules($_SESSION['user_id']);
                                    } elseif (isStudent()) {
                                        $modules = getStudentModules($_SESSION['user_id']);
                                    }
                                    if ($modules) {
                                        foreach ($modules as $module) {

                                            $program_id = $module['program_id'];
                                            $program = getProgramById($program_id);

                                            $department_id = $program['department_id'];
                                            $department = getDepartmentById($department_id);
                                            $action = '';
                                            if (isAdmin()) {
                                                $action .= "<a href='edit_module.php?id=" . $module['module_id'] . "' class='btn mx-1 btn-primary btn-sm'><i class='fa fa-edit'></i></a><a onclick='return confirm(\"Do you really want to delete?\")' href='?delete=" . $program['program_id'] . "' class='btn mx-1 btn-danger btn-sm'><i class='fa fa-trash'></i></a>";
                                            }
                                            $action .= "<a href='module-details.php?id=" . $module['module_id'] . "' class='btn mx-1 btn-info btn-sm'><i class='fa fa-eye'></i></a>";

                                            echo "<tr>";
                                            echo "<td>" . $module['module_id'] . "</td>";
                                            echo "<td>" . $module['module_name'] . "</td>";
                                            echo "<td>" . $department['department_name'] . "</td>";
                                            echo "<td>" . $program['program_name'] . "</td>";
                                            echo "<td>" . $module['semester'] . "</td>";
                                            echo "<td>
                                " . $action . "
                            </td>";
                                            echo "</tr>";
                                        }
                                    } else {
                                        echo "<tr><td colspan='5'>No modules found</td></tr>";
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </main>
            </div>
        </div><!-- Modal for adding a program -->
        <!-- Modal for adding modules -->
        <div class="modal fade" id="addModuleModal" tabindex="-1" aria-labelledby="addModuleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addModuleModalLabel">Add Module</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form method="POST">
                            <div class="mb-3">
                                <label for="moduleName" class="form-label">Module Name:</label>
                                <input type="text" class="form-control" id="moduleName" name="moduleName" required>
                            </div>
                            <div class="mb-3">
                                <label for="programId" class="form-label">Program:</label>
                                <select class="form-select" id="programId" name="programId" required>
                                    <option value="">Select Program</option>
                                    <!-- Fetch programs from database and populate options -->
                                    <?php
                                    // Include your database connection and program CRUD functions here
                                    $programs = getAllPrograms(); // Assuming you have a function to fetch programs
                                    if ($programs) {
                                        foreach ($programs as $program) {
                                            echo '<option value="' . $program['program_id'] . '">' . $program['program_name'] . '</option>';
                                        }
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="semester" class="form-label">Semester:</label>
                                <input type="number" class="form-control" id="semester" name="semester" required>
                            </div>
                            <button type="submit" class="btn btn-primary">Add Module</button>
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