<?php

include './Helpers/Authenication.php';
include './Helpers/DatabaseConfig.php';

if (isset($_POST['token'])) {
    $token = $_POST['token'];
    $isAdmin = isAdmin($token);

    if (!$isAdmin) {
        echo json_encode(array(
            "success" => false,
            "message" => "You are not authorized!"
        ));
        die();
    }

    if (!isset($_POST['category_id'])) {
        echo json_encode(array(
            "success" => false,
            "message" => "category id is required!"
        ));
        die();
    }

    global $CON;
    $category_id = $_POST['category_id'];

    // Prepare the SQL statement to update the is_available status
    // $stmt = $CON->prepare("UPDATE categories SET is_available = NOT is_available WHERE category_id = ?");
    $stmt = $CON->prepare("DELETE from categories WHERE category_id = ?");
    $stmt->bind_param('i', $category_id);

    if ($stmt->execute()) {
        echo json_encode(array(
            "success" => true,
            "message" => "Category deleted successfully!"
        ));
    } else {
        echo json_encode(array(
            "success" => false,
            "message" => "Category  update failed!"
        ));
    }
} else {
    echo json_encode(array(
        "success" => false,
        "message" => "Token is required!"
    ));
    die();
}
