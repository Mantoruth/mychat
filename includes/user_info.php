<?php
// Check if the session is already started
if (session_status() === PHP_SESSION_NONE) {
    session_start(); // Start the session if it hasn't been started
}

$info = (object)[];
$Error = "";
$data = [];

// Check if userid is set in the session
if (!isset($_SESSION['userid'])) {
    $info->message = "User not logged in.";
    $info->data_type = "error";
    echo json_encode($info);
    exit();
}

// Validate info
$data['userid'] = $_SESSION['userid'];

if ($Error == "") {
    // Insert into database
    $query = "SELECT * FROM users WHERE userid = :userid LIMIT 1";
    $result = $DB->read($query, $data);

    if (!empty($result)) {
        $result = $result[0];
        $result->data_type = "user_info";
        echo json_encode($result);
    } else {
        $info->message = "Wrong email."; // More descriptive message
        $info->data_type = "error";
        echo json_encode($info);
    }
} else {
    $info->message = $Error;
    $info->data_type = "error";
    echo json_encode($info);
}
?>
