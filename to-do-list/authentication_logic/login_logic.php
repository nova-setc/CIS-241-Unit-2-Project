<?php
require_once(__DIR__ . '/../models/db.php');

// Retrieve the login form data
$email = $_POST['email'] ?? '';
$password = $_POST['password'] ?? '';

// Validate input
if (empty($email) || empty($password)) {
    header("Location: /to-do-list/index.php?action=login&error=missing_fields");
    exit;
}


try {
    // Prepare SQL query
    $query = "SELECT * FROM todo_app WHERE email = :email";
    $statement = $pdo->prepare($query);
    $statement->bindValue(':email', $email);
    $statement->execute();
    $user = $statement->fetch();

    // Verify password and complete the log in
    if ($user && password_verify($password, $user['password'])) {
        session_start();
        $_SESSION['user_id'] = $user['id'];

        // Track login visits
        $visits = $_COOKIE['login_visits'] ?? 0;
        $visits++;
        setcookie('login_visits', $visits, time() + 94608000, "/");

        header("Location: /to-do-list/index.php?action=dashboard");
        exit;
    } else {
        header("Location: /to-do-list/index.php?action=login&error=invalid_credentials");
        exit;
    }

} catch (PDOException $e) {
    header("Location: /to-do-list/index.php?action=login&error=db_error");
    exit;
}


?>