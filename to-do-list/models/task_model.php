<?php
/**
 * task_model.php
 *
 * Contains CRUD functions to interact with the `tasks` table in the database.
 * Requires the PDO connection from db.php.
 */

require_once 'db.php';

/**
 * Fetch all tasks belonging to a specific user.
 *
 * @param int $user_id The ID of the user whose tasks to retrieve.
 * @return array|false Returns an array of tasks (associative arrays) or false on failure.
 */
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

/**
 * Add a new task for a user.
 *
 * @param int $user_id The ID of the user adding the task.
 * @param string $title The title or description of the task.
 * @param string|null $due_date Optional due date for the task (YYYY-MM-DD).
 * @param int $completed Whether the task is completed (0 = no, 1 = yes). Defaults to 0.
 * @return bool True on success, false on failure.
 */
function addTask($user_id, $title, $due_date = null, $completed = 0) {
    global $pdo;
    try {
        $stmt = $pdo->prepare("INSERT INTO tasks (user_id, title, due_date, completed) VALUES (?, ?, ?, ?)");
        return $stmt->execute([$user_id, $title, $due_date, $completed]);
    } catch (PDOException $e) {
        return false;
    }
}

/**
 * Update an existing task.
 *
 * @param int $task_id The ID of the task to update.
 * @param string $title The updated title/description.
 * @param string|null $due_date The updated due date (YYYY-MM-DD).
 * @param int $completed Updated completion status (0 or 1).
 * @return bool True on success, false on failure.
 */
function updateTask($task_id, $title, $due_date, $completed) {
    global $pdo;
    try {
        $stmt = $pdo->prepare("UPDATE tasks SET title = ?, due_date = ?, completed = ? WHERE task_id = ?");
        return $stmt->execute([$title, $due_date, $completed, $task_id]);
    } catch (PDOException $e) {
        return false;
    }
}

/**
 * Delete a task by its ID.
 *
 * @param int $task_id The ID of the task to delete.
 * @return bool True on success, false on failure.
 */
function deleteTask($task_id) {
    global $pdo;
    try {
        $stmt = $pdo->prepare("DELETE FROM tasks WHERE task_id = ?");
        return $stmt->execute([$task_id]);
    } catch (PDOException $e) {
        return false;
    }
}
?>