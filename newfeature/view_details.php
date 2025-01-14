<?php
require 'connect_data.php'; // Kết nối database

// Kiểm tra nếu book_id được truyền qua URL
if (!isset($_GET['book_id']) || !is_numeric($_GET['book_id'])) {
    echo "<script>alert('ID sách không hợp lệ.'); window.location.href='Book_Management.php';</script>";
    exit;
}

$bookId = intval($_GET['book_id']);

// Truy vấn thông tin chi tiết sách
$query = "
    SELECT b.book_title, b.description, b.quantity, b.publication_year, b.height, b.width, b.base_price, 
           b.img_url, b.author, c.category_name, p.publisher_name, s.supplier_name, l.language_name
    FROM book b
    LEFT JOIN category c ON b.category_id = c.category_id
    LEFT JOIN publisher p ON b.publisher_id = p.publisher_id
    LEFT JOIN supplier s ON b.supplier_id = s.supplier_id
    LEFT JOIN language l ON b.language_id = l.language_id
    WHERE b.book_id = ?
";

$stmt = $conn->prepare($query);
$stmt->bind_param("i", $bookId);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    echo "<script>alert('Không tìm thấy thông tin sách.'); window.location.href='Book_Management.php';</script>";
    exit;
}

$bookDetails = $result->fetch_assoc();
$stmt->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chi tiết sách</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>
        body {
            background-color: #f8f9fa;
            font-family: Arial, sans-serif;
        }
        .card {
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
        }
        .img-placeholder {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100%;
            background-color: #e9ecef;
            border-radius: 10px;
        }
        .img-placeholder img {
            max-width: 100%;
            max-height: 100%;
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <h1 class="text-center mb-4">Thông tin chi tiết sách</h1>

        <div class="card mb-3">
            <div class="row g-0">
                <div class="col-md-4">
                    <div class="img-placeholder">
                        <img src="<?php echo htmlspecialchars($bookDetails['img_url'] ?? 'https://w7.pngwing.com/pngs/392/371/png-transparent-book-library-five-flat-books-angle-text-comic-book.png'); ?>" class="img-fluid rounded-start" alt="Bìa sách">
                    </div>
                </div>
                <div class="col-md-8">
                    <div class="card-body">
                        <h5 class="card-title"><?php echo htmlspecialchars($bookDetails['book_title'] ?? 'Không rõ'); ?></h5>
                        <p class="card-text">Mô tả: <?php echo htmlspecialchars($bookDetails['description'] ?? 'Không có mô tả'); ?></p>
                        <p class="card-text">Tác giả: <?php echo htmlspecialchars($bookDetails['author'] ?? 'Không rõ'); ?></p>
                        <p class="card-text">Thể loại: <?php echo htmlspecialchars($bookDetails['category_name'] ?? 'Không rõ'); ?></p>
                        <p class="card-text">Nhà xuất bản: <?php echo htmlspecialchars($bookDetails['publisher_name'] ?? 'Không rõ'); ?></p>
                        <p class="card-text">Nhà cung cấp: <?php echo htmlspecialchars($bookDetails['supplier_name'] ?? 'Không rõ'); ?></p>
                        <p class="card-text">Ngôn ngữ: <?php echo htmlspecialchars($bookDetails['language_name'] ?? 'Không rõ'); ?></p>
                        <p class="card-text">Năm xuất bản: <?php echo htmlspecialchars($bookDetails['publication_year'] ?? 'Không rõ'); ?></p>
                        <p class="card-text">Số lượng: <?php echo htmlspecialchars($bookDetails['quantity'] ?? '0'); ?></p>
                        <p class="card-text">Kích thước: <?php echo htmlspecialchars(($bookDetails['height'] ?? '0') . ' x ' . ($bookDetails['width'] ?? '0')); ?> cm</p>
                        <p class="card-text">Giá cơ bản: <?php echo number_format($bookDetails['base_price'] ?? 0, 2); ?> VND</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="text-center">
            <a href="book_management.php" class="btn btn-primary">Quay lại</a>
        </div>
    </div>
</body>
</html>
