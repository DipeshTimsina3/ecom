<?php

$HOST = "localhost";
$USER = "root";
$PASS = "";
$DB = "ecom";



$CON = mysqli_connect($HOST, $USER, $PASS, $DB);

if (!$CON) {
    die("Connection Failed: ");
}
