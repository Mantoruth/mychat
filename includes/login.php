<?php

$info = (object)[];
$Error= "";

// Validate email info
$data = [];

if(empty($DATA_OBJ->email))
{
    $Error = "Please enter a valid email.";
    error_log("Login error: " . $Error);
}else {
    // Populate the data array with the email for the query
    $data['email'] = $DATA_OBJ->email;
}

if(empty($DATA_OBJ->password))
{
    $Error = "please enter a valid password";
    error_log("Login error: " . $Error); // Log the error
}
// Prepare data if no errors
if ($Error == "") {
    
    // Insert into database
    $query = "SELECT * FROM users WHERE email = :email LIMIT 1";
    $result = $DB->read($query, $data);

    if (!empty($result)) {
         
        $result = $result[0];
        
        if (password_verify($DATA_OBJ->password, $result->password)) {

          $_SESSION['userid'] = $result->userid;
          $info->message = "You are succesfully logged in";
          $info->data_type = "info";
          echo json_encode($info);

        } else {

        $info->message = "Wrong password.";
        $info->data_type = "error";
        echo json_encode($info);

        }

    } else {
        $info->message = "Oops! Wrong email";
        $info->data_type = "error";
        echo json_encode($info);
    }
} else {
    
    $info->message = $Error;
    $info->data_type = "error";
    echo json_encode($info);

}


