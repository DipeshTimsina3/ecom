<?php

include './Helpers/Authenication.php';
include './Helpers/DatabaseConfig.php';

if (

    isset($_POST['token'])

) {
    $token = $_POST['token'];

    $isAdmin = isAdmin($token);


    if (!$isAdmin) {
        echo json_encode(array(
            "success" => false,
            "message" => "You are not authorized!"

        ));
        die();
    }

    if (!isset($_POST['product_id'])) {
        return json_encode(array(
            "success" => false,
            "message" => "Product id is required!"
        ));
    }

    global $CON;

    $product_id = $_POST['product_id'];

    $sql = "select * from products where product_id = $product_id";

    $result = mysqli_query($CON, $sql);

    $product = mysqli_fetch_assoc($result);
    $is_available = $product['is_available'];
    $value = '';

    if ($is_available == 0) {
        $value = 1;
    } else {
        $value = 0;
    }

    $sql = "update products set is_available = $value where product_id = $product_id";

    $result = mysqli_query($CON, $sql);

    if ($result) {
        echo json_encode(array(
            "success" => true,
            "message" => "Product deleted successfully!"
        ));
    } else {
        echo json_encode(array(
            "success" => false,
            "message" => "Product deletion failed!"
        ));
    }
} else {
    echo json_encode(array(
        "success" => false,
        "message" => "Token is required!"

    ));
    die();
}
