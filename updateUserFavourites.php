<?php
include './Helpers/DatabaseConfig.php';
include './Helpers/Authenication.php';


global $CON;

$token = $_POST['token'];
$favourite = $_POST['favourite_list'];
$userId = getUserId($token);

// $sql = "update on users favourites = '$favourite' where user_id = '$userId'";
// $result = mysqli_query($CON, $sql);


// if ($result) {
//     echo json_encode(
//         array(
//             "success" => true,
//             "message" => "Favourite fetched successfully!",
//         )
//     );
// } else {
//     echo json_encode(
//         array(
//             "success" => false,
//             "message" => "Something went wrong!"
//         )
//     );
// }

$sql = "UPDATE users SET favourites = ? WHERE user_id = ?";
$stmt = mysqli_prepare($CON, $sql);

if ($stmt) {
    // Bind parameters
    mysqli_stmt_bind_param($stmt, "si", $favourite, $userId);
    
    // Execute statement
    $result = mysqli_stmt_execute($stmt);
    
    if ($result) {
        echo json_encode(
            array(
                "success" => true,
                "message" => "Favourite Added successfully!",
            )
        );
    } else {
        echo json_encode(
            array(
                "success" => false,
                "message" => "Error updating favourite: " . mysqli_error($CON)
            )
        );
    }
    
    // Close statement
    mysqli_stmt_close($stmt);
} else {
    echo json_encode(
        array(
            "success" => false,
            "message" => "Error preparing SQL statement: " . mysqli_error($CON)
        )
    );
}

// Close connection
mysqli_close($CON);


