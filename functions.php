<?php
session_start();
include 'db_conn.php';

// Function to get all departments
function getAllDepartments()
{
    global $conn;
    $sql = "SELECT * FROM departments";
    $result = $conn->query($sql);
    $departments = [];
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $departments[] = $row;
        }
    }
    return $departments;
}
// Function to get a department by name
function getDepartmentByName($departmentName)
{
    global $conn;
    // echo $departmentName;
    $escaped_departmentName = mysqli_real_escape_string($conn, $departmentName);
    $sql = "SELECT * FROM departments WHERE department_name = '$escaped_departmentName'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $department = $result->fetch_assoc();
        return $department;
    } else {
        return false;
    }
}

// Function to add a department
function addDepartment($data)
{
    global $conn;
    $columns = implode(", ", array_keys($data));
    $escaped_values = array_map(function ($value) use ($conn) {
        return "'" . mysqli_real_escape_string($conn, $value) . "'";
    }, $data);
    $values = implode(", ", $escaped_values);
    $sql = "INSERT INTO departments ($columns) VALUES ($values)";
    if ($conn->query($sql) === TRUE) {
        return true;
    } else {
        return false;
    }
}


// Function to update a department by ID
function updateDepartment($data, $department_id)
{
    global $conn;
    $updates = [];
    foreach ($data as $key => $value) {
        $updates[] = "$key = '$value'";
    }
    $updates_str = implode(", ", $updates);
    $sql = "UPDATE departments SET $updates_str WHERE department_id = $department_id";
    if ($conn->query($sql) === TRUE) {
        return true;
    } else {
        return false;
    }
}

// Function to delete a department by ID
function deleteDepartmentById($department_id)
{
    global $conn;
    $sql = "DELETE FROM departments WHERE department_id = $department_id";
    if ($conn->query($sql) === TRUE) {
        return true;
    } else {
        return false;
    }
}

// Function to get department by ID
function getDepartmentById($department_id)
{
    global $conn;
    $sql = "SELECT * FROM departments WHERE department_id = $department_id";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $department = $result->fetch_assoc();
        return $department;
    } else {
        return false;
    }
}


// Function to get all programs
function getAllPrograms()
{
    global $conn;
    $sql = "SELECT * FROM programs";
    $result = $conn->query($sql);
    $programs = [];
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $programs[] = $row;
        }
    }
    return $programs;
}

// Function to get a department by name
function getProgramByName($programName)
{
    global $conn;
    // echo $programName;
    $escaped_programName = mysqli_real_escape_string($conn, $programName);
    $sql = "SELECT * FROM programs WHERE program_name = '$escaped_programName'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $program = $result->fetch_assoc();
        return $program;
    } else {
        return false;
    }
}
// Function to add a program
function addProgram($data)
{
    global $conn;
    $columns = implode(", ", array_keys($data));
    $values = "'" . implode("', '", $data) . "'";
    $sql = "INSERT INTO programs ($columns) VALUES ($values)";
    if ($conn->query($sql) === TRUE) {
        return true;
    } else {
        return false;
    }
}

// Function to update a program by ID
function updateProgram($data, $program_id)
{
    global $conn;
    $updates = [];
    foreach ($data as $key => $value) {
        $updates[] = "$key = '$value'";
    }
    $updates_str = implode(", ", $updates);
    $sql = "UPDATE programs SET $updates_str WHERE program_id = $program_id";
    if ($conn->query($sql) === TRUE) {
        return true;
    } else {
        return false;
    }
}

// Function to delete a program by ID
function deleteProgramById($program_id)
{
    global $conn;
    $sql = "DELETE FROM programs WHERE program_id = $program_id";
    if ($conn->query($sql) === TRUE) {
        return true;
    } else {
        return false;
    }
}

// Function to get program by ID
function getProgramById($program_id)
{
    global $conn;
    $sql = "SELECT * FROM programs WHERE program_id = $program_id";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $program = $result->fetch_assoc();
        return $program;
    } else {
        return false;
    }
}

