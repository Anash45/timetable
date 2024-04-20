<?php
require 'functions.php';
$info = '';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];
    $role = $_POST['role'];

    $user = null;

    switch ($role) {
        case 'admin':
            $user = authenticateUser($email, $password, 'admins');
            break;
        case 'lecturer':
            $user = authenticateUser($email, $password, 'lecturers');
            break;
        case 'student':
            $user = authenticateUser($email, $password, 'students');
            break;
        default:
            // Invalid role
            header('Location: login.php'); // Redirect to login page
            exit;
    }

    if ($user) {
        switch ($role) {
            case 'admin':
                $_SESSION['user_id'] = $user['admin_id'];
                $_SESSION['user_name'] = $user['admin_name'];
                break;
            case 'lecturer':
                $_SESSION['user_id'] = $user['lecturer_id'];
                $_SESSION['user_name'] = $user['lecturer_name'];
                break;
            case 'student':
                $_SESSION['user_id'] = $user['student_id'];
                $_SESSION['user_name'] = $user['student_name'];
                break;
            default:
                // Invalid role
                header('Location: login.php'); // Redirect to login page
                exit;
            }
        // Authentication successful
        $_SESSION['user_type'] = $role;

        // Redirect to timetables.php
        header('Location: timetables.php');
        exit;
    } else {

        $info = '<div class="alert alert-danger alert-dismissible fade show" role="alert">
        Incorrect email or password.
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
        <title>Dashboard Template · Bootstrap v5.0</title>
        <link rel="canonical" href="https://getbootstrap.com/docs/5.0/examples/dashboard/">
        <!-- Bootstrap core CSS -->
        <link href="./assets/css/bootstrap.min.css" rel="stylesheet">
        <link rel="stylesheet" href="./assets/fontawesome/css/all.css">
        <link href="./assets/css/style.css" rel="stylesheet">
    </head>

    <body class="text-center login-page" cz-shortcut-listen="true">
        <main class="form-signin">
            <form method="POST">
                <p class="text-center fs-3 mb-0 text-primary">
                    <i class="fal fa-sign-in"></i>
                </p>
                <h1 class="h3 mb-3 fw-normal">Please Login</h1>
                <?php echo $info; ?>
                <div class="form-floating">
                    <input type="email" class="form-control" id="floatingInput" name="email"
                        placeholder="name@example.com" required>
                    <label for="floatingInput">Email address</label>
                </div>
                <div class="form-floating">
                    <input type="password" class="form-control" id="floatingPassword" name="password"
                        placeholder="Password" required>
                    <label for="floatingPassword">Password</label>
                </div>
                <div class="mb-3">
                    <select class="form-select" id="role" name="role" required>
                        <option value="">Select role...</option>
                        <option value="admin">Admin</option>
                        <option value="lecturer">Lecturer</option>
                        <option value="student">Student</option>
                    </select>
                </div>
                <button class="w-100 btn btn-lg btn-primary" type="submit">Login</button>
            </form>
        </main>
        <script src="./assets/js/jquery-3.6.1.min.js"></script>
        <script src="./assets/js/bootstrap.bundle.min.js"></script>
        <script src="./assets/js/script.js"></script>
    </body>

</html>