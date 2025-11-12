<?php
session_start();
include_once '../models/config.php';
include_once '../models/userModel.php';

$userModel = new User($pdo);
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $email = filter_var(trim($_POST['email']), FILTER_VALIDATE_EMAIL);
    $password = $_POST['password'];
    $confirm = $_POST['confirm_password'];

    if (!$username || !$email || !$password) {
        $error = "All fields are required.";
    } elseif ($password !== $confirm) {
        $error = "Passwords do not match.";
    } else {
        $result = $userModel->register($username, $email, $password);
        if ($result) {
            header("Location: login.php");
            exit;
        } else {
            $error = "Email already exists or registration failed.";
        }
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Register - Task Management App</title>
    <link rel="stylesheet" href="public/css/style.css">
    <script>
    function validateRegisterForm() {
        const username = document.forms["registerForm"]["username"].value.trim();
        const email = document.forms["registerForm"]["email"].value.trim();
        const password = document.forms["registerForm"]["password"].value;
        const confirm = document.forms["registerForm"]["confirm_password"].value;

        if (!username) {
            alert("Username is required");
            return false;
        }
        if (!email) {
            alert("Email is required");
            return false;
        }
        if (!password) {
            alert("Password is required");
            return false;
        }
        if (password !== confirm) {
            alert("Passwords do not match");
            return false;
        }
        return true;
    }
    </script>
</head>
<body>
<header>
    <nav>
        <a href="login.php">Login</a>
    </nav>
</header>
<div class="container">
    <h2>Register</h2>
    <?php if (!empty($error)) echo '<p class="error">'.$error.'</p>'; ?>
    <form name="registerForm" method="post" onsubmit="return validateRegisterForm()">
        <input type="text" name="username" placeholder="Username" required>
        <input type="email" name="email" placeholder="Email" required>
        <input type="password" name="password" placeholder="Password" required>
        <input type="password" name="confirm_password" placeholder="Confirm Password" required>
        <button type="submit">Register</button>
    </form>
</div>
</body>
</html>
