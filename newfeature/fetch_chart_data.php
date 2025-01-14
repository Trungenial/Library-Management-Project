<?php
require 'connect_data.php'; // Kết nối database

// Truy vấn lấy số lượt mượn theo thể loại sách
$query = "
    SELECT 
        c.category_name,
        COUNT(bl.book_loan_id) AS borrow_count
    FROM 
        category c
    LEFT JOIN 
        book b ON c.category_id = b.category_id
    LEFT JOIN 
        book_loan bl ON b.book_id = bl.book_id
    GROUP BY 
        c.category_id, c.category_name
    ORDER BY 
        borrow_count DESC;
";

$result = $conn->query($query);
$data = [];

if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $data[] = [
            'category_name' => $row['category_name'],
            'borrow_count' => (int)$row['borrow_count']
        ];
    }
}

header('Content-Type: application/json');
echo json_encode($data);
$conn->close();
?>
