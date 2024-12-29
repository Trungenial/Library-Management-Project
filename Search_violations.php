
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>THUVIEN</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>
        /* Tổng quan */
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
            margin: 0;
            padding: 20px;
        }

        .container {
            max-width: 900px;
            background-color: white;
            padding: 30px;
            margin: auto;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        h2 {
            text-align: center;
            font-weight: bold;
            color:rgb(221, 6, 6);
            margin-bottom: 10px;
            font-size: 22px;
        }

        label {
            font-weight: bold;
            color: #333;
        }

        .form-control, .form-check-input {
            border: 1px solid #ccc;
            border-radius: 5px;
            transition: all 0.3s;
        }

        .form-control:focus {
            border-color: #b71c1c;
            box-shadow: 0 0 5px rgba(183, 28, 28, 0.3);
        }

        .form-check-input:checked {
            background-color: #b71c1c;
            border-color: #b71c1c;
        }

        .total-fine {
            color: #b71c1c;
            font-weight: bold;
            font-size: 18px;
            text-align: center;
            margin-top: 15px;
        }

        textarea {
            resize: none;
            height: 80px;
        }

        .btn-custom {
            background-color: #b71c1c;
            color: white;
            border: none;
            padding: 8px 15px;
            margin: 5px;
            border-radius: 5px;
        }

        .btn-custom:hover {
            background-color: #8e1515;
        }

        .btn-secondary {
            margin: 5px;
            padding: 8px 15px;
        }

        .header {
            background: url('https://i.postimg.cc/G3Z1BVXj/Nen.png') no-repeat center center;
            background-size: cover;
            height: 185px;
            
        }
        /* Navbar */
        .navbar {
            background-color: #b71c1c;
            height: 50px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0 20px;
        }
        .navbar div {
            display: flex;
            align-items: stretch;
        }
        .navbar a {
            color: white;
            text-decoration: none;
            font-weight: bold;
            padding: 0 15px;
            display: flex;
            align-items: center;
            height: 100%;
            position: relative;
        }
        .navbar a:not(:last-child)::after {
            content: "";
            position: absolute;
            right: 0;
            top: 0;
            bottom: 0;
            width: 1px;
            background-color: white;
            opacity: 0.6;
        }
        .navbar a:hover {
            background-color: #8e1515;
            color: #ddd;
        }
        .navbar .user {
            display: flex;
            align-items: center;
        }
        .navbar .user a {
            color: white;
            text-decoration: none;
            margin-right: 15px;
        }
        .navbar .user i {
            margin-right: 5px;
        }
        .navbar .user img {
            width: 20px;
            margin-left: 10px;
        }
        :root {
            --circle-size: 16px; /* Đường kính hình tròn */
            --spacing: 80px; /* Khoảng cách giữa các hình tròn */
            --line-padding: 20px; /* Khoảng cách đường line hai bên */
            --left-panel-width: 267px; /* Chiều rộng phần XỬ LÝ VI PHẠM */
            --right-panel-width: 340px; /* Chiều rộng phần Stepper */
            --step-container-height: 63px; /* Chiều cao container Stepper */
            }

            .step-left {
              width: var(--left-panel-width);
              height: 100%;
              background: linear-gradient(to right,rgb(33, 50, 104),rgb(33, 50, 104)); /* Màu gradient đỏ */
              display: flex;
              align-items: center;
              justify-content: center;
              clip-path: polygon(0 0, 100% 0, 90% 100%, 0 100%); /* Hình thang vuông */
              color: #fff;
              font-size: 1rem;
              font-weight: bold;
              text-transform: uppercase;
            }

            /* Phần Ở Giữa (Trống) */
            .step-middle {
              flex: 1; /* Phần giữa chiếm phần còn lại */
              background-color: transparent; /* Phần giữa để trống */
            }

            /* Phần Bên Phải - Stepper */
            .step-right {
              width: var(--right-panel-width);
              height: 100%;
              background-color: #f9f9f9;
              display: flex;
              align-items: center;
              justify-content: center;
            }

            
/* Nội dung cuộn riêng biệt */
.violation-scrollable {
    max-height: 400px; /* Chiều cao tối đa */
    overflow-y: auto; /* Cho phép cuộn dọc */
    overflow-x: hidden; /* Ẩn cuộn ngang */
    border: 1px solid #ccc;
    padding: 15px;
    margin-top: 10px;
    background-color: #fff;
    border-radius: 5px;
}

/* Thanh cuộn tùy chỉnh */
.violation-scrollable::-webkit-scrollbar {
    width: 8px;
}

.violation-scrollable::-webkit-scrollbar-thumb {
    background-color:rgb(44, 28, 183);
    border-radius: 4px;
}

.violation-scrollable::-webkit-scrollbar-thumb:hover {
    background-color: #8e1515;
}

/* Nút cố định bên ngoài */
.violation-buttons {
    display: flex;
    justify-content: center;
    gap: 10px;
    margin-top: 20px;
    padding: 10px 0;
    border-top: 1px solid #ccc;
    background: #fff;
    border-radius: 5px;
    position: sticky;
    bottom: 0;
    z-index: 10;
}
.language-changed {
    animation: fadeIn 0.5s ease-in-out;
}
        /* Form Tìm kiếm */
        .search-section {
            background: #fdfdfd;
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 20px;
            margin-bottom: 20px;
        }

        .search-section label {
            font-weight: bold;
            margin-bottom: 10px;
            display: block;
        }

        .search-group {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .search-group input {
            flex: 1;
            border-radius: 8px;
            border: 1px solid #ccc;
            padding: 8px 12px;
            font-size: 14px;
        }

        .search-group .btn-custom {
            background-color: #b71c1c;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 8px;
            font-size: 14px;
            transition: background-color 0.3s;
        }

        .search-group .btn-custom:hover {
            background-color: #8e1515;
        }

        .search-group .btn-scan {
            background-color: #1e90ff;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 8px;
            font-size: 14px;
            transition: background-color 0.3s;
        }

        .search-group .btn-scan:hover {
            background-color: #1c86ee;
        }

        /* Bảng kết quả */
        .violation-scrollable {
            max-height: 400px;
            overflow-y: auto;
            border: 1px solid #ccc;
            padding: 15px;
            margin-top: 10px;
            background-color: #fff;
            border-radius: 5px;
        }

        .table th, .table td {
            text-align: center;
            vertical-align: middle;
        }

        .table th {
            background-color: #f1f1f1;
        }

        /* Modal Scan */
        .modal-overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            z-index: 1000;
            justify-content: center;
            align-items: center;
        }

        .modal-content {
            background: white;
            padding: 30px;
            border-radius: 10px;
            text-align: center;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .modal-content h3 {
            margin: 0;
            font-size: 20px;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <!-- Header -->
    <div class="header"></div>
    <!-- Navbar -->
    <div class="navbar">
        <div>
        <a href="#" data-lang-key="home">TRANG CHỦ</a>
        <a href="#" data-lang-key="news">TIN TỨC</a>
        <a href="#" data-lang-key="about">GIỚI THIỆU</a>
        <a href="#" data-lang-key="book_management">QUẢN LÝ SÁCH</a>
        <a href="#" data-lang-key="borrow_return">QUẢN LÝ MƯỢN - TRẢ SÁCH</a>
        <div class="dropdown">
            <a href="#" class="dropdown-toggle" data-bs-toggle="dropdown" data-lang-key="violation">XỬ LÝ VI PHẠM</a>
            <ul class="dropdown-menu">
                <li><a class="dropdown-item" href="handle_violations.php">Biên bản vi phạm</a></li>
                <li><a class="dropdown-item" href="Search_violations.php">Tra cứu vi phạm</a></li>
            </ul>
        </div>
        <a href="#" data-lang-key="guide">HƯỚNG DẪN</a>
        </div>
        <div class="user">
    <a href="#" data-lang-key="login"><i class="fas fa-user"></i> Đăng nhập</a>
    <img src="https://cdn-icons-png.flaticon.com/512/197/197473.png" alt="Vietnam" 
         onclick="changeLanguage('vi')" style="cursor: pointer;">
    <img src="https://cdn-icons-png.flaticon.com/512/197/197374.png" alt="English" 
         onclick="changeLanguage('en')" style="cursor: pointer;">
</div>
    </div>
    <div class="step-wrapper">
    <!-- Phần Bên Trái -->
    <div class="step-left" data-lang-key="violation">XỬ LÝ VI PHẠM</div>
    <!-- Phần Ở Giữa (Trống) -->
    <div class="step-middle"></div>
    <!-- Phần Bên Phải -->
    <div class="step-right"></div>
</div>
<div class="container">
        <h2>TRA CỨU THÔNG TIN</h2>
        <div class="search-section">
        <form method="GET" action="">
    <label for="search">Tìm kiếm mã sinh viên:</label>
    <div class="search-group">
        <input type="text" id="search" name="search" placeholder="Nhập mã sinh viên" required>
        <button type="submit" class="btn btn-custom">Tìm kiếm</button>
        <button type="button" class="btn btn-scan" onclick="showScanModal()">Scan</button>
    </div>
</form>

        </div>

        <!-- Bảng hiển thị thông tin -->
        <div class="violation-scrollable mt-4">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>Mã Sinh Viên</th>
                        <th>Họ và Tên</th>
                        <th>Khóa</th>
                        <th>Lớp</th>
                        <th>Số Điện Thoại</th>
                        <th>Email</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Kết nối CSDL
                    $conn = new mysqli('localhost', 'root', '', 'library');
                    if ($conn->connect_error) {
                        die("Kết nối thất bại: " . $conn->connect_error);
                    }

                    $search = isset($_GET['search']) ? trim($_GET['search']) : '';

                    if (!empty($search)) {
                        $stmt = $conn->prepare("SELECT student_id, CONCAT(first_name, ' ', last_name) AS student_name, class, course, phone_number, email 
                                               FROM student 
                                               WHERE student_id = ?");
                        $stmt->bind_param("s", $search);
                        $stmt->execute();
                        $result = $stmt->get_result();

                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                echo "<tr>
                                        <td>{$row['student_id']}</td>
                                        <td>{$row['student_name']}</td>
                                        <td>{$row['course']}</td>
                                        <td>{$row['class']}</td>
                                        <td>{$row['phone_number']}</td>
                                        <td>{$row['email']}</td>
                                      </tr>";
                            }
                        } else {
                            echo "<tr><td colspan='6' class='text-center'>Không tìm thấy kết quả.</td></tr>";
                        }

                        $stmt->close();
                    }
                    $conn->close();
                    ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Modal Scan -->
    <div class="modal-overlay" id="scanModal">
        <div class="modal-content">
            <h3>Vui lòng đưa thẻ sinh viên vào máy scan</h3>
        </div>
    </div>

    <script>
        function showScanModal() {
            document.getElementById('scanModal').style.display = 'flex';
            setTimeout(() => document.getElementById('scanModal').style.display = 'none', 3000);
        }
    </script>
</body>
</html>
