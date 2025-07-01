<?php
require_once(__DIR__ . '/../models/db.php');

// Retrieve the login form data
$email = $_POST['email'] ?? '';
$password = $_POST['password'] ?? '';

// Validate input
if (!$email || !$password) {
    header("Location: /CIS-241-Unit-2-Project/to-do-list/index.php?action=login_view&error=missing_fields");
    exit;
}


try {
    // Prepare SQL query
    $query = "SELECT * FROM users WHERE email = :email";
    $statement = $pdo->prepare($query);
    $statement->bindValue(':email', $email);
    $statement->execute();
    $user = $statement->fetch();

    // Verify password and complete the log in
    if ($user && password_verify($password, $user['password_hash'])) {
        $_SESSION['user_id'] = $user['user_id'];
        $_SESSION['user_name'] = $user['username'];

        // Track login visits
        $visits = $_COOKIE['login_visits'] ?? 0;
        $visits++;
        setcookie('login_visits', $visits, time() + 94608000, "/");

        header("Location: /CIS-241-Unit-2-Project/to-do-list/index.php?action=dashboard_view");
        exit;
    } else {
        header("Location: /CIS-241-Unit-2-Project/to-do-list/index.php?action=login_view&error=invalid_credentials");
        exit;
    }

} catch (PDOException $e) {
    header("Location: /CIS-241-Unit-2-Project/to-do-list/index.php?action=login_view&error=db_error");
    exit;
}


?>