<?php
include './Helpers/DatabaseConfig.php';
include './Helpers/Authenication.php';


global $CON;


$sql = "Select * from thriftproduct t  JOIN users u on t.user_id = u.user_id";
$result = mysqli_query($CON, $sql);

$thriftdata = [];

while ($row = mysqli_fetch_assoc($result)) {
    $thriftdata[] = $row;
}

if ($result) {
    echo json_encode(
        array(
            "success" => true,
            "message" => "Products fetched successfully!",
            "data" => $thriftdata
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


