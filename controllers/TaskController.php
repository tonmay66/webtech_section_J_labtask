<?php
session_start();

include_once '../models/task.php';

class TaskController {
    private $taskModel;

    public function __construct() {
        $this->taskModel = new Task();
    }

    public function listTasks() {
        if (!isset($_SESSION['user_id'])) {
            header('Location: ../login.php');
            exit;
        }
        $tasks = $this->taskModel->getAllTasks();
        include '../views/tasks/list.php';
        exit;
    }

    public function addTask() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $description = $_POST['description'] ?? '';
            $due_date = $_POST['due_date'] ?? '';
            $priority = $_POST['priority'] ?? '';
            $category = $_POST['category'] ?? '';

            $result = $this->taskModel->addTask($description, $due_date, $priority, $category);
            if ($result) {
                header('Location: index.php');
                exit;
            } else {
                echo "Error saving task.";
                exit;
            }
        }
        exit;
    }

    public function updateTask($id) {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $description = $_POST['description'] ?? '';
            $due_date = $_POST['due_date'] ?? '';
            $priority = $_POST['priority'] ?? '';
            $category = $_POST['category'] ?? '';

            $result = $this->taskModel->updateTask($id, $description, $due_date, $priority, $category);
            if ($result) {
                header('Location: index.php');
                exit;
            } else {
                echo "Error updating task.";
                exit;
            }
        }
        exit;
    }

    public function deleteTask($id) {
        $result = $this->taskModel->deleteTask($id);
        if ($result) {
            header('Location: index.php');
            exit;
        } else {
            echo "Error deleting task.";
            exit;
        }
    }
}