<?php
require 'functions.php';
if(!isAdmin()){
    header('Location: timetables.php');
    exit();
}
// Initialize info variable
$info = '';

// Handle program update
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update_program'])) {
    $programId = $_POST['programId'];
    $programName = $_POST['programName'];
    $departmentId = $_POST['departmentId'];
    // Check if program with the given ID exists
    $program = getProgramById($programId);
    if ($program) {
        // Update program
        $data = array(
            'program_name' => $programName,
            'department_id' => $departmentId
        );
        $check = updateProgram($data, $programId);
        if ($check) {
            // Program updated successfully
            $info = '<div class="alert alert-success alert-dismissible fade show" role="alert">
                        Program updated successfully.
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
        // Program not found
        $info = '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                    Program not found.
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>';
    }
}

// Fetch program details by ID if ID is provided in URL parameter
if (isset($_GET['id'])) {
    $programId = $_GET['id'];
    // Fetch program details by ID
    $program = getProgramById($programId);
    if (!$program) {
        // Program not found, redirect to programs page
        header('Location: programs.php');
        exit;
    }
} else {
    // Redirect to programs page if ID is not provided
    header('Location: programs.php');
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
                        <h1 class="h2">Programs</h1>
                        <!-- Button trigger modal -->
                    </div>
                    <?php echo $info; ?>
                    <div class="card shadow">
                        <div class="card-body">
                            <?php
                            // Check if program is not found
                            if (!$program) {
                                // Program not found, handle error
                                echo '<div class="alert alert-danger">Program not found</div>';
                            } else {
                                ?>
                                <form method="POST" action="?id=<?php echo $programId; ?>">
                                    <input type="hidden" name="programId" value="<?php echo $program['program_id']; ?>">
                                    <div class="mb-3">
                                        <label for="programName" class="form-label">Program Name:</label>
                                        <input type="text" class="form-control" id="programName" name="programName"
                                            value="<?php echo $program['program_name']; ?>" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="departmentId" class="form-label">Department:</label>
                                        <select class="form-select" id="departmentId" name="departmentId" required>
                                            <!-- Fetch departments from database and populate options -->
                                            <?php
                                            $departments = getAllDepartments(); // Assuming you have a function to fetch departments
                                            if ($departments) {
                                                foreach ($departments as $department) {
                                                    // Check if current department is selected
                                                    $selected = ($department['department_id'] == $program['department_id']) ? 'selected' : '';
                                                    echo '<option value="' . $department['department_id'] . '" ' . $selected . '>' . $department['department_name'] . '</option>';
                                                }
                                            }
                                            ?>
                                        </select>
                                    </div>
                                    <button type="submit" name="update_program" class="btn btn-primary">Update
                                        Program</button>
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