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
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body { font-family: 'Inter', sans-serif; }
        .task-completed { text-decoration: line-through; color: #9ca3af; }
    </style>
</head>
<body class="bg-gray-100">

    <nav class="bg-white shadow-md">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16">
                <div class="flex-shrink-0">
                    <h1 class="text-xl font-bold text-gray-800">To-Do List</h1>
                </div>
                <div class="flex items-center">
                    <span class="text-gray-800 mr-4">Welcome, <b><?php echo htmlspecialchars($_SESSION["username"]); ?></b>!</span>
                    <a href="logout.php" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">Logout</a>
                </div>
            </div>
        </div>
    </nav>

    <div class="max-w-4xl mx-auto mt-10 p-6 bg-white rounded-lg shadow-md">
        <h2 class="text-2xl font-bold text-gray-800 mb-6">My Tasks</h2>

        <!-- Add Task Form -->
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" class="mb-6 flex">
            <input type="text" name="task" placeholder="Add a new task..." class="flex-grow shadow appearance-none border rounded-l py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline <?php echo (!empty($task_err)) ? 'border-red-500' : ''; ?>">
            <button type="submit" name="add_task" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-r">Add</button>
        </form>
         <span class="text-red-500 text-xs italic"><?php echo $task_err; ?></span>


        <!-- Task List -->
        <div>
            <?php if(empty($tasks)): ?>
                <p class="text-gray-500">You have no tasks yet. Add one above!</p>
            <?php else: ?>
                <ul>
                    <?php foreach($tasks as $task): ?>
                        <li class="flex items-center justify-between p-3 my-2 bg-gray-50 rounded-lg shadow-sm">
                            <span class="<?php echo $task['is_completed'] ? 'task-completed' : ''; ?>">
                                <?php echo htmlspecialchars($task['task']); ?>
                            </span>
                            <div class="flex items-center">
                                <?php if(!$task['is_completed']): ?>
                                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" class="mr-2">
                                    <input type="hidden" name="task_id" value="<?php echo $task['id']; ?>">
                                    <button type="submit" name="complete_task" class="text-green-500 hover:text-green-700 font-semibold">Complete</button>
                                </form>
                                <?php endif; ?>
                                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                                     <input type="hidden" name="task_id" value="<?php echo $task['id']; ?>">
                                    <button type="submit" name="delete_task" class="text-red-500 hover:text-red-700 font-semibold">Delete</button>
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
