<?php
require 'functions.php';
if(!isLoggedIn()){
    header('Location: login.php');
    exit();
}
// Initialize info variable
$info = '';
// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['students'], $_POST['module_id'])) {
    // Get the module ID and selected student IDs
    $module_id = $_POST['module_id'];
    $selected_students = $_POST['students'];

    // Loop through selected student IDs and assign them to the module
    foreach ($selected_students as $student_id) {
        // Check if the student is not already assigned to the module
        if (!isStudentAssignedToModule($student_id, $module_id)) {
            // Assign the student to the module
            assignStudentToModule($student_id, $module_id);
        }
    }
}
// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['lecturers'], $_POST['module_id'])) {
    // Get the module ID and selected lecturer IDs
    $module_id = $_POST['module_id'];
    $selected_lecturers = $_POST['lecturers'];

    // Loop through selected lecturer IDs and assign them to the module
    foreach ($selected_lecturers as $lecturer_id) {
        // Check if the lecturer is not already assigned to the module
        if (!isLecturerAssignedToModule($lecturer_id, $module_id)) {
            // Assign the lecturer to the module
            assignLecturerToModule($lecturer_id, $module_id);
        }
    }
}

// Check if the 'remove' parameter is present in the URL and if the 'lecturer_id' and 'id' parameters are set
if (isset($_GET['remove'], $_GET['lecturer_id'], $_GET['id'])) {
    // Extract module ID and lecturer ID from the URL parameters
    $module_id = $_GET['id'];
    $lecturer_id = $_GET['lecturer_id'];

    // Check if the lecturer is assigned to the module
    if (isLecturerAssignedToModule($lecturer_id, $module_id)) {
        // Remove the lecturer from the module
        removeLecturerFromModule($lecturer_id, $module_id);
        $info = "<div class='alert alert-success'>Lecturer is removed from this module.</div>";
    }
}

// Check if the 'remove' parameter is present in the URL and if the 'student_id' and 'id' parameters are set
if (isset($_GET['remove'], $_GET['student_id'], $_GET['id'])) {
    // Extract module ID and student ID from the URL parameters
    $module_id = $_GET['id'];
    $student_id = $_GET['student_id'];

    // Check if the student is assigned to the module
    if (isStudentAssignedToModule($student_id, $module_id)) {
        // Remove the student from the module
        removeStudentFromModule($student_id, $module_id);
        $info = "<div class='alert alert-success'>Student is removed from this module.</div>";
    }
}

// Handle program deletion
if (isset($_GET['id'])) {
    $module_id = $_GET['id'];
    $module = getModuleById($module_id); // Assuming you have a function to fetch module details

    if ($module) {
        $module_name = $module['module_name'];
        $semester = $module['semester'];
        $program_id = $module['program_id'];

        // Fetch program name using program_id
        $program = getProgramById($program_id); // Assuming you have a function to fetch program details
        $program_name = $program['program_name'];

        $department_id = $program['department_id'];

        // Fetch department name using department_id
        $department = getDepartmentById($department_id); // Assuming you have a function to fetch department details
        $department_name = $department['department_name'];


        // Fetch lecturers assigned to the module
        $lecturers = getLecturersByModuleId($module_id); // Assuming you have a function to fetch lecturers assigned to a module

        // Fetch students enrolled in the module
        $students = getStudentsByModuleId($module_id); // Assuming you have a function to fetch students enrolled in a module
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
                        <div class="d-flex align-items-center gap-2">
                            <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal"
                                data-bs-target="#assignStudentsModal"> Assign Students </button>
                            <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal"
                                data-bs-target="#assignLecturersModal"> Assign Lecturers </button>
                        </div>
                    </div>
                    <?php echo $info; ?>
                    <div class="card shadow">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <p><b>Name:</b> <?php echo $module_name; ?></p>
                                </div>
                                <div class="col-md-6">
                                    <p><b>Semester:</b> <?php echo $semester; ?></p>
                                </div>
                                <div class="col-md-6">
                                    <p><b>Department:</b> <?php echo $department_name; ?></p>
                                </div>
                                <div class="col-md-6">
                                    <p><b>Program:</b> <?php echo $program_name; ?></p>
                                </div>
                                <div class="col-md-6">
                                    <p><b>Lecturers:</b> <?php
                                    if (!empty($lecturers)) {
                                        foreach ($lecturers as $lecturer) {
                                            echo '<span class="position-relative">' . $lecturer['lecturer_name'] . '<a href="?id=' . $module_id . '&lecturer_id=' . $lecturer['lecturer_id'] . '&remove" class="remove-btn"><i class="fa fa-minus"></i></a></span>' . ', ';
                                        }
                                    } else {
                                        echo '<span class="text-danger fw-medium">No lecturers yet!</span>';
                                    }
                                    ?>
                                    </p>
                                </div>
                                <div class="col-md-6">
                                    <p><b>Students:</b> <?php
                                    if (!empty($students)) {
                                        foreach ($students as $student) {
                                            echo '<span class="position-relative">' . $student['student_name'] . '<a href="?id=' . $module_id . '&student_id=' . $student['student_id'] . '&remove" class="remove-btn"><i class="fa fa-minus"></i></a></span>' . ', ';
                                        }
                                    } else {
                                        echo '<span class="text-danger fw-medium">No students yet!</span>';
                                    }
                                    ?>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </main>
            </div>
        </div>
        <!-- Modal -->
        <div class="modal fade" id="assignStudentsModal" tabindex="-1" aria-labelledby="assignStudentsModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="assignStudentsModalLabel">Assign Students to Module</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form method="POST" action="">
                            <input type="hidden" name="module_id" value="<?php echo $_GET['id']; ?>">
                            <div class="mb-3">
                                <label for="students" class="form-label">Select Students:</label>
                                <select class="form-select multi-select" id="students" name="students[]" multiple
                                    required>
                                    <?php
                                    // Fetch and populate students from the database
                                    $students = getAllStudents(); // Assuming you have a function to fetch students
                                    if ($students) {
                                        foreach ($students as $student) {
                                            echo '<option value="' . $student['student_id'] . '">' . $student['student_name'] . '</option>';
                                        }
                                    }
                                    ?>
                                </select>
                            </div>
                            <button type="submit" class="btn btn-primary">Assign Students</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="assignLecturersModal" tabindex="-1" aria-labelledby="assignLecturersModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="assignLecturersModalLabel">Assign Lecturers to Module</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form method="POST" action="">
                            <input type="hidden" name="module_id" value="<?php echo $_GET['id']; ?>">
                            <div class="mb-3">
                                <label for="lecturers" class="form-label">Select Lecturers:</label>
                                <select class="form-select multi-select" id="lecturers" name="lecturers[]" multiple
                                    required>
                                    <?php
                                    // Fetch and populate lecturers from the database
                                    $lecturers = getAllLecturers(); // Assuming you have a function to fetch lecturers
                                    if ($lecturers) {
                                        foreach ($lecturers as $lecturer) {
                                            echo '<option value="' . $lecturer['lecturer_id'] . '">' . $lecturer['lecturer_name'] . '</option>';
                                        }
                                    }
                                    ?>
                                </select>
                            </div>
                            <button type="submit" class="btn btn-primary">Assign Lecturers</button>
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