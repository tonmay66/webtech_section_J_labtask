<?php
class Task {
    private $conn;

    public function __construct() {
        $this->conn = new mysqli('localhost', 'root', '', 'task_management_db');

        if ($this->conn->connect_error) {
            die('Database connection error: ' . $this->conn->connect_error);
        }
    }

    public function getAllTasks() {
        $result = $this->conn->query("SELECT * FROM tasks ORDER BY due_date ASC");
        $tasks = [];
        if ($result) {
            while ($row = $result->fetch_assoc()) {
                $tasks[] = $row;
            }
        }
        return $tasks;
    }

    public function getTaskById($id) {
        $stmt = $this->conn->prepare("SELECT * FROM tasks WHERE id = ?");
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }

    public function addTask($description, $due_date, $priority, $category) {
        $stmt = $this->conn->prepare("INSERT INTO tasks (description, due_date, priority, category) VALUES (?, ?, ?, ?)");
        $stmt->bind_param('ssss', $description, $due_date, $priority, $category);
        return $stmt->execute();
    }

    public function updateTask($id, $description, $due_date, $priority, $category) {
        $stmt = $this->conn->prepare("UPDATE tasks SET description = ?, due_date = ?, priority = ?, category = ? WHERE id = ?");
        $stmt->bind_param('ssssi', $description, $due_date, $priority, $category, $id);
        return $stmt->execute();
    }

    public function deleteTask($id) {
        $stmt = $this->conn->prepare("DELETE FROM tasks WHERE id = ?");
        $stmt->bind_param('i', $id);
        return $stmt->execute();
    }
}
