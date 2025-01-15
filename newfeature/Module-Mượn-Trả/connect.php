<?php
    $servername="localhost";
    $username="trntru6_library";
    $password="group1";
    $dbname="trntru6_library";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if($conn->connect_error){
        die("failed".$conn->connect_error);   
    }
?>