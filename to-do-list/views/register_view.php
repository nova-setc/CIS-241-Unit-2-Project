<?php

// Pop up any error messages from the URL
if (isset($_GET['error'])) {
    switch ($_GET['error']) {
        case 'missing_fields':
            echo '<p class="error-message">Please fill in all fields.</p>';
            break;
        case 'password_mismatch':
            echo '<p class="error-message">Passwords do not match.</p>';
            break;
        case 'email_exists':
            echo '<p class="error-message">Email already exists.</p>';
            break;
        case 'username_exists':
            echo '<p class="error-message">Username already exists.</p>';
            break;
        case 'db_error':
            echo '<p class="error-message">Database error. Please try again later.</p>';
            break;
        default:
            echo '<p class="error-message">An unknown error occurred.</p>';
    }
}


?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/CIS-241-Unit-2-Project/to-do-list/styles.css">
    <link href="https://fonts.googleapis.com/css2?family=Nunito:ital,wght@0,200..1000;1,200..1000&display=swap" rel="stylesheet">
    <title>📝 To-Do List: Register</title>
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
                <a href="/CIS-241-Unit-2-Project/to-do-list/index.php?action=login_view">Login</a>
                <a href="/CIS-241-Unit-2-Project/to-do-list/index.php?action=register_view">Register</a>
            </div>
        </div>
    </nav>

    <main>
        <form class="auth-form" action="/CIS-241-Unit-2-Project/to-do-list/index.php?action=register" method="POST">
            <h2>Register</h2>
            <input type="text" name="username" placeholder="Username" required>
            <input type="email" name="email" placeholder="Email" required>
            <input type="password" name="password" placeholder="Password" required>
            <input type="password" name="confirm_password" placeholder="Confirm Password" required>
            <button type="submit">Register</button>
        </form>
    </main>
</body>
</html>