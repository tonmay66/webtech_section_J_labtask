<?php
session_start();
require_once '../models/userModel.php';

$pdo = new PDO("mysql:host=localhost;dbname=task_management_db", "root", "");

$userModel = new User($pdo);

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user = $userModel->getUserById($_SESSION['user_id']);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);

    if ($userModel->updateProfile($_SESSION['user_id'], $username, $email)) {
        $success = "Profile updated successfully.";
        $user = $userModel->getUserById($_SESSION['user_id']);
    } else {
        $error = "Failed to update profile.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Profile - Task Management App</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f5f5f5;
            margin: 0;
        }
        header {
            background: #333;
            padding: 15px;
            color: white;
        }
        nav a {
            color: white;
            margin-right: 15px;
            text-decoration: none;
        }
        .container {
            max-width: 600px;
            margin: 40px auto;
            background: white;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        h2 {
            margin-bottom: 20px;
        }
        input[type="text"], input[type="email"] {
            width: 100%;
            padding: 10px;
            margin: 10px 0 20px;
            border-radius: 4px;
            border: 1px solid #ccc;
            box-sizing: border-box;
        }
        button {
            background: #28a745;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        .success {
            color: green;
            margin-bottom: 15px;
        }
        .error {
            color: red;
            margin-bottom: 15px;
        }
    </style>
</head>
<body>
<header>
    <nav>
        <a href="dashboard.php">Dashboard</a>
        <a href="logout.php">Logout</a>
    </nav>
</header>

<div class="container">
    <h2>Edit Profile</h2>
    <?php if (isset($error)) : ?>
        <p class="error"><?= htmlspecialchars($error) ?></p>
    <?php endif; ?>
    <?php if (isset($success)) : ?>
        <p class="success"><?= htmlspecialchars($success) ?></p>
    <?php endif; ?>

    <form method="post">
        <input type="text" name="username" placeholder="Username" value="<?= htmlspecialchars($user['username']) ?>" required>
        <input type="email" name="email" placeholder="Email" value="<?= htmlspecialchars($user['email']) ?>" required>
        <button type="submit">Update</button>
    </form>
</div>
</body>
</html>
