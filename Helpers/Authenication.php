<?php



function getUserId($token)
{
    global $CON;
    $sql = "select * from personal_access_token where token ='$token'";
    $result = mysqli_query($CON, $sql);
    $num = mysqli_num_rows($result);
    if ($num == 0) {
        return null;
    } else {
        $row = mysqli_fetch_assoc($result);
        return $row['user_id'];
    }
}


function isAdmin($token)
{
    $userId = getUserId($token);
    if ($userId == null) {
        return false;
    }
    global $CON;
    $sql = "select * from users where user_id ='$userId'";
    $result = mysqli_query($CON, $sql);
    if ($result) {
        $row = mysqli_fetch_assoc($result);
        if ($row['role'] == 'admin') {
            return true;
        } else {
            return false;
        }
    } else {
        return false;
    }
}
