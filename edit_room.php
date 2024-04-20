<?php
require 'functions.php';
if(!isAdmin()){
    header('Location: timetables.php');
    exit();
}
// Initialize info variable
$info = '';

// Handle room update
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update_room'])) {
    $roomId = $_POST['roomId'];
    $roomName = $_POST['roomName'];
    $capacity = $_POST['capacity'];
    $roomType = $_POST['roomType'];
    // Check if room with the given ID exists
    $room = getRoomById($roomId);
    if ($room) {
        // Update room
        $data = array(
            'room_name' => $roomName,
            'capacity' => $capacity,
            'room_type' => $roomType
        );
        $check = updateRoom($data, $roomId);
        if ($check) {
            // Room updated successfully
            $info = '<div class="alert alert-success alert-dismissible fade show" role="alert">
                        Room updated successfully.
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
        // Room not found
        $info = '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                    Room not found.
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>';
    }
}

// Fetch room details by ID if ID is provided in URL parameter
if (isset($_GET['id'])) {
    $roomId = $_GET['id'];
    // Fetch room details by ID
    $room = getRoomById($roomId);
    if (!$room) {
        // Room not found, redirect to rooms page
        header('Location: rooms.php');
        exit;
    }
} else {
    // Redirect to rooms page if ID is not provided
    header('Location: rooms.php');
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
                        <h1 class="h2">Rooms</h1>
                        <!-- Button trigger modal -->
                    </div>
                    <?php echo $info; ?>
                    <div class="card shadow">
                        <div class="card-body">
                            <?php
                            // Check if room is not found
                            if (!$room) {
                                // Room not found, handle error
                                echo '<div class="alert alert-danger">Room not found</div>';
                            } else {
                                ?>
                                <form method="POST" action="?id=<?php echo $roomId; ?>">
                                    <input type="hidden" name="roomId" value="<?php echo $room['room_id']; ?>">
                                    <div class="mb-3">
                                        <label for="roomName" class="form-label">Room Name:</label>
                                        <input type="text" class="form-control" id="roomName" name="roomName"
                                            value="<?php echo $room['room_name']; ?>" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="capacity" class="form-label">Capacity:</label>
                                        <input type="number" class="form-control" id="capacity" name="capacity"
                                            value="<?php echo $room['capacity']; ?>" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="roomType" class="form-label">Room Type:</label>
                                        <select class="form-select" id="roomType" name="roomType" required>
                                            <option value="">Select Room Type</option>
                                            <option value="Lecture Theatre" <?php if ($room['room_type'] == 'Lecture Theatre')
                                                echo 'selected'; ?>>Lecture Theatre</option>
                                            <option value="Lab" <?php if ($room['room_type'] == 'Lab')
                                                echo 'selected'; ?>>Lab
                                            </option>
                                        </select>
                                    </div>
                                    <button type="submit" name="update_room" class="btn btn-primary">Update Room</button>
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