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
            echo '<script> location.href = "home.php"</script>';
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <!--CSS-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" 
    integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <!--Java script-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" 
    integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

</head>
<body>
<form method = "POST">
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
                  <h5 class="text-center text-dark mt-3">Bạn đã nhập sai thông tin vui lòng nhập lại</h5>
                    <h3 class="text-center text-dark mt-3">Độc giả đăng nhập</h3>
                    <div class="text-center">
                      <img src="images/logo.png" class="img-fluid profile-image-pic img-thumbnail rounded-circle my-3"
                        width="200px" alt="profile">
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
                    <a href="home.php" class="btn btn-primary px-5 w-50 mb-3">Trang chủ</a>
                    </div>
                  </form>
                </div>
              </div>
            </div>
          </div>
        <!--<label><h5> Độc giả đăng nhập</h5></label>
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

