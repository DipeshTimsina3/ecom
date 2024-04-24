<?php

$HOST = "localhost";
$USER = "root";
$PASS = "";
$DB = "ecom2";



$CON = mysqli_connect($HOST, $USER, $PASS, $DB);

if (!$CON) {
    die("Connection Failed: ");
}
