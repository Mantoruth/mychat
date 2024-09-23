<?php

$info = (object)[];
$Error = '';

// Validate username
if (empty($DATA_OBJ->username)) {
    $Error .= "Username is required. <br>";
} else {
    if (strlen($DATA_OBJ->username) < 3) {
        $Error .= "Oops! Username must be at least 3 characters long. <br>";
    }
    if (!preg_match("/^[a-zA-Z0-9_]*$/", $DATA_OBJ->username)) {
        $Error .= "Please enter a valid username (letters, numbers, underscores only). <br>";
    }
}

// Validate email
if (empty($DATA_OBJ->email) || !filter_var($DATA_OBJ->email, FILTER_VALIDATE_EMAIL)) {
    $Error .= "Please enter a valid email. <br>";
}

// Validate password
if (empty($DATA_OBJ->password)) {
    $Error .= "Password is required. <br>";
} elseif (strlen($DATA_OBJ->password) < 8) {
    $Error .= "Oops! Password must be at least 8 characters long. <br>";
}

// Validate password confirmation
if (empty($DATA_OBJ->password2)) {
    $Error .= "Please confirm your password. <br>";
} elseif ($DATA_OBJ->password !== $DATA_OBJ->password2) {
    $Error .= "Passwords must match. <br>";
}

// Prepare data if no errors
$data = [];
if ($Error == "") {
    $data['userid'] = $DB->generate_id(20);
    $data['date'] = date("Y-m-d H:i:s");
    $data['username'] = $DATA_OBJ->username;
    $data['email'] = $DATA_OBJ->email;
    $data['password'] = password_hash($DATA_OBJ->password, PASSWORD_DEFAULT);
    
    // Insert into database
    $query = "INSERT INTO users (userid, username, email, password, date) VALUES (:userid, :username, :email, :password, :date)";
    $result = $DB->write($query, $data);

    if ($result) {
        $info->message = "Your profile was successfully created";
        $info->data_type = "info";
    } else {
        $info->message = "Oops! Your profile was NOT created due to an error";
        $info->data_type = "error";
    }
} else {
    $info->message = $Error;
    $info->data_type = "error";
}

// Send the response
echo json_encode($info);

