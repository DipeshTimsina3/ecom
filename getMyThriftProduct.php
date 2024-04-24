<?php
include './Helpers/DatabaseConfig.php';
include './Helpers/Authenication.php';

global $CON;
$token = $_POST['token'];
$userId = getUserId($token);

$sql = "SELECT * FROM thriftproduct t JOIN users u ON t.user_id = u.user_id WHERE t.user_id = '$userId'";
$result = mysqli_query($CON, $sql);

$thriftMyProducts = []; // Initialize the array to avoid undefined variable issues

while ($row = mysqli_fetch_assoc($result)) {
    $thriftMyProducts[] = $row;
}

// Check if the query was successful and if there are any products
if ($result && count($thriftMyProducts) > 0) {
    echo json_encode(
        array(
            "success" => true,
            "message" => "Products fetched successfully!",
            "data" => $thriftMyProducts
        )
    );
} else {
    // Handle the case where no products were found or the query failed
    echo json_encode(
        array(
            "success" => false,
            "message" => "No products found!"
        )
    );
}
