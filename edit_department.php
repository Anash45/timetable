<?php
require 'functions.php';
if(!isAdmin()){
    header('Location: timetables.php');
    exit();
}
// Handle form submission
$info = '';
if (isset($_GET['id'])) {
    $departmentId = $_GET['id'];
    // Fetch department details by ID
    $department = getDepartmentById($departmentId);
} else {
    header('Location:departments.php');
}
// Handle department update
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update_department'])) {
    $departmentId = $_POST['departmentId'];
    $departmentName = $_POST['departmentName'];
    // Check if department with the given ID exists
    $department = getDepartmentById($departmentId);
    if ($department) {
        // Update department
        $data = array('department_name' => $departmentName);
        $check = updateDepartment($data, $departmentId);
        if ($check) {
            // Department updated successfully
            $info = '<div class="alert alert-success alert-dismissible fade show" role="alert">
                        Department updated successfully.
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>';
        } else {
            // Error occurred during update
            $info = '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                        An error occurred.
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>';
        }
    } else {
        // Department not found
        $info = '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                    Department not found.
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>';
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
                    </div>
                    <?php echo $info; ?>
                    <div class="card shadow">
                        <div class="card-body">
                            <?php
                            // Get department ID from URL parameter
                            if (!$department) {
                                // Department not found, handle error
                                echo '<div class="alert alert-danger">Department not found</div>';
                            } else {
                                ?>
                                <form method="POST" action="?id=<?php echo $departmentId; ?>">
                                    <input type="hidden" name="departmentId"
                                        value="<?php echo $department['department_id']; ?>">
                                    <div class="mb-3">
                                        <label for="departmentName" class="form-label">Department Name:</label>
                                        <input type="text" class="form-control" id="departmentName" name="departmentName"
                                            value="<?php echo $department['department_name']; ?>" required>
                                    </div>
                                    <button type="submit" name="update_department" class="btn btn-primary">Update
                                        Department</button>
                                </form>
                                <?php
                            }
                            ?>
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