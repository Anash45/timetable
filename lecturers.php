<?php
require 'functions.php';

// Initialize info variable
$info = '';
if(!isAdmin()){
    header('Location: timetables.php');
    exit();
}
// Handle lecturer deletion
if (isset($_GET['delete'])) {
    try {
        if (getLecturerById($_GET['delete'])) {
            $check = deleteLecturerById($_GET['delete']);
            if ($check) {
                $info = '<div class="alert alert-success alert-dismissible fade show" role="alert">
                        Lecturer deleted successfully.
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

// Handle form submission for adding a lecturer
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['lecturerName'], $_POST['lecturerEmail'], $_POST['lecturerPassword'])) {
        $lecturerName = $_POST['lecturerName'];
        $email = $_POST['lecturerEmail'];
        $password = $_POST['lecturerPassword'];

        // Check if email already exists
        if (getLecturerByEmail($email)) {
            $info = '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                        Email already exists.
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>';
        } else {
            // Hash the password
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

            // Add lecturer
            $data = array(
                'lecturer_name' => $lecturerName,
                'email' => $email,
                'password' => $hashedPassword
            );
            $result = addLecturer($data);

            // Display error or success message in Bootstrap alert
            if ($result) {
                $info = '<div class="alert alert-success alert-dismissible fade show" role="alert">
                            Lecturer added successfully.
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
                        <h1 class="h2">Lecturers</h1>
                        <!-- Button trigger modal -->
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                            data-bs-target="#addLecturerModal"> Add Lecturer </button>
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
                                    $lecturers = getAllLecturers(); // Assuming you have a function to fetch lecturers
                                    if ($lecturers) {
                                        foreach ($lecturers as $lecturer) {
                                            echo "<tr>";
                                            echo "<td>" . $lecturer['lecturer_id'] . "</td>";
                                            echo "<td>" . $lecturer['lecturer_name'] . "</td>";
                                            echo "<td>" . $lecturer['email'] . "</td>";
                                            echo "<td>
                                            <a href='edit_lecturer.php?id=" . $lecturer['lecturer_id'] . "' class='btn btn-primary btn-sm'><i class='fa fa-edit'></i></a>
                                        <a onclick='return confirm(\"Do you really want to delete?\")' href='?delete=" . $lecturer['lecturer_id'] . "' class='btn btn-danger btn-sm'><i class='fa fa-trash'></i></a>
                                    </td>";
                                            echo "</tr>";
                                        }
                                    } else {
                                        echo "<tr><td colspan='4'>No lecturers found</td></tr>";
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
        <div class="modal fade" id="addLecturerModal" tabindex="-1" aria-labelledby="addLecturerModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addLecturerModalLabel">Add Lecturer</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form method="POST">
                            <div class="mb-3">
                                <label for="lecturerName" class="form-label">Lecturer Name:</label>
                                <input type="text" class="form-control" id="lecturerName" name="lecturerName" required>
                            </div>
                            <div class="mb-3">
                                <label for="lecturerEmail" class="form-label">Email:</label>
                                <input type="email" class="form-control" id="lecturerEmail" name="lecturerEmail"
                                    required>
                            </div>
                            <div class="mb-3">
                                <label for="lecturerPassword" class="form-label">Password:</label>
                                <input type="password" class="form-control" id="lecturerPassword"
                                    name="lecturerPassword" required>
                            </div>
                            <button type="submit" class="btn btn-primary">Add Lecturer</button>
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