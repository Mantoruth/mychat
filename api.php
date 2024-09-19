<?php

require_once("classes/autoload.php");
$DB = new Database();

$DATA_RAW = file_get_contents("php://input");
$DATA_OBJ = json_decode($DATA_RAW);

$Error = "";

// Process the data
if (isset($DATA_OBJ->data_type) && $DATA_OBJ->data_type == "signup") {
    // signup
    include("includes/signup.php");
}