// Function to get a department by name
function getModuleByName($moduleName)
{
    global $conn;
    // echo $moduleName;
    $escaped_moduleName = mysqli_real_escape_string($conn, $moduleName);
    $sql = "SELECT * FROM modules WHERE module_name = '$escaped_moduleName'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $module = $result->fetch_assoc();
        return $module;
    } else {
        return false;
    }
}
// Function to add a module
function addModule($data)
{
    global $conn;
    $columns = implode(", ", array_keys($data));
    $values = "'" . implode("', '", $data) . "'";
    $sql = "INSERT INTO modules ($columns) VALUES ($values)";
    if ($conn->query($sql) === TRUE) {
        return true;
    } else {
        return false;
    }
}

// Function to update a module by ID
function updateModule($data, $module_id)
{
    global $conn;
    $updates = [];
    foreach ($data as $key => $value) {
        $updates[] = "$key = '$value'";
    }
    $updates_str = implode(", ", $updates);
    $sql = "UPDATE modules SET $updates_str WHERE module_id = $module_id";
    if ($conn->query($sql) === TRUE) {
        return true;
    } else {
        return false;
    }
}

// Function to delete a module by ID
function deleteModuleById($module_id)
{
    global $conn;
    $sql = "DELETE FROM modules WHERE module_id = $module_id";
    if ($conn->query($sql) === TRUE) {
        return true;
    } else {
        return false;
    }
}

// Function to get module by ID
function getModuleById($module_id)
{
    global $conn;
    $sql = "SELECT * FROM modules WHERE module_id = $module_id";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $module = $result->fetch_assoc();
        return $module;
    } else {
        return false;
    }
}

// Function to get all modules
function getAllModules()
{
    global $conn;
    $sql = "SELECT * FROM modules";
    $result = $conn->query($sql);
    $modules = [];
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $modules[] = $row;
        }
    }
    return $modules;
}

// Function to get modules by program ID
function getModulesByProgram($program_id)
{
    global $conn;
    $sql = "SELECT * FROM modules WHERE program_id = $program_id";
    $result = $conn->query($sql);
    $modules = [];
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $modules[] = $row;
        }
    }
    return $modules;
}
// Function to assign a lecturer to a module
function assignLecturerToModule($lecturer_id, $module_id)
{
    global $conn;
    $sql = "INSERT INTO modules_lecturers (module_id, lecturer_id) VALUES ($module_id, $lecturer_id)";
    if ($conn->query($sql) === TRUE) {
        return true;
    } else {
        return false;
    }
}

// Function to remove a lecturer from a module
function removeLecturerFromModule($lecturer_id, $module_id)
{
    global $conn;
    $sql = "DELETE FROM modules_lecturers WHERE module_id = $module_id AND lecturer_id = $lecturer_id";
    if ($conn->query($sql) === TRUE) {
        return true;
    } else {
        return false;
    }
}

// Function to list modules of a lecturer
function getModulesByLecturer($lecturer_id)
{
    global $conn;
    $sql = "SELECT modules.* FROM modules_lecturers JOIN modules ON modules_lecturers.module_id = modules.id WHERE modules_lecturers.lecturer_id = $lecturer_id";
    $result = $conn->query($sql);
    $modules = [];
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $modules[] = $row;
        }
    }
    return $modules;
}
// Function to assign a student to a module
function assignStudentToModule($student_id, $module_id)
{
    global $conn;
    $sql = "INSERT INTO modules_students (module_id, student_id) VALUES ($module_id, $student_id)";
    if ($conn->query($sql) === TRUE) {
        return true;
    } else {
        return false;
    }
}

// Function to remove a student from a module
function removeStudentFromModule($student_id, $module_id)
{
    global $conn;
    $sql = "DELETE FROM modules_students WHERE module_id = $module_id AND student_id = $student_id";
    if ($conn->query($sql) === TRUE) {
        return true;
    } else {
        return false;
    }
}

