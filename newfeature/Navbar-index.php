<?php
    include_once('connect_data.php');

    $thongbao = "";
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
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Navbar</title>
    <!--CSS-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" 
    integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <!--JavaScript-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" 
    integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <style>
/* Navbar */
.navbar {
    background: linear-gradient(45deg, #b71c1c, #7c0a02); /* Gradient đỏ */
    display: flex;
    justify-content: space-between; /* Phân bố menu và user */
    align-items: center; /* Căn giữa các mục */
    padding: 5px 15px; /* Giảm chiều cao thêm */
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
    position: sticky;
    top: 0;
    z-index: 1000;
    transition: background-color 0.5s ease, box-shadow 0.5s ease;
}

/* Menu Navbar */
.navbar div:first-child {
    display: flex;
    gap: 15px; /* Giảm khoảng cách giữa các mục */
}

.navbar a {
    color: white;
    text-decoration: none;
    padding: 8px 15px; /* Giảm padding cho kích thước vừa phải */
    font-size: 16px;
    font-weight: bold;
    text-align: center;
    line-height: 0.8 ; /* Điều chỉnh chiều cao dòng */
    vertical-align: middle; /* Căn giữa theo chiều dọc */
    border-radius: 30px; /* Bo góc tròn mềm mại */
    background: rgba(255, 255, 255, 0.1); /* Nền mờ */
    backdrop-filter: blur(5px);
    transition: all 0.4s ease, transform 0.3s ease;
}

/* Hiệu ứng Hover */
.navbar a:hover {
    background: linear-gradient(45deg, #fff, #f0f0f0); /* Gradient sáng */
    color: #b71c1c; /* Chữ màu đỏ nổi bật */
    transform: translateY(-2px) scale(1.05); /* Nổi lên và phóng to nhẹ */
    box-shadow: 0 4px 10px rgba(255, 255, 255, 0.6);
}

/* Mục Được Chọn */
.navbar a.active {
    background: #ffffff; /* Nền trắng nổi bật */
    color: #b71c1c !important; /* Chữ đỏ */
    box-shadow: 0 4px 8px rgba(255, 255, 255, 0.4);
}

/* User Section */
.navbar .user {
    display: flex;
    align-items: center;
    gap: 10px; /* Giảm khoảng cách giữa các mục */
}

.navbar .user img {
    width: 20px; /* Thu nhỏ icon */
    height: 20px;
    cursor: pointer;
    transition: transform 0.4s ease, filter 0.3s ease;
}

.navbar .user img:hover {
    transform: rotate(20deg) scale(1.1); /* Xoay và phóng to nhẹ */
    filter: brightness(1.2);
}

.navbar .user a {
    color: white;
    font-weight: bold;
    background: rgba(255, 255, 255, 0.2); /* Nền mờ */
    padding: 5px 10px; /* Giảm padding */
    border-radius: 15px; /* Bo tròn hơn để phù hợp với kích thước nhỏ */
    transition: all 0.3s ease, transform 0.3s ease;
}

.navbar .user a:hover {
    background: linear-gradient(45deg, #ffffff, #f0f0f0); /* Gradient sáng */
    color: #b71c1c;
    transform: translateY(-2px); /* Nổi lên */
    box-shadow: 0 4px 10px rgba(255, 255, 255, 0.5);
}

    </style>
    <script>
        // Hiệu ứng Sticky Navbar
        window.addEventListener('scroll', () => {
            const navbar = document.querySelector('.navbar');
            if (window.scrollY > 50) {
                navbar.classList.add('sticky');
            } else {
                navbar.classList.remove('sticky');
            }
        });

        // Đổi ngôn ngữ
        function changeLanguage(lang) {
            alert(`Đã chuyển sang ngôn ngữ: ${lang}`);
        }
    </script>
</head>
<body>
<?php
$current_page = basename($_SERVER['PHP_SELF']); // Lấy tên file hiện tại
?>
<div class="navbar">
    <div>
        <a href="newfeature/Home.php" data-lang-key="home" class="<?php echo ($current_page == 'Home.php') ? 'active' : ''; ?>">TRANG CHỦ</a>
        <a href="#" data-lang-key="news" class="<?php echo ($current_page == 'news.php') ? 'active' : ''; ?>">TIN TỨC</a>
        <a href="#" data-lang-key="about" class="<?php echo ($current_page == 'about.php') ? 'active' : ''; ?>">GIỚI THIỆU</a>
        <a href="#" data-lang-key="guide" class="<?php echo ($current_page == 'guide.php') ? 'active' : ''; ?>">HƯỚNG DẪN</a>
    </div>
    <!--session & cookei-->
    <div style = "float: right">
        <?php
            if (isset($_SESSION["admin"]) || isset($_COOKIE["admin"])){
                $username = isset($_SESSION["admin"])?$_SESSION["admin"]:$_COOKIE["admin"];
        ?>
        <span style = "color : white">
            Xin chào <?php echo $username; ?>
        </span>
        <button class="btn btn-success btn-lg mt-3 float-end"><a href = "./pages/logout.php">Đăng xuất</a></button>
        <img src="https://cdn-icons-png.flaticon.com/512/197/197473.png" alt="Vietnam" 
             onclick="changeLanguage('vi')" style="cursor: pointer;">
        <img src="https://cdn-icons-png.flaticon.com/512/197/197374.png" alt="English" 
             onclick="changeLanguage('en')" style="cursor: pointer;">
        <?php }
            else {?>
            <div class="user">
        <a href="./pages/login.php" data-lang-key="login" style = "float: right"><i class="fas fa-user" ></i>Đăng nhập</a>
        <img src="https://cdn-icons-png.flaticon.com/512/197/197473.png" alt="Vietnam" 
             onclick="changeLanguage('vi')" style="cursor: pointer;">
        <img src="https://cdn-icons-png.flaticon.com/512/197/197374.png" alt="English" 
             onclick="changeLanguage('en')" style="cursor: pointer;">
    </div>
        <?php } ?>
    </div>
    
    <!--<div class="user">
        <a href="../pages/login.php" data-lang-key="login" style = "float: right"><i class="fas fa-user" ></i> Đăng nhập</a>
        <img src="https://cdn-icons-png.flaticon.com/512/197/197473.png" alt="Vietnam" 
             onclick="changeLanguage('vi')" style="cursor: pointer;">
        <img src="https://cdn-icons-png.flaticon.com/512/197/197374.png" alt="English" 
             onclick="changeLanguage('en')" style="cursor: pointer;">
    </div>-->
</div>

</body>
</html>
