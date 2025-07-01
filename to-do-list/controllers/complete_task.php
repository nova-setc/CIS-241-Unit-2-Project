<?php 
// Retrieve the task ID from the GET request
$taskId = $_GET['id'];

// Ensure the task ID is valid
if ($taskId) {
    $result = completeTask($taskId);
    if ($result) {
        header("Location: /CIS-241-Unit-2-Project/to-do-list/index.php?action=dashboard_view&success=task_completed");
        exit;
    } else {
        header("Location: /CIS-241-Unit-2-Project/to-do-list/index.php?action=dashboard_view&error=complete_task_failed");
        exit;
    }
}

?>