// Function to list modules of a student
function getModulesByStudent($student_id)
{
    global $conn;
    $sql = "SELECT modules.* FROM modules_students JOIN modules ON modules_students.module_id = modules.id WHERE modules_students.student_id = $student_id";
    $result = $conn->query($sql);
    $modules = [];
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $modules[] = $row;
        }
    }
    return $modules;
}

// Function to add a room
function addRoom($data)
{
    global $conn;
    $columns = implode(", ", array_keys($data));
    $values = "'" . implode("', '", $data) . "'";
    $sql = "INSERT INTO rooms ($columns) VALUES ($values)";
    if ($conn->query($sql) === TRUE) {
        return true;
    } else {
        return false;
    }
}

// Function to update a room by ID
function updateRoom($data, $room_id)
{
    global $conn;
    $updates = [];
    foreach ($data as $key => $value) {
        $updates[] = "$key = '$value'";
    }
    $updates_str = implode(", ", $updates);
    $sql = "UPDATE rooms SET $updates_str WHERE room_id = $room_id";
    if ($conn->query($sql) === TRUE) {
        return true;
    } else {
        return false;
    }
}

// Function to delete a room by ID
function deleteRoomById($room_id)
{
    global $conn;
    $sql = "DELETE FROM rooms WHERE room_id = $room_id";
    if ($conn->query($sql) === TRUE) {
        return true;
    } else {
        return false;
    }
}

// Function to get all rooms
function getAllRooms()
{
    global $conn;
    $sql = "SELECT * FROM rooms";
    $result = $conn->query($sql);
    $rooms = [];
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $rooms[] = $row;
        }
    }
    return $rooms;
}

// Function to get room by ID
function getRoomById($room_id)
{
    global $conn;
    $sql = "SELECT * FROM rooms WHERE room_id = $room_id";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $room = $result->fetch_assoc();
        return $room;
    } else {
        return false;
    }
}


// Function to get a room by name
function getRoomByName($roomName)
{
    global $conn;
    $escaped_roomName = mysqli_real_escape_string($conn, $roomName);
    $sql = "SELECT * FROM rooms WHERE room_name = '$escaped_roomName'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $room = $result->fetch_assoc();
        return $room;
    } else {
        return false;
    }
}

// Function to add a timetable
function addTimetable($data)
{
    global $conn;
    $columns = implode(", ", array_keys($data));
    $values = "'" . implode("', '", $data) . "'";
    $sql = "INSERT INTO timetables ($columns) VALUES ($values)";
    if ($conn->query($sql) === TRUE) {
        return true;
    } else {
        return false;
    }
}

function isModuleAlreadyAdded($module_id, $room_id)
{
    global $conn;

    // Escape inputs to prevent SQL injection
    $module_id = mysqli_real_escape_string($conn, $module_id);
    $room_id = mysqli_real_escape_string($conn, $room_id);

    // Query to check if the module is already added to the same room for the same day and time slot
    $sql = "SELECT * FROM timetables 
            WHERE module_id = '$module_id' 
            AND room_id = '$room_id'";

    $result = $conn->query($sql);

    // If there are any rows returned, then the module is already added
    if ($result && $result->num_rows > 0) {
        return $result->fetch_assoc();
    } else {
        return false;
    }
}

// Function to update a timetable by ID
function updateTimetable($data, $timetable_id)
{
    global $conn;
    $updates = [];
    foreach ($data as $key => $value) {
        $updates[] = "$key = '$value'";
    }
    $updates_str = implode(", ", $updates);
    $sql = "UPDATE timetables SET $updates_str WHERE timetable_id = $timetable_id";
    if ($conn->query($sql) === TRUE) {
        return true;
    } else {
        return false;
    }
}

// Function to delete a timetable by ID
function deleteTimetableById($timetable_id)
{
    global $conn;
    $sql = "DELETE FROM timetables WHERE timetable_id = $timetable_id";
    if ($conn->query($sql) === TRUE) {
        return true;
    } else {
        return false;
    }
}

