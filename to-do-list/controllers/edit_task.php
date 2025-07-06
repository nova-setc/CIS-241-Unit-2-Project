<?php

// Retrieve the task ID from the GET request
$taskId = $_GET['id'];

// Ensure the task ID is valid and 
// retrieve the task details
// include edit_task_view.php
if ($taskId) {
    $task = getTaskById($taskId);
    if ($task) {
        include(__DIR__ . '/../views/edit_task_view.php');
    } else {
        header("Location: /CIS-241-Unit-2-Project/to-do-list/index.php?action=dashboard_view&error=task_not_found");
        exit;
    }
}

?>