<?php
include '../Helpers/DatabaseConfig.php';

if (
    isset($_POST['fullname']) &&
    isset($_POST['email']) &&
    isset($_POST['Phone']) &&
    isset($_POST['password'])

) {
    global $CON;
    $email = $_POST['email'];
    $fullname = $_POST['fullname'];
    $Phone = $_POST['Phone'];
    $password = $_POST['password'];

    $sql = "Select * from users where email ='$email'";
    $result = mysqli_query($CON, $sql);
    $num = mysqli_num_rows($result);
    if ($num > 0) {
        echo json_encode(
            array(
                "success" => false,
                "message" => "Email already exists!"
            )
        );
        return;
    } else {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $sql = "INSERT INTO users (full_name, email, Phone, password,role) VALUES ('$fullname', '$email','$Phone', '$hashed_password','user')";
        $result = mysqli_query($CON, $sql);

        if ($result) {
            echo json_encode(
                array(
                    "success" => true,
                    "message" => "User registered successfully!"
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
    }
} else {
    echo json_encode(
        array(
            "success" => false,
            "message" => "Please fill all the fields!",
            "required fields" => "fullname, email,Phone No, password"
        )
    );
}
