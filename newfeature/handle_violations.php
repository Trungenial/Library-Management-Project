<?php
session_start();

if ($_SESSION['admin'] == null || $_SESSION['admin'] == '' || !isset($_SESSION['admin'])) {
    header('Location: ../index.php');
    exit();
} else {
?>
<?php
require 'connect_data.php';

$bookLoanId = isset($_GET['book_loan_id']) ? intval($_GET['book_loan_id']) : 0;
$maBienBan = generateViolationId($conn);
$bookLoanData = [];
$overdueDays = 0;

if ($bookLoanId) {
    $stmt = $conn->prepare("
        SELECT bl.student_id, CONCAT(s.first_name, ' ', s.last_name) AS student_name, 
               bl.book_id, bl.borrow_date, bl.actual_return_date, bl.expected_return_date, b.base_price
        FROM book_loan bl
        JOIN student s ON bl.student_id = s.student_id
        JOIN book b ON bl.book_id = b.book_id
        WHERE bl.book_loan_id = ?
    ");
    $stmt->bind_param("i", $bookLoanId);
    $stmt->execute();
    $result = $stmt->get_result();
    $bookLoanData = $result->fetch_assoc();

    // Lấy số ngày quá hạn
    $overdueDays = getOverdueDays($conn, $bookLoanId);
}

// Xử lý lưu biên bản
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $description = $_POST['moTa'] ?? '';
    $fineAmount = intval($_POST['hiddenTongTienPhat'] ?? 0);
    $numberOfPagesDamaged = intval($_POST['hiddenSoTrang'] ?? 0);
    $studentId = intval($_POST['maThe'] ?? 0);
    $bookId = intval($_POST['maSach'] ?? 0);
    $violationHandling = implode(', ', $_POST['violationHandling'] ?? []);

    // Lấy giá sách nếu mất sách
    if (in_array('Mất sách', $_POST['violationHandling'] ?? [])) {
        $fineAmount += getBookBasePrice($conn, $bookId);
    }
    
    // Lưu vào CSDL
    $stmt = $conn->prepare("
        INSERT INTO violation_report 
        (description, report_date, number_of_damaged_pages, violation_handling, fine_amount, student_id, book_id, librarian_id) 
        VALUES (?, NOW(), ?, ?, ?, ?, ?, 10)
    ");
    $stmt->bind_param("sisiii", $description, $numberOfPagesDamaged, $violationHandling, $fineAmount, $studentId, $bookId);

    if ($stmt->execute()) {
        echo "<script>alert('Biên bản đã được lưu thành công!');</script>";
    } else {
        echo "<script>alert('Lỗi khi lưu biên bản: " . $stmt->error . "');</script>";
    }
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Biên bản vi phạm</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
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
    <div class="step-right">
        <div class="c-stepper">
            <div class="c-stepper__item" id="step-draft">
                <div class="c-stepper__title" data-lang-key="step_input">NHẬP</div>
            </div>
            <div class="c-stepper__item" id="step-confirm">
                <div class="c-stepper__title" data-lang-key="step_confirm">XÁC NHẬN</div>
            </div>
            <div class="c-stepper__item" id="step-email">
                <div class="c-stepper__title" data-lang-key="step_email">IN/GỬI EMAIL</div>
            </div>
        </div>
    </div>
</div>

    <div class="container">
    <h2 data-lang-key="violation_report">BIÊN BẢN VI PHẠM</h2>
        <form method="POST">
        <!-- Mã biên bản và Mã thẻ SV -->
        <div class="violation-scrollable">
            <!-- Mã biên bản -->
            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="maBienBan">Mã biên bản </label>
                    <input type="text" class="form-control" id="maBienBan" name="maBienBan" value="<?php echo $maBienBan; ?>" readonly>
                </div>
            </div>
            <!-- Thông tin -->
            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="maThe">Mã số sinh viên </label>
                    <input type="text" class="form-control" id="maThe" name="maThe" value="<?php echo $bookLoanData['student_id'] ?? ''; ?>" readonly>
                </div>
                <div class="col-md-6">
                    <label for="hoTen">Họ và tên </label>
                    <input type="text" class="form-control" id="hoTen" value="<?php echo $bookLoanData['student_name'] ?? ''; ?>" readonly>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="maSach">Mã số sách </label>
                    <input type="text" class="form-control" id="maSach" name="maSach" value="<?php echo $bookLoanData['book_id'] ?? ''; ?>" readonly>
                </div>
                <div class="col-md-6">
                    <label for="ngayMuon">Ngày mượn sách:</label>
                    <input type="date" class="form-control" id="ngayMuon" value="<?php echo $bookLoanData['borrow_date'] ?? ''; ?>" readonly>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="ngayPhaiTra">Ngày phải trả sách:</label>
                    <input type="date" class="form-control" id="ngayPhaiTra" value="<?php echo $bookLoanData['expected_return_date'] ?? ''; ?>" readonly>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="ngayTra">Ngày trả sách thực tế:</label>
                    <input type="date" class="form-control" id="ngayTra" value="<?php echo $bookLoanData['actual_return_date'] ?? ''; ?>" readonly>
                </div>
            </div>
            <!-- Nội dung vi phạm -->
            <div class="row mb-3">
                <label class="mb-2">Nội dung vi phạm:</label>
                <div class="col-md-4">
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input" id="quaHan" onchange="updateDescription()">
                        <label for="quaHan" class="form-check-label">Quá hạn</label>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input" id="huSach" onchange="updateDescription()">
                        <label for="huSach" class="form-check-label">Hư sách</label>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input" id="matSach" onchange="updateDescription()">
                        <label for="matSach" class="form-check-label">Mất sách</label>
                    </div>
                </div>
            </div>
            <!-- Mô tả nội dung vi phạm -->
            <div class="row mb-3">
                <label for="moTa">Mô tả nội dung vi phạm:</label>
                <textarea id="moTa" name="moTa" class="form-control" placeholder="Nhập mô tả chi tiết"></textarea>
            </div>
            <!-- Số ngày quá hạn -->
            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="soNgay">Số ngày quá hạn:</label>
                    <input type="number" class="form-control" id="soNgay" readonly>
                </div>
                <div class="col-md-6">
                    <label for="tienPhat">Tiền phạt (VNĐ)</label>
                    <input type="text" class="form-control" id="tienPhat" readonly>
                </div>
            </div>
            <!-- Số trang hư -->
            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="soTrang">Số trang hư hại:</label>
                    <input type="number" class="form-control" id="soTrang" oninput="updateFine()">
                </div>
                <div class="col-md-6">
                    <label for="tienPhatTrang">Tiền phạt (VNĐ)</l
                    abel>
                    <input type="text" class="form-control" id="tienPhatTrang" readonly>
                </div>
            </div>
            <!-- Hình thức xử lý -->
            <div class="row mb-3">
                <label class="mb-2">Hình thức xử lý:</label>
                <div class="col-md-6">
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input" id="phatTien" name="violationHandling[]" value="Phạt tiền">
                        <label for="phatTien" class="form-check-label">Phạt tiền</label>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input" id="traSach" name="violationHandling[]" value="Trả sách">
                        <label for="traSach" class="form-check-label">Trả sách</label>
                    </div>
                </div>
            </div>
        </div>
        <input type="hidden" id="hiddenSoTrang" name="hiddenSoTrang">
        <input type="hidden" id="hiddenTongTienPhat" name="hiddenTongTienPhat">

        <div class="row mb-3">
                <!-- Tổng tiền phạt -->
                <div class="total-fine">
                    <label for="tongTienPhat">TỔNG TIỀN PHẠT:</label>
                    <input type="text" class="form-control" id="tongTienPhat" name="tongTienPhat" readonly>
                </div>
            </div>
            <!-- Nút thao tác -->
            <form method="POST" action="Handle_violations.php">
            <div class="text-center mt-4">
                <!-- Nút Tạo Lại -->
                <button type="button" class="btn btn-custom" data-lang-key="reset" onclick="resetForm()">Tạo lại</button>
                
                <!-- Nút Xác Nhận (Gửi Form) -->
                <button type="submit" class="btn btn-custom" data-lang-key="confirm">Xác nhận</button>
                
                <!-- Nút In Biên Bản -->
                <button type="button" class="btn btn-secondary" data-lang-key="print" onclick="printForm()">In biên bản</button>
                
                <!-- Nút Gửi Email -->
                <button type="button" class="btn btn-secondary" data-lang-key="email" onclick="sendEmail()">Gửi email</button>
            </div>
        </form>

        </form>
    </div>
    <script>
        function setStep(step) {
            document.querySelectorAll('.step').forEach(s => s.classList.remove('active', 'completed'));
            ['draft', 'confirm', 'print', 'email'].forEach((id, index) => {
                if (id === step) document.getElementById(step-${id}).classList.add('active');
                if (index < ['draft', 'confirm', 'print', 'email'].indexOf(step)) document.getElementById(step-${id}).classList.add('completed');
            });
        }
    </script>
    <script src="calculate_fine.js"></script>
    <script src="stepper.js"></script>
<script>
   document.addEventListener("DOMContentLoaded", function () {
    const basePrice = <?php echo json_encode($bookLoanData['base_price'] ?? 0); ?>;
    const overdueDays = <?php echo json_encode($overdueDays ?? 0); ?>;

    calculateFine(basePrice, overdueDays);

    document.getElementById('soTrang').addEventListener('input', () => calculateFine(basePrice, overdueDays));
    document.querySelectorAll('#quaHan, #huSach, #matSach').forEach(checkbox => {
        checkbox.addEventListener('change', () => calculateFine(basePrice, overdueDays));
    });

    document.getElementById('ngayTra').addEventListener('change', () => {
        const ngayTra = new Date(document.getElementById('ngayTra').value);
        const ngayMuon = new Date(document.getElementById('ngayMuon').value);

        let overdueDays = 0;
        if (!isNaN(ngayTra) && !isNaN(ngayMuon)) {
            overdueDays = Math.max(0, Math.ceil((ngayTra - ngayMuon) / (1000 * 60 * 60 * 24)));
        }

        calculateFine(basePrice, overdueDays);
    });
});

    function sendEmail() {
        alert('Email đã được gửi.');

    }
    function confirmForm() {
        alert('Thông tin đã được xác nhận.');
    }
    function printForm() {
        window.print();
    }
    function sendEmail() {
        alert('Email đã được gửi.');
    }
</script>
</body>
</html>
<?php
}