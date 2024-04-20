<?php
require 'functions.php';
if(!isAdmin()){
    header('Location: timetables.php');
    exit();
}
// Initialize info variable
$info = '';

// Handle student deletion
if (isset($_GET['delete'])) {
    try {
        if (getStudentById($_GET['delete'])) {
            $check = deleteStudentById($_GET['delete']);
            if ($check) {
                $info = '<div class="alert alert-success alert-dismissible fade show" role="alert">
                        Student deleted successfully.
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

// Handle form submission for adding a student
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['studentName'], $_POST['studentEmail'], $_POST['studentPassword'])) {
        $studentName = $_POST['studentName'];
        $email = $_POST['studentEmail'];
        $password = $_POST['studentPassword'];

        // Check if email already exists
        if (getStudentByEmail($email)) {
            $info = '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                        Email already exists.
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>';
        } else {
            // Hash the password
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

            // Add student
            $data = array(
                'student_name' => $studentName,
                'email' => $email,
                'password' => $hashedPassword
            );
            $result = addStudent($data);

            // Display error or success message in Bootstrap alert
            if ($result) {
                $info = '<div class="alert alert-success alert-dismissible fade show" role="alert">
                            Student added successfully.
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
                        <h1 class="h2">Students</h1>
                        <!-- Button trigger modal -->
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                            data-bs-target="#addStudentModal"> Add Student </button>
                    </div>
                    <?php echo $info; ?>
                    <div class="card shadow">
                        <div class="card-body">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $students = getAllStudents(); // Assuming you have a function to fetch students
                                    if ($students) {
                                        foreach ($students as $student) {
                                            echo "<tr>";
                                            echo "<td>" . $student['student_id'] . "</td>";
                                            echo "<td>" . $student['student_name'] . "</td>";
                                            echo "<td>" . $student['email'] . "</td>";
                                            echo "<td>
                                            <a href='edit_student.php?id=" . $student['student_id'] . "' class='btn btn-primary btn-sm'><i class='fa fa-edit'></i></a>
                                            <a onclick='return confirm(\"Do you really want to delete?\")' href='?delete=" . $student['student_id'] . "' class='btn btn-danger btn-sm'><i class='fa fa-trash'></i></a>
                            </td>";
                                            echo "</tr>";
                                        }
                                    } else {
                                        echo "<tr><td colspan='4'>No students found</td></tr>";
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
        <div class="modal fade" id="addStudentModal" tabindex="-1" aria-labelledby="addStudentModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addStudentModalLabel">Add Student</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form method="POST">
                            <div class="mb-3">
                                <label for="studentName" class="form-label">Student Name:</label>
                                <input type="text" class="form-control" id="studentName" name="studentName" required>
                            </div>
                            <div class="mb-3">
                                <label for="studentEmail" class="form-label">Email:</label>
                                <input type="email" class="form-control" id="studentEmail" name="studentEmail" required>
                            </div>
                            <div class="mb-3">
                                <label for="studentPassword" class="form-label">Password:</label>
                                <input type="password" class="form-control" id="studentPassword" name="studentPassword"
                                    required>
                            </div>
                            <button type="submit" class="btn btn-primary">Add Student</button>
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