// Function to get all timetables
function getAllTimetables()
{
    global $conn;
    $sql = "SELECT * FROM timetables";
    $result = $conn->query($sql);
    $timetables = [];
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $timetables[] = $row;
        }
    }
    return $timetables;
}

// Function to get timetables by lecturer ID
function getTimetablesByLecturerId($lecturer_id)
{
    global $conn;
    $lecturer_id = mysqli_real_escape_string($conn, $lecturer_id);
    $sql = "SELECT * FROM timetables WHERE module_id IN (SELECT module_id FROM modules_lecturers WHERE lecturer_id = '$lecturer_id')";
    $result = $conn->query($sql);
    $timetables = [];
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $timetables[] = $row;
        }
    }
    return $timetables;
}

// Function to get timetables by student ID
function getTimetablesByStudentId($student_id)
{
    global $conn;
    $student_id = mysqli_real_escape_string($conn, $student_id);
    $sql = "SELECT * FROM timetables WHERE module_id IN (SELECT module_id FROM modules_students WHERE student_id = '$student_id')";
    $result = $conn->query($sql);
    $timetables = [];
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $timetables[] = $row;
        }
    }
    return $timetables;
}

// Function to get timetable by ID
function getTimetableById($timetable_id)
{
    global $conn;
    $sql = "SELECT * FROM timetables WHERE timetable_id = $timetable_id";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $timetable = $result->fetch_assoc();
        return $timetable;
    } else {
        return false;
    }
}

function authenticateUser($email, $password, $table)
{
    global $conn;

    $sql = "SELECT * FROM $table WHERE email = '$email'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        if (password_verify($password, $user['password'])) {
            return $user;
        }
    }
    return null;
}


// Function to check if user is logged in
function isLoggedIn()
{
    return isset($_SESSION['user_id']);
}

// Function to check if user is an admin
function isAdmin()
{
    return isset($_SESSION['user_id']) && $_SESSION['user_type'] === 'admin';
}

// Function to check if user is a lecturer
function isLecturer()
{
    return isset($_SESSION['user_id']) && $_SESSION['user_type'] === 'lecturer';
}

// Function to check if user is a student
function isStudent()
{
    return isset($_SESSION['user_id']) && $_SESSION['user_type'] === 'student';
}

// Function to get modules for a lecturer
function getLecturerModules($lecturerId)
{
    global $conn;
    $modules = array();
    $sql = "SELECT modules.module_id, modules.module_name, programs.program_name, modules.semester
            FROM modules
            INNER JOIN modules_lecturers ON modules.module_id = modules_lecturers.module_id
            INNER JOIN programs ON modules.program_id = programs.program_id
            WHERE modules_lecturers.lecturer_id = $lecturerId";
    $result = $conn->query($sql);
    if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $modules[] = $row;
        }
    }
    return $modules;
}

// Function to get modules for a student
function getStudentModules($studentId)
{
    global $conn;
    $modules = array();
    $sql = "SELECT modules.module_id, modules.module_name, programs.program_name, modules.semester
            FROM modules
            INNER JOIN programs ON modules.program_id = programs.program_id
            INNER JOIN students_modules ON modules.module_id = students_modules.module_id
            WHERE students_modules.student_id = $studentId";
    $result = $conn->query($sql);
    if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $modules[] = $row;
        }
    }
    return $modules;
}

// Function to get lecturers assigned to a module by module_id
function getLecturersByModuleId($module_id)
{
    global $conn;
    $lecturers = array();
    $sql = "SELECT lecturers.* FROM lecturers
            INNER JOIN modules_lecturers ON lecturers.lecturer_id = modules_lecturers.lecturer_id
            WHERE modules_lecturers.module_id = $module_id";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $lecturers[] = $row;
        }
    }
    return $lecturers;
}

// Function to get students enrolled in a module by module_id
function getStudentsByModuleId($module_id)
{
    global $conn;
    $students = array();
    $sql = "SELECT students.* FROM students
            INNER JOIN modules_students ON students.student_id = modules_students.student_id
            WHERE modules_students.module_id = $module_id";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $students[] = $row;
        }
    }
    return $students;
}

