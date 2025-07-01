<?php

if (isset($_GET['registered']) && $_GET['registered'] === 'true') {
    echo '<p class="success-message">Registration successful! You can now log in.</p>';
} 

if (isset($_GET['success']) && $_GET['success'] === 'logout') {
    echo '<p class="success-message">You have successfully logged out!</p>';
}

if (isset($_GET['error'])) {
    switch ($_GET['error']) {
        case 'missing_fields':
            echo '<p class="error-message">Please fill in all fields.</p>';
            break;
        case 'invalid_credentials':
            echo '<p class="error-message">Invalid username or password.</p>';
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
    <title>📝 To-Do List: Login</title>
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
        <form class="auth-form" action="/CIS-241-Unit-2-Project/to-do-list/index.php?action=login" method="POST">
            <h2>Login</h2>
            <input type="text" name="email" placeholder="Email" required>
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit">Login</button>
        </form>
    </main>
</body>
</html>