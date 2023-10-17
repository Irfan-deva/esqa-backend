<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET,POST,PUT,DELETE, OPTIONS");
require '../config.php';


function login($user, $pwd)
{
    $authQuery = "SELECT * FROM users WHERE user_name = '$user' AND password = '$pwd'";
    $result = mysqli_query(dbConnection(), $authQuery);
    if (mysqli_num_rows($result) > 0) {
        echo (json_encode(array("status" => 1))); //1=>user is valid , login successful
    } else {
        echo (json_encode(array("status" => 0))); //0=>user is  invalid, login unsuccessful
    }
}
$user = mysqli_escape_string(dbConnection(), $_REQUEST['user_name']);
$pwd = mysqli_escape_string(dbConnection(), $_REQUEST['password']);
login($user, $pwd);
