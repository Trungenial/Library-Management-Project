
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thongtin</title>
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
?>
    <div class="navbar">
        <div>
        <a href="#" data-lang-key="home">TRANG CHỦ</a>
        <a href="#" data-lang-key="news">TIN TỨC</a>
        <a href="#" data-lang-key="about">GIỚI THIỆU</a>
        <a href="#" data-lang-key="book_management">QUẢN LÝ SÁCH</a>
        <a href="#" data-lang-key="borrow_return">QUẢN LÝ MƯỢN - TRẢ SÁCH</a>
        <a href="Search_violations.php" data-lang-key="violation" 
           class="<?php echo ($current_page == 'Handle_violations.php' || $current_page == 'Information_violations.php' || $current_page == 'Search_violations.php') ? 'active' : ''; ?>">
           XỬ LÝ VI PHẠM
        </a>
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
<!-- Bảng hiển thị thông tin vi phạm -->
<div class="violation-scrollable mt-4">
    <table class="table table-bordered table-striped"><tbody>
        <?php
$conn = new mysqli('localhost', 'root', '', 'library');
if ($conn->connect_error) {
    die("Kết nối thất bại: " . $conn->connect_error);
}

$student_id = isset($_GET['student_id']) ? $_GET['student_id'] : '';

if (!empty($student_id)) {
    // Lấy thông tin sinh viên
    $stmt = $conn->prepare("SELECT student_id, CONCAT(first_name, ' ', last_name) AS student_name, class, course, phone_number, email 
                            FROM student 
                            WHERE student_id = ?");
    $stmt->bind_param("s", $student_id);
    $stmt->execute();
    $student_result = $stmt->get_result();
    $student = $student_result->fetch_assoc();

    echo "<h2>THÔNG TIN SINH VIÊN</h2>";
    echo "<div class='row student-info'>";
    echo "  <div class='col-md-6'>";
    echo "      <p><strong>MSSV:</strong> {$student['student_id']}</p>";
    echo "      <p><strong>Họ và tên:</strong> {$student['student_name']}</p>";
    echo "      <p><strong>Khóa:</strong> {$student['course']}</p>";
    echo "  </div>";
    echo "  <div class='col-md-6'>";
    echo "      <p><strong>Lớp:</strong> {$student['class']}</p>";
    echo "      <p><strong>SĐT:</strong> {$student['phone_number']}</p>";
    echo "      <p><strong>Email:</strong> {$student['email']}</p>";
    echo "  </div>";
    echo "</div>";
    // Lấy thông tin vi phạm từ book_loan
    echo "<h2>DANH SÁCH VI PHẠM </h2>";
    echo "<table class='table table-bordered table-striped'>
            <thead>
                <tr>
                    <th>STT</th>
                    <th>Mã số sách</th>
                    <th>Tên sách</th>
                    <th>Ngày mượn</th>
                    <th>Ngày trả</th>
                    <th>Số ngày đã mượn</th>
                </tr>
            </thead>
            <tbody>";

    $stmt = $conn->prepare("SELECT b.book_id, b.book_title, bl.borrow_date, bl.actual_return_date, 
DATEDIFF(bl.actual_return_date, bl.borrow_date) AS days_borrowed,
IFNULL(bl.renewal_count, 0) AS renewals,
DATEDIFF(CURDATE(), bl.expected_return_date) AS overdue_days
FROM book_loan bl
JOIN book b ON bl.book_id = b.book_id
WHERE bl.student_id = ?
");
    $stmt->bind_param("s", $student_id);
    $stmt->execute();
    $violation_result = $stmt->get_result();

    if ($violation_result->num_rows > 0) {
        $stt = 1;
        while ($row = $violation_result->fetch_assoc()) {
            echo "<tr onclick='selectRow(this, {$row['book_id']})' style='cursor: pointer;'>
            <td>{$stt}</td>
            <td>{$row['book_id']}</td>
            <td>{$row['book_title']}</td>
            <td>{$row['borrow_date']}</td>
            <td>{$row['actual_return_date']}</td>
            <td>{$row['days_borrowed']}</td>
          </tr>";
    
            $stt++;
        }
    } else {
        echo "<tr><td colspan='8' class='text-center'>Không có dữ liệu vi phạm.</td></tr>";
    }
    echo "</tbody></table>";
    $stmt->close();
}
$conn->close();
?>
<!-- Nút Biên bản vi phạm -->
<div class="text-center mt-4">
<button id="violationReportBtn" class="btn btn-secondary" disabled>Biên bản vi phạm</button>
</div>
<script>
    let selectedRow = null;
    let selectedBookLoanId = null;

    // Hàm chọn dòng
    function selectRow(row, bookLoanId) {
        // Bỏ chọn dòng trước đó (nếu có)
        if (selectedRow) {
            selectedRow.classList.remove('table-active');
        }

        // Chọn dòng mới
        selectedRow = row;
        selectedBookLoanId = bookLoanId;
        row.classList.add('table-active'); // Thêm lớp CSS để đổi màu

        // Kích hoạt nút Biên bản vi phạm
        const violationBtn = document.getElementById('violationReportBtn');
        violationBtn.classList.remove('btn-secondary');
        violationBtn.classList.add('btn-custom');
        violationBtn.disabled = false;
    }



 document.getElementById('violationReportBtn').addEventListener('click', function () {
    if (!selectedRow) {
        alert('Vui lòng chọn một dòng trước khi tiếp tục.');
        return;
    }

    try {
        const cells = selectedRow.querySelectorAll('td');
        if (cells.length === 0) {
            throw new Error('Không tìm thấy dữ liệu trong dòng đã chọn.');
        }

        const bookLoanId = cells[0].innerText.trim();
        if (!bookLoanId) {
            throw new Error('Mã mượn sách không hợp lệ.');
        }

        const url = `Handle_violations.php?book_loan_id=${encodeURIComponent(bookLoanId)}`;
        window.location.href = url;
    } catch (error) {
        console.error(error);
        alert(`Lỗi: ${error.message}`);
    }
});




    
</script>

        </tbody>
    </table>
</div>



       
    
</body>
</html>
