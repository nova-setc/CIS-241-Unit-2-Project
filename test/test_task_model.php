<?php
/**
 * test_task_model.php
 *
 * A simple test script to verify the task_model CRUD functions work correctly.
 * Run this script in your browser or CLI to test your database functions.
 */

require_once '../models/db.php';           // Include the database connection
require_once '../models/task_model.php';   // Include the task model with CRUD functions

// For testing, choose an existing user_id from your users table
$user_id = 1;

// TEST 1: Add a new task
$title = "Complete project documentation";
$due_date = "2025-07-15";

echo "Adding a new task...<br>";
if (addTask($user_id, $title, $due_date)) {
    echo "Task added successfully.<br>";
} else {
    echo "Failed to add task.<br>";
}

// TEST 2: Retrieve all tasks for the user
echo "<br>Fetching tasks for user ID $user_id:<br>";
$tasks = getTasksByUserId($user_id);

if ($tasks) {
    echo "<pre>";
    print_r($tasks);
    echo "</pre>";
} else {
    echo "No tasks found for user.<br>";
}

// TEST 3: Update the first task (if exists)
if (!empty($tasks)) {
    $task = $tasks[0]; // Take first task
    $updatedTitle = $task['title'] . " (Updated)";
    $updatedDueDate = $task['due_date']; // keep same due date
    $completed = 1; // Mark as completed

    echo "<br>Updating task ID " . $task['task_id'] . "...<br>";
    if (updateTask($task['task_id'], $updatedTitle, $updatedDueDate, $completed)) {
        echo "Task updated successfully.<br>";
    } else {
        echo "Failed to update task.<br>";
    }
} else {
    echo "No task to update.<br>";
}

// TEST 4: Delete the last task (if exists)
if (!empty($tasks)) {
    $lastTask = end($tasks);
    echo "<br>Deleting task ID " . $lastTask['task_id'] . "...<br>";
    if (deleteTask($lastTask['task_id'])) {
        echo "Task deleted successfully.<br>";
    } else {
        echo "Failed to delete task.<br>";
    }
} else {
    echo "No task to delete.<br>";
}
?>