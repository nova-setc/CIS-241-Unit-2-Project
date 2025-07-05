<?php
$userId = $_SESSION['user_id'];
$userName = $_SESSION['user_name'];
$visitCount = $_COOKIE['login_visits'];

// Messages for success or error
if (isset($_GET['success']) && $_GET['success'] === 'task_added') {
    echo '<p class="success-message">Task added successfully!</p>';
}

if (isset($_GET['error']) && $_GET['error'] === 'add_task_failed') {
    echo '<p class="error-message">Failed to add task. Please try again.</p>';
}   

if (isset($_GET['error']) && $_GET['error'] === 'delete_task_failed') {
    echo '<p class="error-message">Failed to delete task. Please try again.</p>';
}

if (isset($_GET['success']) && $_GET['success'] === 'task_updated') {
    echo '<p class="success-message">Task updated successfully!</p>';
}

if (isset($_GET['error']) && $_GET['error'] === 'update_task_failed') {
    echo '<p class="error-message">Failed to update task. Please try again.</p>';
}

if (isset($_GET['success']) && $_GET['success'] === 'task_completed') {
    echo '<p class="success-message">Task completed successfully!</p>';
}

if (isset($_GET['error']) && $_GET['error'] === 'complete_task_failed') {
    echo '<p class="error-message">Failed to complete task. Please try again.</p>';
}

if (isset($_GET['error']) && $_GET['error'] === 'invalid_due_date') {
    echo '<p class="error-message">Invalid due date. Please select a date in the future.</p>';
}

if (isset($_GET['error']) && $_GET['error'] === 'task_not_found') {
    echo '<p class="error-message">Task not found. Please try again.</p>';
}

// Retrieve all tasks for the user
$allUserTasks = getTasksByUserId($userId);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/CIS-241-Unit-2-Project/to-do-list/styles.css">
    <link href="https://fonts.googleapis.com/css2?family=Nunito:ital,wght@0,200..1000;1,200..1000&display=swap" rel="stylesheet">
    <title>📝 To-Do List: Dashboard</title>
</head>
<body>

    <!-- Navigation Bar -->
    <nav>
        <div class="nav-container">
            <a href="#">
                <header>
                <h1>📝 To-Do List</h1>
                </header>
            </a>
            <div class="nav-links-container">
                <a href="/CIS-241-Unit-2-Project/to-do-list/index.php?action=dashboard_view">Dashboard</a>
                <a href="/CIS-241-Unit-2-Project/to-do-list/index.php?action=logout">Logout</a>
            </div>
        </div>
    </nav>

    <!-- Main content: Dashboard -->
    <main>
        <h1 class="dashboard-title">Welcome, <?php echo htmlspecialchars($userName); ?>!</h1>
        <p class="dashboard-subtitle">You have logged into an account using this browser <span id="visit-count"><?php echo htmlspecialchars($visitCount); ?> times.</span></p>

        <form class="add-task-form" action="/CIS-241-Unit-2-Project/to-do-list/index.php?action=add_task" method="POST">
            <h2>Add Task</h2>
            <input name="task" placeholder="Enter your task here" required></input>
            <input type="date" name="due_date" placeholder="Due Date" required></input>
            <button type="submit">Add Task</button>
        </form>

        <div class="task-list-container">
                <?php if (empty($allUserTasks)): ?>
                    <p class="no-tasks-message">🙌🏼 All tasks completed!</p>
                <?php else: ?>
                    <?php foreach ($allUserTasks as $task): ?>
                        <div class="task-container">
                            <div class="task-title-duedate-container">
                                <p><?php echo htmlspecialchars($task['title']); ?></p>
                                <p class="task-due-date">Due: <?php echo htmlspecialchars($task['due_date']); ?></p>
                            </div>
                            <div class="task-actions-container">
                                <a href="/CIS-241-Unit-2-Project/to-do-list/index.php?action=edit_task&id=<?php echo $task['task_id']; ?>" class="task-action-button"><img src="/CIS-241-Unit-2-Project/to-do-list/views/assets/edit.png" alt="Edit Task"></a>
                                <a href="/CIS-241-Unit-2-Project/to-do-list/index.php?action=complete_task&id=<?php echo $task['task_id']; ?>" class="task-action-button"><img src="/CIS-241-Unit-2-Project/to-do-list/views/assets/checkmark.png" alt="Complete Task"></a>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
        </div>
    </main>

</body>
</html>