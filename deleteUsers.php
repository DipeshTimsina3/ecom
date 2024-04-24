<?php

include './Helpers/DatabaseConfig.php';
include './Helpers/Authenication.php';




if (

    isset($_POST['token']) &&
    isset($_POST['userId'])

) {
    $token = $_POST['token'];
    $userID = $_POST['userId'];

    $isAdmin = isAdmin($token);


    if (!$isAdmin) {
        echo json_encode(array(
            "success" => false,
            "message" => "You are not authorized!"

        ));
        die();
    }


    global $CON;


    $sql = "delete from users where user_id = '$userID' ";

    $result = mysqli_query($CON, $sql);


    if ($result) {

        echo json_encode(array(
            "success" => true,
            "message" => "Users deleted successfully!"           

        ));
    } else {

        echo json_encode(array(
            "success" => false,
            "message" => "deleting users failed!"

        ));
    }
} else {
    echo json_encode(array(
        "success" => false,
        "message" => "Token is required!"

    ));
}