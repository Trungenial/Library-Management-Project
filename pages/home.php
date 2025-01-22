<?php
    session_start();
    include_once('config.php');

    $thongbao = "";
    $x = $_POST['submit'];
    if (isset($_POST['submit'])) {
        $username = $_POST['username'];
        $password = $_POST['password'];
        $checktype = $_POST['check'];
        $checkuser = $conn->query("SELECT * FROM users WHERE username = '" . $conn->real_escape_string($username) . "'")->fetch_array();

        if ($username == "" || $password == "") {
            $thongbao = "Vui lòng nhập đầy đủ thông tin";
        } else if (empty($checkuser) || $checktype != $checkuser['role_id'] || $checktype != 1) {
            $thongbao = "Tên tài khoản không tồn tại";
        } else if (!password_verify($password, $checkuser['password'])) {
            $thongbao = "Sai mật khẩu";
        } else {
            $_SESSION['username'] = $username;
            setcookie("username", $username, time() + 300, "/");
            header("Location:home.php");
        }
    }

    // Đăng nhập vào tài khoản admin
    if (isset($_POST['submit'])) {
        $username = $_POST['username'];
        $password = $_POST['password'];
        $checktype = $_POST['check'];
        $checkadmin = $conn->query("SELECT * FROM users WHERE username = '" . $conn->real_escape_string($username) . "'")->fetch_array();

        if (!empty($checkadmin) && $username == $checkadmin['username'] && password_verify($password, $checkuser['password']) 
        && $checktype == $checkadmin['role_id'] && $checktype != 1) {
            
            $_SESSION['admin'] = $username;
            setcookie("admin", $username, time() + 300, "/");
            header("Location:admin.php");
        }
    }
?>

  <!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title></title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="">
    <!--CSS-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <!--JavaScript-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</head>
<body>
    <!--session & cookei-->
    <div style = "float: right">
        <?php
            if (isset($_SESSION["username"]) || isset($_COOKIE["username"])){
                $username = isset($_SESSION["username"])?$_SESSION["username"]:$_COOKIE["username"];
        ?>
        <span style = "color : black">
            Xin chào <?php echo $username; ?>
        </span>
        <button class="btn btn-success btn-lg mt-3 float-end"><a href = "logout.php">Đăng xuất</a></button>
        <?php }
            else {?>
            <button type="button" class="btn btn-success btn-lg mt-3 m-3 float-end" data-bs-toggle="modal" data-bs-target="#login">
            Đăng nhập
            </button>
        <?php } ?>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="login" tabindex="-1" aria-labelledby="modelTitleId" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modelTitleId">Độc giả đăng nhập</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- form đăng nhập -->
                    <form method="POST">
                        <?php
                        if (isset($_POST['submit']) && $thongbao != ""){ ?>
                            <div class="alert alert-danger"><?= $thongbao ?></div>
                        <?php 
                        echo '<script> location.href = "login.php"</script>';} ?>
                        <div class="mb-3" style = "display: flex; justify-content: center; gap: 20px;">
                        <label>
                            <input type="radio" name="check" value="1" checked> Sinh viên
                        </label>
                        <label>
                            <input type="radio" name="check" value="2"> Thủ thư
                        </label>
                        <label>
                            <input type="radio" name="check" value="3"> Giám đốc
                        </label>
                        </div>
                        <div class="mb-3" >
                            <input type="text" class="form-control" id="username" name="username" aria-describedby="emailHelp" placeholder="Mã số thẻ">
                        </div>
                        <div class="mb-3">
                            <input type="password" class="form-control" id="password" name="password" placeholder="Mật khẩu">
                        </div>
                        <div class="text-center">
                            <button type="submit" class="btn btn-primary px-5 mb-2 w-50" name="submit">Đăng nhập</button>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                </div>
            </div>
        </div>
    </div>
</body>
</html>