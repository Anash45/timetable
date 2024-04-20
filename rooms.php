<?php
require 'functions.php';
if(!isAdmin()){
    header('Location: timetables.php');
    exit();
}
// Handle form submission
$info = '';
if (isset($_GET['delete'])) {
    try {
        if (getRoomById($_GET['delete'])) {
            $check = deleteRoomById($_GET['delete']);
            if ($check) {
                $info = '<div class="alert alert-success alert-dismissible fade show" role="alert">
                    Room deleted successfully.
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
// Handle form submission for adding a room
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['roomName'], $_POST['capacity'], $_POST['roomType'])) {
        $roomName = $_POST['roomName'];
        $capacity = $_POST['capacity'];
        $roomType = $_POST['roomType'];

        // Check if room with the same name already exists
        $room = getRoomByName($roomName);
        if ($room && $roomType == $room['room_type']) {
            $info = '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                        Room already exists with this name and type.
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>';
        } else {
            // Add room
            $data = array(
                'room_name' => $roomName,
                'capacity' => $capacity,
                'room_type' => $roomType
            );
            $result = addRoom($data);

            // Display error or success message in Bootstrap alert
            if ($result) {
                $info = '<div class="alert alert-success alert-dismissible fade show" role="alert">
                            Room added successfully.
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
                        <h1 class="h2">Rooms</h1>
                        <!-- Button trigger modal -->
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                            data-bs-target="#addRoomModal"> Add Room </button>
                    </div>
                    <?php echo $info; ?>
                    <div class="card shadow">
                        <div class="card-body">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Name</th>
                                        <th>Capacity</th>
                                        <th>Type</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $rooms = getAllRooms(); // Assuming you have a function to fetch rooms
                                    if ($rooms) {
                                        foreach ($rooms as $room) {
                                            echo "<tr>";
                                            echo "<td>" . $room['room_id'] . "</td>";
                                            echo "<td>" . $room['room_name'] . "</td>";
                                            echo "<td>" . $room['capacity'] . "</td>";
                                            echo "<td>" . $room['room_type'] . "</td>";
                                            echo "<td>
                                            <a href='edit_room.php?id=" . $room['room_id'] . "' class='btn btn-primary btn-sm'><i class='fa fa-edit'></i></a>
                                            <a onclick='return confirm(\"Do you really want to delete?\")' href='?delete=" . $room['room_id'] . "' class='btn btn-danger btn-sm'><i class='fa fa-trash'></i></a>
                                        </td>";
                                            echo "</tr>";
                                        }
                                    } else {
                                        echo "<tr><td colspan='5'>No rooms found</td></tr>";
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
        <div class="modal fade" id="addRoomModal" tabindex="-1" aria-labelledby="addRoomModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addRoomModalLabel">Add Room</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form method="POST">
                            <div class="mb-3">
                                <label for="roomName" class="form-label">Room Name:</label>
                                <input type="text" class="form-control" id="roomName" name="roomName" required>
                            </div>
                            <div class="mb-3">
                                <label for="capacity" class="form-label">Capacity:</label>
                                <input type="number" class="form-control" id="capacity" name="capacity" required>
                            </div>
                            <div class="mb-3">
                                <label for="roomType" class="form-label">Room Type:</label>
                                <select class="form-select" id="roomType" name="roomType" required>
                                    <option value="">Select Room Type</option>
                                    <option value="Lecture Theatre">Lecture Theatre</option>
                                    <option value="Lab">Lab</option>
                                </select>
                            </div>
                            <button type="submit" class="btn btn-primary">Add Room</button>
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