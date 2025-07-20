<?php
// Retrieve form data
// Important to strip username so that users do 
// enter html tags or anything suspicious
$userName = trim(strip_tags($_POST['username']));
$email = filter_var(trim($_POST['email']), FILTER_VALIDATE_EMAIL);
$password = $_POST['password'];
$confirm_password = $_POST['confirm_password'];

try {
    $query = "SELECT * FROM users 
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
        header("Location: /CIS-241-Unit-2-Project/to-do-list/index.php?action=register_view&error=missing_fields");
        exit;
    }

    // Password meets requirements?
    $password_regex = '/^(?=.*\d).{8,}$/'; // At least 1 digit and minimum 8 characters
    if (!preg_match($password_regex, $password)) {
        header("Location: /CIS-241-Unit-2-Project/to-do-list/index.php?action=register_view&error=invalid_password");
        exit;
    }

    // Password confirmed? 
    if ($password !== $confirm_password) {
        header("Location: /CIS-241-Unit-2-Project/to-do-list/index.php?action=register_view&error=password_mismatch");
        exit;
    }

    // Email already exists?
    if ($user && $user['email'] === $email) {
        header("Location: /CIS-241-Unit-2-Project/to-do-list/index.php?action=register_view&error=email_exists");
        exit;
    }

    // Username already exists?
    if ($user && $user['username'] === $userName) {
        header("Location: /CIS-241-Unit-2-Project/to-do-list/index.php?action=register_view&error=username_exists");
        exit;
    }

    // Complete registration, insert user into DB
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
    $query = "INSERT INTO users 
                (username, email, password_hash)
              VALUES
                (:username, :email, :password_hash)";
    $statement = $pdo->prepare($query);
    $statement->bindValue(':username', $userName);
    $statement->bindValue(':email', $email);
    $statement->bindValue(':password_hash', $hashedPassword);
    $statement->execute();

    header("Location: /CIS-241-Unit-2-Project/to-do-list/index.php?action=login_view&registered=true");
    exit;
} catch (PDOException $e) {
    header("Location: /CIS-241-Unit-2-Project/to-do-list/index.php?action=register_view&error=db_error");
    exit;
}


?>