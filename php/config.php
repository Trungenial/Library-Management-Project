<?php
    $servername = "localhost";
    $username = "trntru6_library";
    $password = "group1";
    $dbname = "trntru6_library";

    $conn = @mysqli_connect($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Kết nối thất bại: " . $conn->connect_error);
    }
?>