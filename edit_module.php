<?php
require 'functions.php';
if(!isAdmin()){
    header('Location: timetables.php');
    exit();
}
// Initialize info variable
$info = '';

// Handle module update
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update_module'])) {
    $moduleId = $_POST['moduleId'];
    $moduleName = $_POST['moduleName'];
    $programId = $_POST['programId'];
    $semester = $_POST['semester'];
    // Check if module with the given ID exists
    $module = getModuleById($moduleId);
    if ($module) {
        // Update module
        $data = array(
            'module_name' => $moduleName,
            'program_id' => $programId,
            'semester' => $semester
        );
        $check = updateModule($data, $moduleId);
        if ($check) {
            // Module updated successfully
            $info = '<div class="alert alert-success alert-dismissible fade show" role="alert">
                        Module updated successfully.
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
        // Module not found
        $info = '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                    Module not found.
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>';
    }
}

// Fetch module details by ID if ID is provided in URL parameter
if (isset($_GET['id'])) {
    $moduleId = $_GET['id'];
    // Fetch module details by ID
    $module = getModuleById($moduleId);
    if (!$module) {
        // Module not found, redirect to modules page
        header('Location: modules.php');
        exit;
    }
} else {
    // Redirect to modules page if ID is not provided
    header('Location: modules.php');
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
                        <h1 class="h2">Modules</h1>
                        <!-- Button trigger modal -->
                    </div>
                    <?php echo $info; ?>
                    <div class="card shadow">
                        <div class="card-body">
                            <?php
                            // Check if module is not found
                            if (!$module) {
                                // Module not found, handle error
                                echo '<div class="alert alert-danger">Module not found</div>';
                            } else {
                                ?>
                                <form method="POST" action="?id=<?php echo $moduleId; ?>">
                                    <input type="hidden" name="moduleId" value="<?php echo $module['module_id']; ?>">
                                    <div class="mb-3">
                                        <label for="moduleName" class="form-label">Module Name:</label>
                                        <input type="text" class="form-control" id="moduleName" name="moduleName"
                                            value="<?php echo $module['module_name']; ?>" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="programId" class="form-label">Program:</label>
                                        <select class="form-select" id="programId" name="programId" required>
                                            <!-- Fetch programs from database and populate options -->
                                            <?php
                                            $programs = getAllPrograms(); // Assuming you have a function to fetch programs
                                            if ($programs) {
                                                foreach ($programs as $program) {
                                                    // Check if current program is selected
                                                    $selected = ($program['program_id'] == $module['program_id']) ? 'selected' : '';
                                                    echo '<option value="' . $program['program_id'] . '" ' . $selected . '>' . $program['program_name'] . '</option>';
                                                }
                                            }
                                            ?>
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label for="semester" class="form-label">Semester:</label>
                                        <input type="text" class="form-control" id="semester" name="semester"
                                            value="<?php echo $module['semester']; ?>" required>
                                    </div>
                                    <button type="submit" name="update_module" class="btn btn-primary">Update
                                        Module</button>
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