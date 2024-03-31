<?php

include './Helpers/DatabaseConfig.php';
include './Helpers/Authenication.php';

if (!isset($_POST['token'])) {
    echo json_encode(
        array(
            "success" => false,
            "message" => "You are not authorized!"
        )
    );
    die();
}

global $CON;

$token = $_POST['token'];
$userId = getUserId($token);


$sql = "SELECT user_id,full_name,email,role from users where user_id='$userId'";
$result = mysqli_query($CON, $sql);

if ($result) {
    $row = mysqli_fetch_assoc($result);
    echo json_encode(
        array(
            "success" => true,
            "message" => "User fetched successfully!",
            "data" => $row
        )
    );
} else {
    echo json_encode(
        array(
            "success" => false,
            "message" => "Fetching user failed!"
        )
    );
}
