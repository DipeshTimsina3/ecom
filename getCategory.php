<?php
include './Helpers/DatabaseConfig.php';
include './Helpers/Authenication.php';


global $CON;

$sql = "Select * from categories";
$result = mysqli_query($CON, $sql);

$categories = [];

while ($row = mysqli_fetch_assoc($result)) {
    $categories[] = $row;
}

if ($result) {
    echo json_encode(
        array(
            "success" => true,
            "message" => "Category fetched successfully!",
            "data" => $categories
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
