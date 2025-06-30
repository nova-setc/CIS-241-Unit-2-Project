<?php
// dashboard.php
// This is the main page for a logged-in user.

require_once "db.php";

// If the user is not logged in, redirect to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}

$user_id = $_SESSION["id"];
$task_err = "";
$tasks = [];

// Handle adding a new task
if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add_task'])){
    if(empty(trim($_POST["task"]))){
        $task_err = "Please enter a task.";
    } else {
        $task = trim($_POST["task"]);
        $sql = "INSERT INTO todos (user_id, task) VALUES (?, ?)";
        if($stmt = $conn->prepare($sql)){
            $stmt->bind_param("is", $user_id, $task);
            if(!$stmt->execute()){
                echo "Error adding task.";
            }
            $stmt->close();
            header("Location: dashboard.php"); // Redirect to avoid form resubmission
            exit;
        }
    }
}

// Handle completing a task
if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['complete_task'])){
    $task_id = $_POST['task_id'];
    $sql = "UPDATE todos SET is_completed = 1 WHERE id = ? AND user_id = ?";
    if($stmt = $conn->prepare($sql)){
        $stmt->bind_param("ii", $task_id, $user_id);
        if(!$stmt->execute()){
             echo "Error updating task.";
        }
        $stmt->close();
        header("Location: dashboard.php");
        exit;
    }
}

// Handle deleting a task
if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['delete_task'])){
    $task_id = $_POST['task_id'];
    $sql = "DELETE FROM todos WHERE id = ? AND user_id = ?";
    if($stmt = $conn->prepare($sql)){
        $stmt->bind_param("ii", $task_id, $user_id);
         if(!$stmt->execute()){
             echo "Error deleting task.";
        }
        $stmt->close();
        header("Location: dashboard.php");
        exit;
    }
}

// Fetch user's tasks from the database
$sql = "SELECT id, task, is_completed, created_at FROM todos WHERE user_id = ? ORDER BY created_at DESC";
if($stmt = $conn->prepare($sql)){
    $stmt->bind_param("i", $user_id);
    if($stmt->execute()){
        $result = $stmt->get_result();
        while($row = $result->fetch_assoc()){
            $tasks[] = $row;
        }
    }
    $stmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - To-Do List</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="styles.css">
</head>
<body class="dashboard-body">

    <nav class="navbar">
        <div class="navbar-container">
            <div class="navbar-brand">
                To-Do List
            </div>
            <div class="navbar-user">
                <span>Welcome, <b><?php echo htmlspecialchars($_SESSION["username"]); ?></b>!</span>
                <a href="logout.php" class="btn btn-danger">Logout</a>
            </div>
        </div>
    </nav>

    <div class="dashboard-container">
        <h2>My Tasks</h2>

        <!-- Add Task Form -->
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" class="add-task-form">
            <input type="text" name="task" placeholder="Add a new task..." class="form-input add-task-input <?php echo (!empty($task_err)) ? 'input-error' : ''; ?>">
            <button type="submit" name="add_task" class="btn btn-primary add-task-btn">Add</button>
        </form>
         <span class="error-text"><?php echo $task_err; ?></span>


        <!-- Task List -->
        <div>
            <?php if(empty($tasks)): ?>
                <p class="no-tasks">You have no tasks yet. Add one above!</p>
            <?php else: ?>
                <ul class="task-list">
                    <?php foreach($tasks as $task): ?>
                        <li class="task-item">
                            <span class="task-text <?php echo $task['is_completed'] ? 'task-completed' : ''; ?>">
                                <?php echo htmlspecialchars($task['task']); ?>
                            </span>
                            <div class="task-actions">
                                <?php if(!$task['is_completed']): ?>
                                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                                    <input type="hidden" name="task_id" value="<?php echo $task['id']; ?>">
                                    <button type="submit" name="complete_task" class="task-action-btn complete">Complete</button>
                                </form>
                                <?php endif; ?>
                                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                                     <input type="hidden" name="task_id" value="<?php echo $task['id']; ?>">
                                    <button type="submit" name="delete_task" class="task-action-btn delete">Delete</button>
                                </form>
                            </div>
                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php endif; ?>
        </div>
    </div>

</body>
</html>
