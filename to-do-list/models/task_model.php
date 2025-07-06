<?php
require_once(__DIR__ . '/db.php');

// Retrieve all tasks for a user, ordered by due date
function getTasksByUserId($user_id) {
    global $pdo;
    try {
        $stmt = $pdo->prepare("SELECT * FROM tasks WHERE user_id = ? ORDER BY due_date ASC");
        $stmt->execute([$user_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        // Log or handle the error as needed
        return false;
    }
}

// Retrieve a specific task by its ID
function getTaskById($task_id) {
    global $pdo;
    try {
        $stmt = $pdo->prepare("SELECT * FROM tasks WHERE task_id = ?");
        $stmt->execute([$task_id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        return false;
    }
}

// Add a new task for a user
function addTask($user_id, $title, $due_date = null) {
    global $pdo;
    try {
        $stmt = $pdo->prepare("INSERT INTO tasks (user_id, title, due_date) VALUES (?, ?, ?)");
        return $stmt->execute([$user_id, $title, $due_date]);
    } catch (PDOException $e) {
        return false;
    }
}

// Update an existing task
function updateTask($task_id, $title, $due_date) {
    global $pdo;
    try {
        $stmt = $pdo->prepare("UPDATE tasks SET title = ?, due_date = ? WHERE task_id = ?");
        return $stmt->execute([$title, $due_date, $task_id]);
    } catch (PDOException $e) {
        return false;
    }
}

// Complete a task by deleting it
function completeTask($task_id) {
    global $pdo;
    try {
        $stmt = $pdo->prepare("DELETE FROM tasks WHERE task_id = ?");
        return $stmt->execute([$task_id]);
    } catch (PDOException $e) {
        return false;
    }
}
?>