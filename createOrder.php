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


if (!isset($_POST['cart']) || !isset($_POST['total'])) {
    echo json_encode(
        array(
            "success" => false,
            "message" => "Cart and total is is required!"
        )
    );
    die();
}

global $CON;

$token = $_POST['token'];
$cart = $_POST['cart'];
$total = $_POST['total'];

$userId = getUserId($token);


$sql = "INSERT INTO orders (user_id, total) VALUES ('$userId','$total')";

$result = mysqli_query($CON, $sql);


if ($result) {
    $orderId = mysqli_insert_id($CON);

    $cartList = json_decode($cart);

    // for ($x = 0; $x <= $cartList->count($cartList); $x++) {
    //     $product = $cart->product;
    //     $quantity = $cartItem->quantity;
    //     $price = $product->price;
    //     $line_total = $quantity * $price;

    //     $sql = "INSERT INTO order_details (order_id, product_id, quantity, line_total) VALUES ('$orderId','$product->product_id','$quantity','$line_total')";
    //     $result = mysqli_query($CON, $sql);
    // }


    foreach ($cartList as $cartItem) {
        $product = $cartItem->product;
        $quantity = $cartItem->quantity;
        $price = $product->price;
        $line_total = $quantity * $price;

        $sql = "INSERT INTO order_details (order_id, product_id, quantity, line_total) VALUES ('$orderId','$product->product_id','$quantity','$line_total')";
        $result = mysqli_query($CON, $sql);
    }

    echo json_encode(
        array(
            "success" => true,
            "message" => "Order created successfully!",
            "order_id" => $orderId
        )
    );
}
