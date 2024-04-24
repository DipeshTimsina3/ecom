<?php
include './Helpers/DatabaseConfig.php';
include './Helpers/Authenication.php';


global $CON;
$token = $_POST['token'];
$userId = getUserId($token);

$sql = "Select favourites from users where user_id='$userId'";
$result = mysqli_query($CON, $sql);



if ($result) {
    $row = mysqli_fetch_assoc($result);
    echo json_encode(
        array(
            "success" => true,
            "message" => "Favourites fetched successfully!",
            "favourite_list" => $row['favourites'],

        )
    );
} else {
    echo json_encode(
        array(
            "success" => false,
            "message" => "Something went wrong!"
        )
    );
}