function updateLecturer($data, $lecturerId)
{
    global $conn;
    $updates = [];
    foreach ($data as $key => $value) {
        // Check if the key is 'password' and the value is not empty
        if ($key === 'password' && !empty($value)) {
            // Hash the password
            $hashedPassword = password_hash($value, PASSWORD_DEFAULT);
            // Add the hashed password to the updates array
            $updates[] = "password = '$hashedPassword'";
        } else {
            // Add other key-value pairs to the updates array
            $updates[] = "$key = '$value'";
        }
    }
    // Join the updates array into a string
    $updates_str = implode(", ", $updates);
    // Construct the SQL query
    $sql = "UPDATE lecturers SET $updates_str WHERE lecturer_id = $lecturerId";
    // Execute the SQL query
    if ($conn->query($sql) === TRUE) {
        return true;
    } else {
        return false;
    }
}
// Function to add a new lecturer
function addLecturer($data)
{
    global $conn;
    $lecturer_name = $conn->real_escape_string($data['lecturer_name']);
    $email = $conn->real_escape_string($data['email']);
    $password = password_hash($conn->real_escape_string($data['password']), PASSWORD_DEFAULT); // Hash the password

    $query = "INSERT INTO lecturers (lecturer_name, email, password) VALUES ('$lecturer_name', '$email', '$password')";
    if ($conn->query($query)) {
        return true; // Successfully added
    } else {
        return false; // Error occurred
    }
}

// Function to fetch a lecturer by email
function getLecturerByEmail($email)
{
    global $conn;
    $email = $conn->real_escape_string($email);
    $query = "SELECT * FROM lecturers WHERE email = '$email'";
    $result = $conn->query($query);

    if ($result->num_rows > 0) {
        return $result->fetch_assoc(); // Return the lecturer row if found
    } else {
        return null; // Lecturer not found
    }
}

// Function to fetch a lecturer by ID
function getLecturerById($lecturer_id)
{
    global $conn;
    $query = "SELECT * FROM lecturers WHERE lecturer_id = '$lecturer_id'";
    $result = $conn->query($query);

    if ($result->num_rows > 0) {
        return $result->fetch_assoc(); // Return the lecturer row if found
    } else {
        return null; // Lecturer not found
    }
}

// Function to delete a lecturer by ID
function deleteLecturerById($lecturer_id)
{
    global $conn;
    $query = "DELETE FROM lecturers WHERE lecturer_id = '$lecturer_id'";
    if ($conn->query($query)) {
        return true; // Successfully deleted
    } else {
        return false; // Error occurred
    }
}

// Function to fetch all lecturers
function getAllLecturers()
{
    global $conn;
    $query = "SELECT * FROM lecturers";
    $result = $conn->query($query);

    if ($result->num_rows > 0) {
        $lecturers = array();
        while ($row = $result->fetch_assoc()) {
            $lecturers[] = $row; // Add each lecturer row to the array
        }
        return $lecturers;
    } else {
        return null; // No lecturers found
    }
}

// Function to add a new student
function addStudent($data)
{
    global $conn;
    $student_name = $conn->real_escape_string($data['student_name']);
    $email = $conn->real_escape_string($data['email']);
    $password = password_hash($conn->real_escape_string($data['password']), PASSWORD_DEFAULT); // Hash the password

    $query = "INSERT INTO students (student_name, email, password) VALUES ('$student_name', '$email', '$password')";
    if ($conn->query($query)) {
        return true; // Successfully added
    } else {
        return false; // Error occurred
    }
}

function updateStudent($data, $studentId)
{
    global $conn;
    $updates = [];
    foreach ($data as $key => $value) {
        // Check if the key is 'password' and the value is not empty
        if ($key === 'password' && !empty($value)) {
            // Hash the password
            $hashedPassword = password_hash($value, PASSWORD_DEFAULT);
            // Add the hashed password to the updates array
            $updates[] = "password = '$hashedPassword'";
        } else {
            // Add other key-value pairs to the updates array
            $updates[] = "$key = '$value'";
        }
    }
    // Join the updates array into a string
    $updates_str = implode(", ", $updates);
    // Construct the SQL query
    $sql = "UPDATE students SET $updates_str WHERE student_id = $studentId";
    // Execute the SQL query
    if ($conn->query($sql) === TRUE) {
        return true;
    } else {
        return false;
    }
}

