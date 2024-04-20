<?php
require 'functions.php';
if(!isAdmin() && !isLecturer()){
    header('Location: timetables.php');
    exit();
}
// Initialize info variable
$info = '';

// Handle timetable update
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update_timetable'])) {
    $timetableId = $_POST['timetableId'];
    $moduleId = $_POST['moduleId'];
    $roomId = $_POST['roomId'];
    $day = $_POST['day'];
    $startTime = $_POST['startTime'];
    $endTime = $_POST['endTime'];

    // Check if end time is greater than start time
    if ($endTime <= $startTime) {
        $info = '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                    End time must be greater than start time.
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>';
    } else {
        // Check if start and end times are between 9:00 - 17:00
        if ($startTime < '09:00' || $endTime > '17:00') {
            $info = '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                        Start and end times must be between 9:00 and 17:00.
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>';
        } else {
            // Check if the module is already added to the same room
            $currentTimetable = isModuleAlreadyAdded($moduleId, $roomId);
            if ($currentTimetable && $currentTimetable['timetable_id'] != $timetableId) {
                $info = '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                            This module is already added to the same room.
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>';
            } else {
                // Update timetable
                $data = array(
                    'module_id' => $moduleId,
                    'room_id' => $roomId,
                    'day' => $day,
                    'start_time' => $startTime,
                    'end_time' => $endTime
                );
                $check = updateTimetable($data, $timetableId);
                if ($check) {
                    // Timetable updated successfully
                    $info = '<div class="alert alert-success alert-dismissible fade show" role="alert">
                                Timetable updated successfully.
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
        }
    }
}

// Fetch timetable details by ID if ID is provided in URL parameter
if (isset($_GET['id'])) {
    $timetableId = $_GET['id'];
    // Fetch timetable details by ID
    $timetable = getTimetableById($timetableId);
    if (!$timetable) {
        // Timetable not found, redirect to timetables page
        header('Location: timetables.php');
        exit;
    }
} else {
    // Redirect to timetables page if ID is not provided
    header('Location: timetables.php');
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
                        <h1 class="h2">Edit Timetable</h1>
                    </div>
                    <?php echo $info; ?>
                    <div class="card shadow">
                        <div class="card-body">
                            <?php
                            // Check if timetable is not found
                            if (!$timetable) {
                                // Timetable not found, handle error
                                echo '<div class="alert alert-danger">Timetable not found</div>';
                            } else {
                                ?>
                                <form method="POST" action="?id=<?php echo $timetableId; ?>">
                                    <input type="hidden" name="timetableId"
                                        value="<?php echo $timetable['timetable_id']; ?>">
                                    <div class="mb-3">
                                        <label for="moduleId" class="form-label">Module:</label>
                                        <select class="form-select" id="moduleId" name="moduleId" required>
                                            <!-- Fetch modules from database and populate options -->
                                            <?php
                                            $modules = getAllModules(); // Assuming you have a function to fetch modules
                                            if ($modules) {
                                                foreach ($modules as $module) {
                                                    // Check if current module is selected
                                                    $selected = ($module['module_id'] == $timetable['module_id']) ? 'selected' : '';
                                                    echo '<option value="' . $module['module_id'] . '" ' . $selected . '>' . $module['module_name'] . ' - Semester ' . $module['semester'] . '</option>';
                                                }
                                            }
                                            ?>
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label for="roomId" class="form-label">Room:</label>
                                        <select class="form-select" id="roomId" name="roomId" required>
                                            <!-- Fetch rooms from database and populate options -->
                                            <?php
                                            $rooms = getAllRooms(); // Assuming you have a function to fetch rooms
                                            if ($rooms) {
                                                foreach ($rooms as $room) {
                                                    // Check if current room is selected
                                                    $selected = ($room['room_id'] == $timetable['room_id']) ? 'selected' : '';
                                                    echo '<option value="' . $room['room_id'] . '" ' . $selected . '>' . $room['room_name'] . ' - ' . $room['room_type'] . ' - Capacity: ' . $room['capacity'] . '</option>';
                                                }
                                            }
                                            ?>
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label for="day" class="form-label">Day:</label>
                                        <select class="form-select" id="day" name="day" required>
                                            <option value="Monday" <?php if ($timetable['day'] == 'Monday')
                                                echo 'selected'; ?>>Monday</option>
                                            <option value="Tuesday" <?php if ($timetable['day'] == 'Tuesday')
                                                echo 'selected'; ?>>Tuesday</option>
                                            <option value="Wednesday" <?php if ($timetable['day'] == 'Wednesday')
                                                echo 'selected'; ?>>Wednesday</option>
                                            <option value="Thursday" <?php if ($timetable['day'] == 'Thursday')
                                                echo 'selected'; ?>>Thursday</option>
                                            <option value="Friday" <?php if ($timetable['day'] == 'Friday')
                                                echo 'selected'; ?>>Friday</option>
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label for="startTime" class="form-label">Start Time:</label>
                                        <select class="form-select" id="startTime" name="startTime" required>
                                            <option value="">Select start time...</option>
                                            <?php
                                            // Generate options for start times
                                            for ($i = 9; $i <= 16; $i++) {
                                                $selected2 = (sprintf("%02d", $i) . ':00:00' == $timetable['start_time']) ? 'selected' : '';
                                                echo '<option '.$selected2.' value="' . sprintf("%02d", $i) . ':00">' . sprintf("%02d", $i) . ':00</option>';
                                            }
                                            ?>
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label for="endTime" class="form-label">End Time:</label>
                                        <select class="form-select" id="endTime" name="endTime" required>
                                            <option value="">Select end time...</option>
                                            <?php
                                            // Generate options for end times
                                            for ($i = 9; $i <= 16; $i++) {
                                                // echo $timetable['end_time'];
                                                $selected1 = (sprintf("%02d", $i) . ':00:00' == $timetable['end_time']) ? 'selected' : '';
                                                echo '<option value="' . sprintf("%02d", $i) . ':00" '.$selected1.'>' . sprintf("%02d", $i) . ':00</option>';
                                            }
                                            ?>
                                        </select>
                                    </div>
                                    <button type="submit" name="update_timetable" class="btn btn-primary">Update
                                        Timetable</button>
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