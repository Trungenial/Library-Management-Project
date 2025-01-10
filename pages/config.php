<?php
    session_start();
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "wedtest";

    $conn = @mysqli_connect($servername, $username, $password, $dbname);
?>
