<?php
require 'functions.php';
if(!isAdmin()){
    header('Location: timetables.php');
    exit();
}
// Initialize info variable
$info = '';

// Handle student update
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update_student'])) {
    $studentId = $_POST['studentId'];
    $studentName = $_POST['studentName'];
    $studentEmail = $_POST['studentEmail'];
    $password = $_POST['studentPassword'];

    // Check if student with the given ID exists
    $student = getStudentById($studentId);
    if ($student) {
        // Update student
        $data = array(
            'student_name' => $studentName,
            'email' => $studentEmail
        );

        // Check if password is not empty, then update
        if (!empty($password)) {
            $data['password'] = $password;
        }

        $currentUser = getStudentByEmail($studentEmail);

        if ($currentUser && $currentUser['student_id'] != $studentId) {
            // Error occurred during update
            $info = '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                    Email is already registered.
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>';
        }else{
            $check = updateStudent($data, $studentId);
            if ($check) {
                // Student updated successfully
                $info = '<div class="alert alert-success alert-dismissible fade show" role="alert">
                        Student updated successfully.
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>';
            } else {
                // Error occurred during update
                $info = '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                        An error occurred.
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>';
            }
        }
    } else {
        // Student not found
        $info = '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                    Student not found.
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>';
    }
}

// Fetch student details by ID if ID is provided in URL parameter
if (isset($_GET['id'])) {
    $studentId = $_GET['id'];
    // Fetch student details by ID
    $student = getStudentById($studentId);
    if (!$student) {
        // Student not found, redirect to students page
        header('Location: students.php');
        exit;
    }
} else {
    // Redirect to students page if ID is not provided
    header('Location: students.php');
    exit;
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
                        <h1 class="h2">Edit Student</h1>
                    </div>
                    <?php echo $info; ?>
                    <div class="card shadow">
                        <div class="card-body">
                            <?php
                            // Check if student is not found
                            if (!$student) {
                                // Student not found, handle error
                                echo '<div class="alert alert-danger">Student not found</div>';
                            } else {
                                ?>
                                <form method="POST" action="?id=<?php echo $studentId; ?>">
                                    <input type="hidden" name="studentId" value="<?php echo $student['student_id']; ?>">
                                    <div class="mb-3">
                                        <label for="studentName" class="form-label">Student Name:</label>
                                        <input type="text" class="form-control" id="studentName" name="studentName"
                                            value="<?php echo $student['student_name']; ?>" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="studentEmail" class="form-label">Student Email:</label>
                                        <input type="email" class="form-control" id="studentEmail" name="studentEmail"
                                            value="<?php echo $student['email']; ?>" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="studentPassword" class="form-label">Password:</label>
                                        <input type="password" class="form-control" id="studentPassword"
                                            name="studentPassword">
                                    </div>
                                    <button type="submit" name="update_student" class="btn btn-primary">Update
                                        Student</button>
                                </form>
                            <?php } ?>
                        </div>
                    </div>
                </main>
            </div>
        </div>
        <script src="./assets/js/jquery-3.6.1.min.js"></script>
        <script src="./assets/js/bootstrap.bundle.min.js"></script>
        <script src="./assets/js/script.js"></script>
    </body>

</html>