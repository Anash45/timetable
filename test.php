<?php
session_start();
$_SESSION['user_name'] = "admin";
$_SESSION['user_id'] = 1;
$_SESSION['user_type'] = "admin";


// require 'functions.php';

// // Function to generate random email addresses
// function generateRandomEmail() {
//     $characters = 'abcdefghijklmnopqrstuvwxyz';
//     $randomString = '';
//     for ($i = 0; $i < 3; $i++) {
//         $randomString .= $characters[rand(0, strlen($characters) - 1)];
//     }
//     return $randomString . '@example.com';
// }

// // Function to generate random passwords
// function generateRandomPassword() {
//     return 'password'; // For simplicity, all passwords are set to 'password'
// }

// // Insert 10 lecturers
// for ($i = 1; $i <= 10; $i++) {
//     $lecturerName = "Lecturer {$i}";
//     $email = generateRandomEmail();
//     $password = generateRandomPassword();

//     $data = array(
//         'lecturer_name' => $lecturerName,
//         'email' => $email,
//         'password' => $password
//     );

//     addLecturer($data);
// }

// // Insert 10 students
// for ($i = 1; $i <= 10; $i++) {
//     $studentName = "Student {$i}";
//     $email = generateRandomEmail();
//     $password = generateRandomPassword();

//     $data = array(
//         'student_name' => $studentName,
//         'email' => $email,
//         'password' => $password
//     );

//     addStudent($data);
// }

// echo "Lecturers and students added successfully.";

?>