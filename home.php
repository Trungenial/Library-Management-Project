<?php
    include_once ('config.php');?>

<?php
    $thongbao = "";
    if (isset($_POST['submit'])){
        $username = $_POST['username'];
        $password = $_POST['password'];
        $checkuser = $conn->query("SELECT * FROM users WHERE 
        username = '".$conn->real_escape_string($username)."'")->fetch_array();
        if ($username == "" || $password == ""){
            $thongbao = "Vùi lòng nhập đầy đủ thông tin";
        }
        else if (empty($checkuser)){
            $thongbao = "Tên tài khoản không tồn tại";
        }
        else if (!password_verify($password, $checkuser['password'])){
            $thongbao = "Sai mật khẩu";
        }
        else 
        {
            $_SESSION['username'] = $username;
            echo '<script> location.href = ""</script>';
        }
    }

    // đăng nhập vào tài khoản admin
    if (isset($_POST['submit'])){
        $username = $_POST['username'];
        $password = $_POST['password'];
        $checkuser = $conn->query("SELECT * FROM 'admin' WHERE 
        username = '".$conn->real_escape_string($username)."'")->fetch_array();
        if ($username == $checkuser['username'] && $password == $checkuser['password']){
            $_SESSION['username'] = $username;
            echo '<script> location.href = "admin.php"</script>';
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
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" 
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
        <!--Java script-->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" 
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
        <!--chỉnh nut button qua bên trái-->
        <style>

        </style>
    </head>
    <body>
           <!-- Button trigger modal -->
    <button type="button" class="btn btn-success btn-lg mt-3 m-3 float-end" data-bs-toggle="modal" data-bs-target="#login">
        Đăng nhập
    </button>
    <a href = "logout.php"><button type="button" class="btn btn-success btn-lg mt-3 float-end" id = "submit" name = "submit">
        Đăng xuất
    </button></a>
    <!-- Modal -->
    <div class="modal fade" id="login" tabindex="-1" aria-labelledby="modelTitleId" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modelTitleId">Độc giả đăng nhập</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!--form đăng nhập-->
                    <form method = "POST">
                        <div class="mb-3">
                            <?php
                            if (isset($_POST['submit']) && $thongbao != ""){ ?>
                                <div class = "alert alert-danger"> <?= $thongbao?> </div>
                            <?php 
                            echo '<script> location.href = "login.php"</script>';
                            } ?>
                            <input type="text" class="form-control" id="username" name  = "username" aria-describedby="emailHelp"
                              placeholder="Mã số thẻ">
                          </div>
                          <div class="mb-3">
                            <input type="password" class="form-control" id="password" name = "password" placeholder="Mật mã">
                          </div>
                          <div class="text-center"><button type="submit" 
                            class="btn btn-primary px-5 mb-2 w-50" id = "submit" name = "submit">Đăng nhập</button></div>
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