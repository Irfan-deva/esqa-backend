<?php
require 'config.php';
//get the action param from url
$action = mysqli_escape_string(dbConnection(), $_REQUEST['action']);
//get department param from url
if (isset($_REQUEST['daptt']))
    $daptt = mysqli_escape_string(dbConnection(), $_REQUEST['daptt']);


function getData($department)
{
    $q = "SELECT * FROM $department";
    $result = mysqli_query(dbConnection(), $q);
    $data = [];

    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $data[] = $row;
        }
    } else {
        die('no data found on server');
    }
    echo json_encode($data);
}

function updateRating($department, $id)
{
    $rating = (int)mysqli_escape_string(dbConnection(), $_REQUEST['rating']);
    //get the previous rating and previous count of users who have rated.
    $q = "SELECT user_rating, users_rated_count FROM $department WHERE id = $id";
    $result = mysqli_query(dbConnection(), $q);
    $row = mysqli_fetch_assoc($result);
    //get the preious count of users who have rated and add 1 
    $updated_users_rated_count = $row['users_rated_count'] + 1;
    //get previous total rating and add $rating the user has given
    $updated_user_rating = $row['user_rating'] + $rating;
    //get average raing, total rating DIVIDED BY total users who have rated so far
    $updated_avg_rating = $updated_user_rating / $updated_users_rated_count;
    //finally save data to db
    $update_query = "UPDATE $department SET user_rating=$updated_user_rating, users_rated_count=$updated_users_rated_count, avg_rating=$updated_avg_rating WHERE id=$id";
    $result = mysqli_query(dbConnection(), $update_query);
    echo ($updated_avg_rating);
}

//handle api calls
switch ($action) {
    case "updateRating":
        $id = mysqli_escape_string(dbConnection(), $_REQUEST['id']);
        updateRating($daptt, $id);
        break;
    case 'getData':
        getData($daptt);
        break;
    default:
        echo 'invalid request';
}
