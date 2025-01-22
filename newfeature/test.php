<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
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