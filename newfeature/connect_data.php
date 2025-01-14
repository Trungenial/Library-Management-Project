<?php
// connect_data.php

$host = 'localhost';
$user = 'root';
$password = '';
$database = 'library'; 
$conn = new mysqli($host, $user, $password, $database);

if ($conn->connect_error) {
    die("Kết nối thất bại: " . $conn->connect_error);
}

// Lấy giá sách từ book_id
function getBookBasePrice($conn, $bookId) {
    $stmt = $conn->prepare("SELECT base_price FROM book WHERE book_id = ?");
    $stmt->bind_param('i', $bookId);
    $stmt->execute();
    $result = $stmt->get_result();
    $book = $result->fetch_assoc();
    return $book['base_price'] ?? 0;
}

// Tạo mã biên bản tự động
function generateViolationId($conn) {
    $query = "SELECT MAX(violation_report_id) AS max_id FROM violation_report";
    $result = $conn->query($query);
    $row = $result->fetch_assoc();
    $maxId = $row['max_id'] ? $row['max_id'] + 1 : 1;
    return 'BB' . str_pad($maxId, 6, '0', STR_PAD_LEFT);
}
function getOverdueDays($conn, $bookLoanId) {
    $stmt = $conn->prepare("
        SELECT GREATEST(DATEDIFF(actual_return_date, expected_return_date), 0) AS overdue_days
        FROM book_loan
        WHERE book_loan_id = ? AND actual_return_date IS NOT NULL
    ");
    $stmt->bind_param("i", $bookLoanId);
    $stmt->execute();
    $result = $stmt->get_result();
    $data = $result->fetch_assoc();
    return $data['overdue_days'] ?? 0;
}
?>
