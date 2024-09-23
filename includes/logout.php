<?php
session_start(); // Ensure the session is started

$info = (object)[]; // Initialize the info object

// Check if the session variable 'userid' is set
if (isset($_SESSION['userid'])) {
    unset($_SESSION['userid']); // Remove the user ID from the session
    $info->logged_in = false; // Set logged_in status
    $info->message = "Successfully logged out."; // Optional message
} else {
    $info->logged_in = true; // User was not logged in
    $info->message = "oopps your logged out."; // Optional message
}

// Send the JSON response back to the client
echo json_encode($info);
?>
