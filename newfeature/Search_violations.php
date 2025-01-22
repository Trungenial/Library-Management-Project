<?php
session_start();

if ($_SESSION['admin'] == null || $_SESSION['admin'] == '' || !isset($_SESSION['admin'])) {
    header('Location: ../index.php');
    exit();
} else {
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TimKiem</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="Handle_violations.css">
</head>
<body>
    <!-- Header -->
    <div class="header"></div>
    <!-- Navbar -->
    <?php 
    $current_page = basename($_SERVER['PHP_SELF']); 
        include 'Navbar.php';
    ?>
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
                        <th>MSSV</th>
                        <th>HỌ VÀ TÊN</th>
                        <th>KHÓA</th>
                        <th>LỚP SINH HOẠT</th>
                        <th>SỐ ĐIỆN THOẠI</th>
                        <th>EMAIL</th>
                    </tr>
                </thead>
                <tbody>
                <tbody>
                <?php
$conn = new mysqli('localhost', 'trntru6_library', 'group1', 'trntru6_library');
if ($conn->connect_error) {
    die("Kết nối thất bại: " . $conn->connect_error);
}

// Lấy dữ liệu tìm kiếm
$search = isset($_GET['search']) ? trim($_GET['search']) : '';

// Xây dựng câu lệnh SQL
if (!empty($search)) {
    // Truy vấn khi có tìm kiếm
    $sql = "SELECT student_id, CONCAT(first_name, ' ', last_name) AS student_name, class, course, phone_number, email 
            FROM student 
            WHERE student_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $search);
} else {
    // Truy vấn tất cả sinh viên
    $sql = "SELECT student_id, CONCAT(first_name, ' ', last_name) AS student_name, class, course, phone_number, email 
            FROM student";
    $stmt = $conn->prepare($sql);
}

// Thực thi truy vấn
$stmt->execute();
$result = $stmt->get_result(); 
// Kiểm tra kết quả và hiển thị dữ liệu
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "<tr>
                <td><a href='Information_violations.php?student_id={$row['student_id']}'>{$row['student_id']}</a></td>
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

// Đóng kết nối
$stmt->close();
$conn->close();
?>


</tbody>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Modal Scan -->
    <div class="modal-overlay" id="scanModal">
    <div class="modal-content">
        <h3>Đang quét mã sinh viên...</h3>
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
<?php
}