// Function to fetch a student by email
function getStudentByEmail($email)
{
    global $conn;
    $email = $conn->real_escape_string($email);
    $query = "SELECT * FROM students WHERE email = '$email'";
    $result = $conn->query($query);

    if ($result->num_rows > 0) {
        return $result->fetch_assoc(); // Return the student row if found
    } else {
        return null; // Student not found
    }
}

// Function to fetch a student by ID
function getStudentById($student_id)
{
    global $conn;
    $query = "SELECT * FROM students WHERE student_id = '$student_id'";
    $result = $conn->query($query);

    if ($result->num_rows > 0) {
        return $result->fetch_assoc(); // Return the student row if found
    } else {
        return null; // Student not found
    }
}

// Function to delete a student by ID
function deleteStudentById($student_id)
{
    global $conn;
    $query = "DELETE FROM students WHERE student_id = '$student_id'";
    if ($conn->query($query)) {
        return true; // Successfully deleted
    } else {
        return false; // Error occurred
    }
}

// Function to fetch all students
function getAllStudents()
{
    global $conn;
    $query = "SELECT * FROM students";
    $result = $conn->query($query);

    if ($result->num_rows > 0) {
        $students = array();
        while ($row = $result->fetch_assoc()) {
            $students[] = $row; // Add each student row to the array
        }
        return $students;
    } else {
        return null; // No students found
    }
}


// Function to check if a student is assigned to a module
function isStudentAssignedToModule($student_id, $module_id)
{
    global $conn; // Assuming $conn is your database connection object

    // Prepare and execute the query
    $stmt = $conn->prepare("SELECT COUNT(*) as count FROM modules_students WHERE student_id = ? AND module_id = ?");
    $stmt->bind_param("ii", $student_id, $module_id);
    $stmt->execute();
    $result = $stmt->get_result();

    // Fetch the count
    $row = $result->fetch_assoc();
    $count = $row['count'];

    // Return true if the count is greater than 0, indicating the student is assigned to the module
    return $count > 0;
}

// Function to check if a lecturer is assigned to a module
function isLecturerAssignedToModule($lecturer_id, $module_id)
{
    global $conn; // Assuming $conn is your database connection object

    // Prepare and execute the query
    $stmt = $conn->prepare("SELECT COUNT(*) as count FROM modules_lecturers WHERE lecturer_id = ? AND module_id = ?");
    $stmt->bind_param("ii", $lecturer_id, $module_id);
    $stmt->execute();
    $result = $stmt->get_result();

    // Fetch the count
    $row = $result->fetch_assoc();
    $count = $row['count'];

    // Return true if the count is greater than 0, indicating the lecturer is assigned to the module
    return $count > 0;
}


function getCountOfLecturers()
{
    global $conn;
    $sql = "SELECT COUNT(*) AS count FROM lecturers";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
    return $row['count'];
}

function getCountOfStudents()
{
    global $conn;
    $sql = "SELECT COUNT(*) AS count FROM students";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
    return $row['count'];
}

function getCountOfDepartments()
{
    global $conn;
    $sql = "SELECT COUNT(*) AS count FROM departments";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
    return $row['count'];
}

function getCountOfPrograms()
{
    global $conn;
    $sql = "SELECT COUNT(*) AS count FROM programs";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
    return $row['count'];
}

function getCountOfModules()
{
    global $conn;
    $sql = "SELECT COUNT(*) AS count FROM modules";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
    return $row['count'];
}

function getCountOfTimetables()
{
    global $conn;
    $sql = "SELECT COUNT(*) AS count FROM timetables";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
    return $row['count'];
}