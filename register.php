<?php
    include_once ('config.php');?>

<?php
    $thongbao = "";
    if (isset($_POST['submit'])){
        $username = mysqli_real_escape_string($conn, strip_tags($_POST ['username']));
        $password = password_hash(mysqli_real_escape_string($conn, strip_tags($_POST ['password'])), PASSWORD_BCRYPT);
        $repassword = password_hash(mysqli_real_escape_string($conn, strip_tags($_POST ['repassword'])), PASSWORD_BCRYPT);
        if (isset($_POST['email'])) {
            $email = mysqli_real_escape_string($conn, strip_tags($_POST['email']));
            $checkemail = $conn->query("SELECT * FROM users WHERE email = '$email'");
        } else {
            $thongbao = "Vui lòng nhập địa chỉ email";
        }

        if ($username == "" || $password == "" || empty($email)) {
            $thongbao = "Vui lòng nhập đầy đủ thông tin";
        } 
        elseif (!password_verify($_POST['repassword'], $password)) {
            $thongbao = "Mật khẩu không khớp";
        } 
        elseif ($checkemail->num_rows != 0) {
            $thongbao = "Email đã tồn tại";
        }
        else {
            $hiepdz = $conn->query("INSERT INTO users SET 
            username = '$username', password = '$password', email = '$email'");
            $_SESSION['username'] = $username;
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng kí</title>
        <!--CSS-->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" 
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
        <!--Java script-->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" 
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</head>
<body>
<form method = "post">
  <div class="mb-3">
  <?php
    if ($thongbao != ""){ ?>
        <div class = "alert alert-danger"> <?= $thongbao?> </div>   
    <?php } ?>
    <label for="exampleInputEmail1">Username</label>
    <input type="text" class="form-control" id="username" name = "username" aria-describedby="emailHelp" placeholder="username">
  </div>
  <div class="mb-3">
    <label for="exampleInputPassword1">Password</label>
    <input type="password" class="form-control" id="password" name = "password" placeholder="Password">
  </div>
  <div class="mb-3">
    <label for="exampleInputPassword1">RePassword</label>
    <input type="password" class="form-control" id="repassword" name = "repassword" placeholder="RePassword">
  </div>
  <div class="mb-3">
    <label for="exampleInputPassword1">Email</label>
    <input type="email" class="form-control" id="email" name = "email" placeholder="email">
  </div>
  <button type="submit" class="btn btn-primary mt-3" id = "submit" name = "submit">Submit</button>
</form>
</body>
</html>