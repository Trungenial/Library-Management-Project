<?php
    include_once ('config.php');?>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ADMIN</title>
    <!--CSS-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" 
    integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <!--Java script-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" 
    integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</head>
<body>
    <h1>ĐÂY LÀ TRANG WED CỦA ADMIN</h1>
    <!--session & cookei-->
    <div style = "float: right">
        <?php
            if (isset($_SESSION["admin"]) || isset($_COOKIE["admin"])){
                $username = isset($_SESSION["admin"])?$_SESSION["admin"]:$_COOKIE["admin"];
        ?>
        <span style = "color : black">
            Xin chào <?php echo $username; ?>
        </span>
        <button class="btn btn-success btn-lg mt-3 float-end"><a href = "logout.php">Đăng xuất</a></button>
        <?php } ?>
    </div>
</body>
</html>