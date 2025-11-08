<?php
session_start();
require_once '../models/task.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

$taskModel = new Task();

$task = [
    'id' => '',
    'description' => '',
    'due_date' => '',
    'priority' => 'Medium',
    'category' => 'General',
];

if (isset($_GET['id'])) {
    $taskData = $taskModel->getTaskById(intval($_GET['id']));
    if ($taskData) {
        $task = $taskData;
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'] ?? '';
    $description = $_POST['description'] ?? '';
    $due_date = $_POST['due_date'] ?? '';
    $priority = $_POST['priority'] ?? 'Medium';
    $category = $_POST['category'] ?? 'General';

    if ($id) {
        $taskModel->updateTask($id, $description, $due_date, $priority, $category);
    } else {
        $taskModel->addTask($description, $due_date, $priority, $category);
    }
    header('Location: tasks.php');
    exit();
}

$priorities = ['Low', 'Medium', 'High'];
$categories = ['General', 'Work', 'Personal', 'Other'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title><?= $task['id'] ? 'Edit Task' : 'Add Task' ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
</head>
<body>
<div class="container my-4">
    <h1><?= $task['id'] ? 'Edit Task' : 'Add New Task' ?></h1>
    <form method="post" novalidate>
        <input type="hidden" name="id" value="<?= htmlspecialchars($task['id']) ?>" />
        <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <textarea class="form-control" id="description" name="description" required><?= htmlspecialchars($task['description']) ?></textarea>
            <div class="invalid-feedback">Please enter a task description.</div>
        </div>
        <div class="mb-3">
            <label for="due_date" class="form-label">Due Date</label>
            <input type="date" class="form-control" id="due_date" name="due_date" value="<?= htmlspecialchars($task['due_date']) ?>" required />
            <div class="invalid-feedback">Please select a due date.</div>
        </div>
        <div class="mb-3">
            <label for="priority" class="form-label">Priority</label>
            <select class="form-select" id="priority" name="priority" required>
                <?php foreach ($priorities as $priority): ?>
                    <option value="<?= $priority ?>" <?= $task['priority'] === $priority ? 'selected' : '' ?>><?= $priority ?></option>
                <?php endforeach; ?>
            </select>
            <div class="invalid-feedback">Please select a priority.</div>
        </div>
        <div class="mb-3">
            <label for="category" class="form-label">Category</label>
            <select class="form-select" id="category" name="category" required>
                <?php foreach ($categories as $category): ?>
                    <option value="<?= $category ?>" <?= $task['category'] === $category ? 'selected' : '' ?>><?= $category ?></option>
                <?php endforeach; ?>
            </select>
            <div class="invalid-feedback">Please select a category.</div>
        </div>
        <button type="submit" class="btn btn-success"><?= $task['id'] ? 'Update Task' : 'Add Task' ?></button>
        <a href="tasks.php" class="btn btn-secondary">Cancel</a>
    </form>
</div>

<script>
(() => {
  'use strict';
  const forms = document.querySelectorAll('form');
  Array.from(forms).forEach(form => {
    form.addEventListener('submit', event => {
      if (!form.checkValidity()) {
        event.preventDefault();
        event.stopPropagation();
      }
      form.classList.add('was-validated');
    }, false);
  });
})();
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>