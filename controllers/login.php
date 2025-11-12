<?php
session_start();
include_once '../models/config.php';
include_once '../models/userModel.php';

$userModel = new User($pdo);
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = strtolower(trim($_POST['email']));
    $password = trim($_POST['password']);

    if (!$email || !$password) {
        $error = "Please enter a valid email and password.";
    } else {
        if ($userModel->login($email, $password)) {
            header("Location: ../controllers/dashboard.php");
            exit;
        } else {
            $error = "Invalid email or password.";
        }
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Login - Task Management App</title>
    <link rel="stylesheet" href="public/css/style.css">
    <script>
    function validateLoginForm() {
        const email = document.forms["loginForm"]["email"].value.trim();
        const password = document.forms["loginForm"]["password"].value.trim();

        if (!email) {
            alert("Email is required");
            return false;
        }
        if (!password) {
            alert("Password is required");
            return false;
        }
        return true;
    }
    </script>
</head>
<body>
<header>
    <nav>
        <a href="register.php">Register</a>
    </nav>
</header>
<div class="container">
    <h2>Login</h2>
    <?php if ($error) echo '<p class="error">' . htmlspecialchars($error) . '</p>'; ?>
    <form name="loginForm" method="post" onsubmit="return validateLoginForm()">
        <input type="email" name="email" placeholder="Email" required value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>">
        <input type="password" name="password" placeholder="Password" required>
        <button type="submit">Login</button>
    </form>
</div>
</body>
</html>
