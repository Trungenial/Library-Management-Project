<?php
// Kết nối MySQL
$host = '127.0.0.1';
$user = 'root';
$password = '';
$database = 'library';

$conn = new mysqli($host, $user, $password, $database);

// Kiểm tra kết nối
if ($conn->connect_error) {
    die("Kết nối thất bại: " . $conn->connect_error);
}

// Lấy dữ liệu vi phạm
$query = "SELECT 
            v.violation_report_id, 
            s.student_id, 
            CONCAT(s.first_name, ' ', s.last_name) AS student_name,
            b.book_id, 
            b.book_title, 
            v.report_date, 
            COALESCE(bl.actual_return_date, '') AS actual_return_date,
            v.number_of_damaged_pages, 
            v.fine_amount, 
            v.violation_handling,
            v.description
          FROM 
            violation_report v
          JOIN 
            student s ON v.student_id = s.student_id
          JOIN 
            book b ON v.book_id = b.book_id
          LEFT JOIN 
            book_loan bl ON v.book_id = bl.book_id AND v.student_id = bl.student_id
          LIMIT 1";

$result = $conn->query($query);

$data = [];
if ($result && $result->num_rows > 0) {
    $data = $result->fetch_assoc();
}

$conn->close();
?>
