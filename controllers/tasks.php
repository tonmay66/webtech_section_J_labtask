<?php
session_start();
require_once '../models/task.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

$taskModel = new Task();

if (isset($_GET['action']) && $_GET['action'] === 'delete' && isset($_GET['id'])) {
    $taskModel->deleteTask(intval($_GET['id']));
    header('Location: tasks.php');
    exit();
}

$tasks = $taskModel->getAllTasks();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Tasks Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
</head>
<body>
<div class="container my-4">
    <h1>Tasks Dashboard</h1>
    <a href="task_form.php" class="btn btn-primary mb-3">Add New Task</a>
    <div class="table-responsive">
        <table class="table table-bordered table-striped align-middle">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Description</th>
                    <th>Due Date</th>
                    <th>Priority</th>
                    <th>Category</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($tasks): foreach ($tasks as $task): ?>
                <tr>
                    <td><?= htmlspecialchars($task['id']) ?></td>
                    <td><?= htmlspecialchars($task['description']) ?></td>
                    <td><?= htmlspecialchars($task['due_date']) ?></td>
                    <td><?= htmlspecialchars($task['priority']) ?></td>
                    <td><?= htmlspecialchars($task['category']) ?></td>
                    <td>
                        <a href="task_form.php?id=<?= urlencode($task['id']) ?>" class="btn btn-sm btn-warning">Edit</a>
                        <a href="tasks.php?action=delete&id=<?= urlencode($task['id']) ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?');">Delete</a>
                    </td>
                </tr>
                <?php endforeach; else: ?>
                <tr><td colspan="6" class="text-center">No tasks found</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
