<?php
require 'functions.php';
if(!isLoggedIn()){
    header('Location: login.php');
    exit();
}
// Handle form submission
$info = '';
if (isset($_GET['delete']) && (isAdmin() || isLecturer())) {
    try {
        if (getTimetableById($_GET['delete'])) {
            $check = deleteTimetableById($_GET['delete']);
            if ($check) {
                $info = '<div class="alert alert-success alert-dismissible fade show" role="alert">
                    Timetable deleted successfully.
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

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST" && (isAdmin() || isLecturer())) {
    // Extract form data
    $module_id = $_POST['module_id'];
    $room_id = $_POST['room_id'];
    $day = $_POST['day'];
    $start_time = $_POST['start_time'];
    $end_time = $_POST['end_time'];

    // Check if start time and end time are within the allowed range (9:00 - 17:00)
    if (($start_time >= '09:00' && $start_time <= '17:00') && ($end_time >= '09:00' && $end_time <= '17:00')) {
        // Check if end time is greater than start time
        if ($end_time > $start_time) {
            // Check if the module is not already added to the same room
            if (!isModuleAlreadyAdded($module_id, $room_id)) {
                // Insert into timetables table
                $data = array(
                    'module_id' => $module_id,
                    'room_id' => $room_id,
                    'day' => $day,
                    'start_time' => $start_time,
                    'end_time' => $end_time,
                    'createdAt' => date('Y-m-d H:i:s')
                );

                // Perform the insertion
                $result = addTimetable($data);

                // Check if insertion was successful
                if ($result) {
                    // Timetable added successfully
                    $info = '<div class="alert alert-success alert-dismissible fade show" role="alert">
                                Timetable added successfully.
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                              </div>';
                } else {
                    // Error occurred during insertion
                    $info = '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                                An error occurred.
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                              </div>';
                }
            } else {
                // Module is already added to the same room
                $info = '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                            This module is already added to the same room.
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                          </div>';
            }
        } else {
            // End time is not greater than start time
            $info = '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                        End time should be greater than start time.
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                      </div>';
        }
    } else {
        // Start time or end time is not within the allowed range
        $info = '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                    Start and end times should be between 9:00 AM and 5:00 PM.
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
                        <h1 class="h2">Timetables</h1>
                        <!-- Button trigger modal -->
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                            data-bs-target="#addTimetableModal"> Add Timetable </button>
                    </div>
                    <?php echo $info; ?>
                    <div class="card shadow">
                        <div class="card-body">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Module Name - Semester</th>
                                        <th>Room</th>
                                        <th>Day</th>
                                        <th>Start Time</th>
                                        <th>End Time</th>
                                        <?php
                                        if (isAdmin() || isLecturer()) {
                                            echo "
                                            <th>Action</th>";
                                        }
                                        ?>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $timetables = [];
                                        // print_r($_SESSION);
                                    if (isAdmin()) {
                                        // echo 'aa1';
                                        // If user is admin, get all timetables
                                        $timetables = getAllTimetables();
                                    } elseif (isLecturer()) {
                                        // echo 'aa2';
                                        // If user is a lecturer, get timetables of modules assigned to the lecturer
                                        $lecturer_id = $_SESSION['user_id']; // Assuming you have a function to get current user ID
                                        $timetables = getTimetablesByLecturerId($lecturer_id); // Assuming you have a function to get timetables by lecturer ID
                                    } elseif (isStudent()) {
                                        // echo 'aa3';
                                        // If user is a student, get timetables of modules assigned to the student
                                        $student_id = $_SESSION['user_id']; // Assuming you have a function to get current user ID
                                        $timetables = getTimetablesByStudentId($student_id); // Assuming you have a function to get timetables by student ID
                                    }

                                    if ($timetables) {
                                        foreach ($timetables as $timetable) {
                                            $module_id = $timetable['module_id'];
                                            $module = getModuleById($module_id);
                                            $room_id = $timetable['room_id'];
                                            $room = getRoomById($room_id);
                                            echo "<tr>";
                                            echo "<td>" . $timetable['timetable_id'] . "</td>";
                                            echo "<td>" . $module['module_name'] . " - Sem. " . $module['semester'] . "</td>";
                                            echo "<td>" . $room['room_name'] . " - " . $room['room_type'] . " - Cap. : " . $room['capacity'] . "</td>";
                                            echo "<td>" . $timetable['day'] . "</td>";
                                            echo "<td>" . $timetable['start_time'] . "</td>";
                                            echo "<td>" . $timetable['end_time'] . "</td>";
                                            // Action buttons based on user role
                                            if (isAdmin() || isLecturer()) {
                                                echo "<td>
                                                    <a href='edit_timetable.php?id=" . $timetable['timetable_id'] . "' class='btn btn-primary btn-sm'><i class='fa fa-edit'></i></a>
                                                    <a onclick='return confirm(\"Do you really want to delete?\")' href='?delete=" . $timetable['timetable_id'] . "' class='btn btn-danger btn-sm'><i class='fa fa-trash'></i></a>
                                                </td>";
                                            }
                                            echo "</tr>";
                                        }
                                    } else {
                                        echo "<tr><td colspan='6'>No timetables found</td></tr>";
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
        <!-- Modal -->
        <div class="modal fade" id="addTimetableModal" tabindex="-1" aria-labelledby="addTimetableModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addTimetableModalLabel">Add Timetable</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form method="POST" action="">
                            <div class="mb-3">
                                <label for="moduleSelect" class="form-label">Module:</label>
                                <select class="form-select" id="moduleSelect" name="module_id" required>
                                    <option value="">Select module...</option>
                                    <?php
                                    // Populate modules select box
                                    $modules = getAllModules();
                                    if ($modules) {
                                        foreach ($modules as $module) {
                                            echo '<option value="' . $module['module_id'] . '">' . $module['module_name'] . '</option>';
                                        }
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="roomSelect" class="form-label">Room:</label>
                                <select class="form-select" id="roomSelect" name="room_id" required>
                                    <option value="">Select room...</option>
                                    <?php
                                    // Populate rooms select box
                                    $rooms = getAllRooms();
                                    if ($rooms) {
                                        foreach ($rooms as $room) {
                                            echo '<option value="' . $room['room_id'] . '">' . $room['room_name'] . ' - ' . $room['room_type'] . ' - Capacity: ' . $room['capacity'] . '</option>';
                                        }
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="daySelect" class="form-label">Day:</label>
                                <select class="form-select" id="daySelect" name="day" required>
                                    <option value="">Select day...</option>
                                    <option value="Monday">Monday</option>
                                    <option value="Tuesday">Tuesday</option>
                                    <option value="Wednesday">Wednesday</option>
                                    <option value="Thursday">Thursday</option>
                                    <option value="Friday">Friday</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="startTimeSelect" class="form-label">Start Time:</label>
                                <select class="form-select" id="startTimeSelect" name="start_time" required>
                                    <option value="">Select start time...</option>
                                    <?php
                                    // Generate options for start times
                                    for ($i = 9; $i <= 16; $i++) {
                                        echo '<option value="' . sprintf("%02d", $i) . ':00">' . sprintf("%02d", $i) . ':00</option>';
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="endTimeSelect" class="form-label">End Time:</label>
                                <select class="form-select" id="endTimeSelect" name="end_time" required>
                                    <option value="">Select end time...</option>
                                    <?php
                                    // Generate options for end times
                                    for ($i = 10; $i <= 17; $i++) {
                                        echo '<option value="' . sprintf("%02d", $i) . ':00">' . sprintf("%02d", $i) . ':00</option>';
                                    }
                                    ?>
                                </select>
                            </div>
                            <button type="submit" class="btn btn-primary">Add Timetable</button>
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