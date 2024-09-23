<?php
// Start the session if needed
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Check if the user is logged in (optional)
if (!isset($_SESSION['userid'])) {
    echo json_encode(['status' => 'error', 'message' => 'User not logged in']);
    exit;
}

// Prepare the data to return
$mydata = 'settings go here'; // Replace this with actual settings data fetching logic

// Create an array to hold the response data
$result = [
    "message" => $mydata,
    "data_type" => "settings"
];

// Send the JSON response
header('Content-Type: application/json');
echo json_encode($result);
exit; // Use exit for clarity
