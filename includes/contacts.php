<?php
// Start the session if needed
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Prepare the data to return
$mydata = 
'<div style="text-align: center;">
    <div id="contact">
        <img src="ui/images/user2.png.jpg" alt="">
        <br>Username
    </div>
    <div id="contact">
        <img src="ui/images/user3.png.jpg" alt="">
        <br>Username
    </div>
    <div id="contact">
        <img src="ui/images/user4.png.jpg" alt="">
        <br>Username
    </div>
</div>';

// Create an array to hold the response data
$result = [
    "message" => $mydata,
    "data_type" => "contacts"
];

// Send the JSON response
header('Content-Type: application/json');
echo json_encode($result);
exit; // Use exit instead of die for clarity

// Optional error message (won't be executed because of exit above)
$info = [
    "message" => "No contacts were found",
    "data_type" => "error"
];
// If you want to handle no contacts found, you'd do it before sending the response.
?>
