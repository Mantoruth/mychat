<?php

$info = (object)[];

if (empty($DATA_OBJ->username)) {
    $Error .= "Username is required. <br>";
} else {
    if (strlen($DATA_OBJ->username) < 3) {
        $Error .= "Oops! Username must be at least 3 characters long. <br>";
    }
    if (!preg_match("/^[a-zA-Z]*$/", $DATA_OBJ->username)) {
        $Error .= "Please enter a valid username. <br>";
    }
}

// Validate email
if (empty($DATA_OBJ->email) || !filter_var($DATA_OBJ->email, FILTER_VALIDATE_EMAIL)) {
}
if (!preg_match("/([\w\-]+\@[\w\-]+\.[\w\-]+)/", $DATA_OBJ->email)) {
    $Error .= "Please enter a valid email. <br>";
}

// Validate password
if (empty($DATA_OBJ->password)) {
    $Error .= "Password is required. <br>";
}

// Validate password confirmation
if (empty($DATA_OBJ->password2)) {
    $Error .= "Please enter a valid password . <br>";
} elseif ($DATA_OBJ->password !== $DATA_OBJ->password2) {
    $Error .= "Passwords must match. <br>";

}
if (strlen($DATA_OBJ->password) < 8) {
    $Error .= "Oops! password must be at least 8 characters long. <br>";
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
        echo json_encode($info);
    } else {
        $info->message = "Oops! Your profile was NOT created due to an error";
        $info->data_type = "error";
        echo json_encode($info);
    }
} else {
    
    $info->message = $Error;
    $info->data_type = "error";
    echo json_encode($info);

}