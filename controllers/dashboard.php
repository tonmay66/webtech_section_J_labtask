<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

include_once '../models/config.php';
include_once '../models/userModel.php';

$userModel = new User($pdo);
$user = $userModel->getUserById($_SESSION['user_id']);

?>

<!DOCTYPE html>
<html>
<head>
<title>Dashboard - Task Management App</title>
<link rel="stylesheet" href="../view/public.css">
</head>
<body>
<header>
    <nav>
        <a href="profile.php">Profile</a>
        <a href="tasks.php">Tasks</a>
        <a href="logout.php">Logout</a>
    </nav>
</header>

<div class="container">
    <h2>Welcome, <?php echo htmlspecialchars($user['username']); ?>!</h2>
    <p>This is your dashboard. Here you can manage your tasks and profile.</p>
</div>

</body>
</html>