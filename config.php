<?php

$host = "localhost";
$user = "root";
$password = '';
$db_name = "info_project";

$db = mysqli_connect($host, $user, $password, $db_name);
if (!$db) {

    echo "Connection failed!";
}
if (mysqli_connect_errno()) {
    die("Failed to connect with MySQL: " . mysqli_connect_error());
}
