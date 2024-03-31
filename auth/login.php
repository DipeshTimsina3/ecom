<?php
include '../Helpers/DatabaseConfig.php';

if (
    isset($_POST['email']) &&
    isset($_POST['password'])

) {
    global $CON;
    $email = $_POST['email'];
    $password = $_POST['password'];

    $sql = "Select * from users where email ='$email'";
    $result = mysqli_query($CON, $sql);
    $num = mysqli_num_rows($result);
    if ($num == 0) {
        echo json_encode(
            array(
                "success" => false,
                "message" => "User not found !"
            )
        );
        return;
    } else {
        $row = mysqli_fetch_assoc($result);
        $hashed_password = $row['password'];
        $user_id = $row['user_id'];
        $role = $row['role'];
        $result = password_verify($password, $hashed_password);

        if ($result) {

            $token = bin2hex(openssl_random_pseudo_bytes(16));

            $sql = "insert into personal_access_token (token,user_id) values ('$token','$user_id')";

            $result = mysqli_query($CON, $sql);

            if ($result) {
                echo json_encode(
                    array(
                        "success" => true,
                        "message" => "User logged in successfully!",
                        "token" => $token,
                        "role" => $role
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
        } else {
            echo json_encode(
                array(
                    "success" => false,
                    "message" => "Wrong password !"
                )
            );
            return;
        }
    }
} else {
    echo json_encode(
        array(
            "success" => false,
            "message" => "Please fill all the fields!",
            "required fields" => " email, password"
        )
    );
}
