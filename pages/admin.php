<!DOCTYPE html>
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
    <?php if (isset($_SESSION["username"]) || isset($_COOKIE["username"])){
            $username = isset($_SESSION["username"])?$_SESSION["username"]:$_COOKIE["username"];
        ?>
        <span style = "color : black">
            Xin chào Admin: <?php echo $username; ?>
        </span>
        <a href = "logout.php"><button type="button" class="btn btn-success btn-lg mt-3 m-3 float-end" id = "submit" name = "submit">
        Đăng xuất
    </button></a>
        <?php } ?>
</body>
</html>