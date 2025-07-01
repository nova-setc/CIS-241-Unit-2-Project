<?php
session_start();
$_SESSION = [];
session_destroy();

header("Location: /CIS-241-Unit-2-Project/to-do-list/index.php?action=login_view&success=logout");
?>