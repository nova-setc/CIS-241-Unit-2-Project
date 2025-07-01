<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/CIS-241-Unit-2-Project/to-do-list/styles.css">
    <link href="https://fonts.googleapis.com/css2?family=Nunito:ital,wght@0,200..1000;1,200..1000&display=swap" rel="stylesheet">
    <title>📝 To-Do List: Edit Task</title>
</head>
<body>
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

    <main>
        <form class="edit-task-form" action="/CIS-241-Unit-2-Project/to-do-list/index.php?action=update_task&id=<?php echo $task['task_id']; ?>" method="POST">
            <h2>Edit Task</h2>
            <input type="text" name="task" value="<?php echo htmlspecialchars($task['title']); ?>" required></input>
            <input type="date" name="due_date" value="<?php echo htmlspecialchars($task['due_date']); ?>" required></input>
            <button type="submit">Update Task</button>
        </form>
    </main>

</body>
</html>