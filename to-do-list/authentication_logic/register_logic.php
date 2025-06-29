<?php 
require_once(__DIR__ . '/../models/db.php');

// Retrieve form data
// Important to strip username so that users do 
// enter html tags or anything suspicious
$userName = trim(strip_tags($_POST['username']));
$email = filter_var(trim($_POST['email']), FILTER_VALIDATE_EMAIL);
$password = $_POST['password'];
$confirm_password = $_POST['confirm_password'];

try {
    $query = "SELECT * FROM todo_app 
              WHERE email = :email 
              OR username = :username";
    $statement = $pdo->prepare($query);
    $statement->bindValue(':email', $email);
    $statement->bindValue(':username', $userName);
    $statement->execute();
    $user = $statement->fetch();

    // Missing fields?
    if (
        (!$userName) ||
        (!$email) ||
        (!$password) ||
        (!$confirm_password)
    ) {
        header("Location: /to-do-list/index.php?action=register&error=missing_fields");
        exit;
    }

    // Password confirmed? 
    if ($password !== $confirm_password) {
        header("Location: /to-do-list/index.php?action=register&error=password_mismatch");
        exit;
    }

    // Email already exists?
    if ($user['email'] === $email) {
        header("Location: /to-do-list/index.php?action=register&error=email_exists");
        exit;
    }

    // Username already exists?
    if ($user['username'] === $userName) {
        header("Location: /to-do-list/index.php?action=register&error=username_exists");
        exit;
    }

    // Complete registration, insert user into DB
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
    $query = "INSERT INTO todo_app 
                (username, email, password)
              VALUES
                (:username, :email, :password)";
    $statement = $pdo->prepare($query);
    $statement->bindValue(':username', $userName);
    $statement->bindValue(':email', $email);
    $statement->bindValue(':password', $hashedPassword);
    $statement->execute();

    header("Location: /to-do-list/index.php?action=login&registered=true");
    exit;
} catch (PDOException $e) {
    header("Location: /to-do-list/index.php?action=register&error=db_error");
    exit;
}


?>