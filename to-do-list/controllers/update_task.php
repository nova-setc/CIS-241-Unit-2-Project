<?php 

// Retrieve the task ID from the GET request
$taskId = $_GET['id'];

/// Retrieve the due date and task title from the form submission
$dueDate = filter_input(INPUT_POST, 'due_date');
$taskTitle = filter_input(INPUT_POST, 'task');

// Ensure due date is at least today's date
$today = date('Y-m-d');
if ($dueDate < $today) {
    header("Location: /CIS-241-Unit-2-Project/to-do-list/index.php?action=dashboard_view&error=invalid_due_date");
    exit;
}

// Check if task title is valid
if ($taskTitle && trim($taskTitle) !== '') {
    $result = updateTask($taskId, $taskTitle, $dueDate);
    if ($result) {
        header("Location: /CIS-241-Unit-2-Project/to-do-list/index.php?action=dashboard_view&success=task_updated");
        exit;
    } else {
        header("Location: /CIS-241-Unit-2-Project/to-do-list/index.php?action=dashboard_view&error=update_task_failed");
        exit;
    }
}

?>