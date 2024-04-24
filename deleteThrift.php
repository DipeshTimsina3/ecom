<?php

include './Helpers/Authenication.php';
include './Helpers/DatabaseConfig.php';

if (

    isset($_POST['token'])

) {
    $token = $_POST['token'];


    if (!isset($_POST['thriftproduct_id'])) {
        return json_encode(array(
            "success" => false,
            "message" => "Thrift Product id is required!"
        ));
    }

    global $CON;

    $thriftproduct_id = $_POST['thriftproduct_id'];

    $sql = "Delete from thriftproduct where thriftproduct_id = $thriftproduct_id";

    $result = mysqli_query($CON, $sql);

    if ($result) {
        echo json_encode(array(
            "success" => true,

            "message" => "thrift Product deleted successfully!"
        ));
    } else {
        echo json_encode(array(
            "success" => false,
            "message" => "thrift Product deletion failed!"
        ));
    }
} 
