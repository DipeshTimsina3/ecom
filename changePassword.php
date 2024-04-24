<?php

include './Helpers/Authenication.php';
include './Helpers/DatabaseConfig.php';

// Initialized response array
$response = [
    "success" => false,
    "message" => "Unknown error"
];

// Check if there's a password update request
if (isset($_POST['oldPassword'], $_POST['newPassword'])) {
    $oldPassword = $_POST['oldPassword'];
    $newPassword = $_POST['newPassword'];
    $userID = getUserID($_POST['token']) ; // Ensure userID is provided

    // First, fetch the existing password from the database
    $stmt = $CON->prepare("SELECT password FROM users WHERE user_id = ?");
    $stmt->bind_param("s", $userID);
    $stmt->execute();
    $stmt->bind_result($currentPassword);
    $stmt->fetch();
    $stmt->close();

    // Verify the old password
    if (password_verify($oldPassword, $currentPassword)) {
        // Update to the new password
        $newHashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
        $stmt = $CON->prepare("UPDATE users SET password = ? WHERE user_id = ?");
        $stmt->bind_param("ss", $newHashedPassword, $userID);

        if ($stmt->execute()) {
            $response["success"] = true;
            $response["message"] = "Password updated successfully.";
        } else {
            $response["message"] = "Failed to update password: " . $stmt->error;
        }
        $stmt->close();
    } else {
        $response["message"] = "Old password does not match.";
    }
}

// Return the response in JSON format
echo json_encode($response);

?>