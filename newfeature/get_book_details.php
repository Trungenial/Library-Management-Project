<?php
require 'connect_data.php';

$book_id = isset($_GET['book_id']) ? intval($_GET['book_id']) : 0;

if ($book_id > 0) {
    $query = "
        SELECT 
            b.book_id, b.book_title, b.author, b.description, b.quantity, 
            b.publication_year, b.height, b.width, b.base_price, 
            c.category_name, c.category_id, 
            p.publisher_name, p.publisher_id, 
            s.supplier_name, s.supplier_id, 
            l.language_name, l.language_id 
        FROM book b
        LEFT JOIN category c ON b.category_id = c.category_id
        LEFT JOIN publisher p ON b.publisher_id = p.publisher_id
        LEFT JOIN supplier s ON b.supplier_id = s.supplier_id
        LEFT JOIN language l ON b.language_id = l.language_id
        WHERE b.book_id = ?
    ";

    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $book_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $data = $result->fetch_assoc();
    
    echo json_encode($data);
} else {
    echo json_encode(['error' => 'Invalid book ID']);
}
?>
