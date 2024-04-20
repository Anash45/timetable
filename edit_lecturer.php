<?php
require 'functions.php';
if(!isAdmin()){
    header('Location: timetables.php');
    exit();
}
// Initialize info variable
$info = '';

// Handle lecturer update
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update_lecturer'])) {
    $lecturerId = $_POST['lecturerId'];
    $lecturerName = $_POST['lecturerName'];
    $lecturerEmail = $_POST['lecturerEmail'];
    $password = $_POST['lecturerPassword'];

    // Check if lecturer with the given ID exists
    $lecturer = getLecturerById($lecturerId);
    if ($lecturer) {
        // Update lecturer
        $data = array(
            'lecturer_name' => $lecturerName,
            'email' => $lecturerEmail
        );

        // Check if password is not empty, then update
        if (!empty($password)) {
            $data['password'] = $password;
        }

        $currentUser = getLecturerByEmail($lecturerEmail);

        if ($currentUser && $currentUser['lecturer_id'] != $lecturerId) {
            // Error occurred during update
            $info = '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                    Email is already registered.
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>';
        } else {
            $check = updateLecturer($data, $lecturerId);
            if ($check) {
                // Lecturer updated successfully
                $info = '<div class="alert alert-success alert-dismissible fade show" role="alert">
                        Lecturer updated successfully.
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
        // Lecturer not found
        $info = '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                    Lecturer not found.
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>';
    }
}

// Fetch lecturer details by ID if ID is provided in URL parameter
if (isset($_GET['id'])) {
    $lecturerId = $_GET['id'];
    // Fetch lecturer details by ID
    $lecturer = getLecturerById($lecturerId);
    if (!$lecturer) {
        // Lecturer not found, redirect to lecturers page
        header('Location: lecturers.php');
        exit;
    }
} else {
    // Redirect to lecturers page if ID is not provided
    header('Location: lecturers.php');
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
                        <h1 class="h2">Edit Lecturer</h1>
                    </div>
                    <?php echo $info; ?>
                    <div class="card shadow">
                        <div class="card-body">
                            <?php
                            // Check if lecturer is not found
                            if (!$lecturer) {
                                // lecturer not found, handle error
                                echo '<div class="alert alert-danger">Lecturer not found</div>';
                            } else {
                                ?>
                                <form method="POST" action="?id=<?php echo $lecturerId; ?>">
                                    <input type="hidden" name="lecturerId" value="<?php echo $lecturer['lecturer_id']; ?>">
                                    <div class="mb-3">
                                        <label for="lecturerName" class="form-label">lecturer Name:</label>
                                        <input type="text" class="form-control" id="lecturerName" name="lecturerName"
                                            value="<?php echo $lecturer['lecturer_name']; ?>" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="lecturerEmail" class="form-label">lecturer Email:</label>
                                        <input type="email" class="form-control" id="lecturerEmail" name="lecturerEmail"
                                            value="<?php echo $lecturer['email']; ?>" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="lecturerPassword" class="form-label">Password:</label>
                                        <input type="password" class="form-control" id="lecturerPassword"
                                            name="lecturerPassword">
                                    </div>
                                    <button type="submit" name="update_lecturer" class="btn btn-primary">Update
                                        Lecturer</button>
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