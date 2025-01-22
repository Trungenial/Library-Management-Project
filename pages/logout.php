<?php
    session_start();
    unset($_SESSION["admin"]);
    if (isset($_COOKIE["admin"])) {
        setcookie("admin", "", time() - 300, "/");
    }
    header("Location:../index.php");
?>