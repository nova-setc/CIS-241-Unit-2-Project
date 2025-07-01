<?php
// Retrieve the user ID from the session
// and due date from the form submission
$userId = $_SESSION['user_id'];
$dueDate = filter_input(INPUT_POST, 'due_date');

// Ensure due date is at least today's date
$today = date('Y-m-d');
if ($dueDate < $today) {
    header("Location: /CIS-241-Unit-2-Project/to-do-list/index.php?action=dashboard_view&error=invalid_due_date");
    exit;
}

// Retrieve the task title from the form submission
$taskTitle = filter_input(INPUT_POST, 'task');

if ($taskTitle && trim($taskTitle) !== '') {
    $result = addTask($userId, $taskTitle, $dueDate);
    if ($result) {
        header("Location: /CIS-241-Unit-2-Project/to-do-list/index.php?action=dashboard_view&success=task_added");
        exit;
    } else {
        header("Location: /CIS-241-Unit-2-Project/to-do-list/index.php?action=dashboard_view&error=add_task_failed");
        exit;
    }
}
?>