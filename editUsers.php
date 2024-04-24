<?php

include './Helpers/Authenication.php';
include './Helpers/DatabaseConfig.php';

// Initialized response array
$response = [
    "success" => false,
    "message" => "Unknown error"
];

// Check if there's an update for full name
if (isset($_POST['full_name'])) {
    $fullName = $_POST['full_name'];
    $userID = getUserID($_POST['token']) ; // Ensure userID is provided

    // Prepare SQL based on input provided
    $sql = "UPDATE users SET full_name = ? WHERE user_id = ?";
    
    $stmt = $CON->prepare($sql);
    $stmt->bind_param("si", $fullName, $userID);
    
    if ($stmt->execute()) {
        $response["success"] = true;
        $response["message"] = "Profile updated successfully.";
    } else {
        $response["message"] = "Failed to update profile: " . $stmt->error;
    }

    $stmt->close();
}

// Return the response in JSON format
echo json_encode($response);

?>