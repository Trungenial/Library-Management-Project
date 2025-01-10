<?php
    session_start();
    unset($_SESSION["username"]);
    if (isset($_COOKIE["username"])) {
        setcookie("username", "", time() - 300, "/");
    }
    header("Location: home.php");
?>