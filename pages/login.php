<?php
    session_start();
    include_once ('config.php');?>
<?php
    $thongbao = "";
    if (isset($_POST['submit'])){
        $username = $_POST['username'];
        $password = $_POST['password'];
        $checktype = $_POST['check'];
        $checkuser = $conn->query("SELECT * FROM users WHERE 
        username = '".$conn->real_escape_string($username)."'")->fetch_array();
        if ($username == "" || $password == ""){
            $thongbao = "Vùi lòng nhập đầy đủ thông tin";
        }
        else if (empty($checkuser) || $checktype != $checkuser['role_id'] || $checktype != 1){
            $thongbao = "Tên tài khoản không tồn tại";
        }
        else if ($password != $checkuser['password']){
            $thongbao = "Sai mật khẩu";
        }
        else 
        {
            
            $_SESSION['username'] = $username;
            setcookie("username", $username, time() + 300, "/");
            header("Location:../index.php");
        }
    } 

    // đăng nhập vào tài khoản admin
    if (isset($_POST['submit'])){
        $username = $_POST['username'];
        $password = $_POST['password'];
        $checktype = $_POST['check'];
        $checkadmin = $conn->query("SELECT * FROM users WHERE 
        username = '".$conn->real_escape_string($username)."'")->fetch_array();
        if (!empty($checkadmin) && $username == $checkadmin['username'] && $password == $checkadmin['password']
        && $checktype == $checkadmin['role_id'] && $checktype != 1) {
            
            $_SESSION['admin'] = $username;
            setcookie("admin", $username, time() + 3000, "/");
            header("Location:../newfeature/Home.php");
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <!--CSS-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" 
    integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <!--Java script-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" 
    integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</head>
<body>
<form method = "POST" target="login.php">
    <div class="mb-3">
        <?php
        if (isset($_POST['submit']) && $thongbao != ""){ ?>
            <div class = "alert alert-danger"> <?= $thongbao?> </div>
        <?php 
        } ?>
        <div class="container">
            <div class="row">
              <div class="col-md-6 offset-md-3">
                <div class="card my-5">
                  <form class="card-body cardbody-color p-lg-5">
                  <h5 class="text-center text-dark mt-3"></h5>
                    <h3 class="text-center text-dark mt-3">Đăng nhập</h3>
                    <div class="text-center">
                      <img src="../images/logo.png" class="img-fluid profile-image-pic img-thumbnail rounded-circle my-3"
                        width="200px" alt="profile">
                    </div>
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
                    <div class="mb-3">
                    <input type="text" class="form-control" id="username" name  = "username" aria-describedby="emailHelp"
                    placeholder="Mã số thẻ">
                    </div>
                    <div class="mb-3">
                    <input type="password" class="form-control" id="password" name = "password" placeholder="Mật mã">
                    </div>
                    <div class="text-center"><button type="submit" 
                    class="btn btn-primary px-5 mb-2 w-50" id = "submit" name = "submit">Đăng nhập</button>
                    <a href="../index.php" class="btn btn-primary px-5 w-50 mb-3">Trang chủ</a>
                    </div>
                  </form>
                </div>
              </div>
            </div>
          </div>
        <!--<label></label>
        <input type="text" class="form-control" id="username" name  = "username" aria-describedby="emailHelp"
            placeholder="Mã số thẻ">
        </div>
        <div class="mb-3">
        <input type="password" class="form-control" id="password" name = "password" placeholder="Mật mã">
        </div>
        <div class="text-center"><button type="submit" 
        class="btn btn-primary px-5 mb-2 w-50" id = "submit" name = "submit">Đăng nhập</button>
    </div>-->
</form>
</body>
</html>