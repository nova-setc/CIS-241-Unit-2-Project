<?php

    session_start();

    // require database and functions files
    require_once(__DIR__ . '/models/db.php');
    require_once(__DIR__ . '/models/task_model.php');

    // determine action; if not set, use login_view
    $action = $_GET['action'] ?? 'login_view';

    switch ($action) {
        // view actions
        case 'login_view':
            include(__DIR__ . '/views/login_view.php');
            break;
        case 'register_view':
            include(__DIR__ . '/views/register_view.php');
            break;
        case 'dashboard_view':
            include(__DIR__ . '/views/dashboard_view.php');
            break;
        // logic actions
        case 'register':
            include(__DIR__ . '/authentication_logic/register_logic.php');
            break;
        case 'login':
            include(__DIR__ . '/authentication_logic/login_logic.php');
            break;
        case 'logout':
            include(__DIR__ . '/authentication_logic/logout_logic.php');
            break;
        case 'add_task':
            include(__DIR__ . '/controllers/add_task.php');
            break;
        case 'edit_task':
            include(__DIR__ . '/controllers/edit_task.php');
            break;
        case 'update_task':
            include(__DIR__ . '/controllers/update_task.php');
            break;
        case 'complete_task':
            include(__DIR__ . '/controllers/complete_task.php');
            break;\
        // fall back to login_view if no cases match
        default:
            include(__DIR__ . '/views/login_view.php');
            break;
    }

?>