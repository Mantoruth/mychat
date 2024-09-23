<?php

session_start();

// Get raw POST data
$DATA_RAW = file_get_contents("php://input");
$DATA_OBJ = json_decode($DATA_RAW);

// Initialize response object
$info = (object)[];

// Check if user is logged in
if (!isset($_SESSION['userid'])) {
    if (isset($DATA_OBJ->data_type) && $DATA_OBJ->data_type !== "login" && $DATA_OBJ->data_type !== "signup") {
        $info->logged_in = false;
        echo json_encode($info);
        die;
    }
}

require_once("classes/autoload.php");
$DB = new Database();

// Check for JSON errors
if (json_last_error() !== JSON_ERROR_NONE) {
    echo json_encode(['status' => 'error', 'message' => 'Invalid JSON']);
    die;
}

// Process the data based on the action type
if (isset($DATA_OBJ->data_type)) {
    switch ($DATA_OBJ->data_type) {
        case "signup":
            include("includes/signup.php");
            break;

        case "login":
            include("includes/login.php");
            break;

        case "user_info":
            include("includes/user_info.php");
            break;

        case "logout":
            // Handle the logout
            session_unset();
            session_destroy();
            $info->data_type = "logout";
            $info->logged_in = false;
            echo json_encode($info);
            die;

        case "contacts":
            include("includes/contacts.php");
            break;

        case "chat":
            include("includes/chats.php");
            break;

        case "settings":
            include("includes/settings.php");
            break;

        default:
            echo json_encode(['status' => 'error', 'message' => 'Unknown action']);
            break;
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'No data type specified']);
}
?>

