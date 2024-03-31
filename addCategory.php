<?php
include './Helpers/DatabaseConfig.php';
include './Helpers/Authenication.php';

if (
    isset($_POST['title']) &&
    isset($_POST['token'])

) {
    global $CON;
    $title = $_POST['title'];
    $token = $_POST['token'];

    $checkAdmin = isAdmin($token);

    if (!$checkAdmin) {
        echo json_encode(
            array(
                "success" => false,
                "message" => "You are not authorized!"
            )
        );
        die();
    }



    $sql = "Select * from categories where category_title ='$title'";
    $result = mysqli_query($CON, $sql);
    $num = mysqli_num_rows($result);
    if ($num > 0) {
        echo json_encode(
            array(
                "success" => false,
                "message" => "Categogry title already exists!"
            )
        );
        return;
    } else {
        $sql = "INSERT INTO categories (category_title) VALUES ('$title')";
        $result = mysqli_query($CON, $sql);

        if ($result) {
            echo json_encode(
                array(
                    "success" => true,
                    "message" => "Category added successfully!"
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
            "required fields" => "token, title"
        )
    );
}
