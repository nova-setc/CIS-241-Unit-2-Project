<?php
session_start();
$_SESSION = [];
session_destroy();

header("Location: /to-do-list/index.php?action=login_test");
?>