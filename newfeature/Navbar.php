<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Navbar</title>
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
        <a href="Home.php" data-lang-key="home" class="<?php echo ($current_page == 'Home.php') ? 'active' : ''; ?>">TRANG CHỦ</a>
        <a href="news.php" data-lang-key="news" class="<?php echo ($current_page == 'news.php') ? 'active' : ''; ?>">TIN TỨC</a>
        <a href="about.php" data-lang-key="about" class="<?php echo ($current_page == 'about.php') ? 'active' : ''; ?>">GIỚI THIỆU</a>
        <a href="book_management.php" data-lang-key="book_management" class="<?php echo ($current_page == 'book_management.php') ? 'active' : ''; ?>">QUẢN LÝ SÁCH</a>
        <a href="borrow_return.php" data-lang-key="borrow_return" class="<?php echo ($current_page == 'borrow_return.php') ? 'active' : ''; ?>">QUẢN LÝ MƯỢN - TRẢ SÁCH</a>
        <a href="Search_violations.php" data-lang-key="violation" class="<?php echo ($current_page == 'Handle_violations.php' || $current_page == 'Information_violations.php' || $current_page == 'Search_violations.php') ? 'active' : ''; ?>">XỬ LÝ VI PHẠM</a>
        <a href="guide.php" data-lang-key="guide" class="<?php echo ($current_page == 'guide.php') ? 'active' : ''; ?>">HƯỚNG DẪN</a>
    </div>
    <div class="user">
        <a href="login.php" data-lang-key="login"><i class="fas fa-user"></i> Đăng nhập</a>
        <img src="https://cdn-icons-png.flaticon.com/512/197/197473.png" alt="Vietnam" 
             onclick="changeLanguage('vi')" style="cursor: pointer;">
        <img src="https://cdn-icons-png.flaticon.com/512/197/197374.png" alt="English" 
             onclick="changeLanguage('en')" style="cursor: pointer;">
    </div>
</div>

</body>
</html>
