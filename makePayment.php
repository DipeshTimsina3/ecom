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

if (!isset($_POST['order_id']) || !isset($_POST['total']) || !isset($_POST['other_data'])) {
    echo json_encode(
        array(
            "success" => false,
            "message" => "OrderId, total and other_data is is required!"
        )
    );
    die();
}

global $CON;
$token = $_POST['token'];

$order_id = $_POST['order_id'];
$total = $_POST['total'];
$other_data = $_POST['other_data'];
$userId = getUserId($token);


$sql = "INSERT INTO payments (order_id, user_id, amount, other_data) VALUES ('$order_id','$userId','$total','$other_data')";

$result = mysqli_query($CON, $sql);

if ($result) {
    $sql = "UPDATE orders SET status = 'paid' WHERE order_id = '$order_id'";


    $result = mysqli_query($CON, $sql);


    if ($result) {
        echo json_encode(
            array(
                "success" => true,
                "message" => "Payment added  successfully!"
            )
        );
    } else {
        echo json_encode(
            array(
                "success" => false,
                "message" => "Updating order status failed!"
            )
        );
    }
} else {
    echo json_encode(
        array(
            "success" => false,
            "message" => "Creating payment failed!"
        )
    );
}
