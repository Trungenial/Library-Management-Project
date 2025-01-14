<?php
require_once 'connect_data.php';

// Lấy danh sách từ database
$categories = [];
$queryCategories = "SELECT category_id, category_name FROM category";
$resultCategories = $conn->query($queryCategories);
if ($resultCategories->num_rows > 0) {
    while ($row = $resultCategories->fetch_assoc()) {
        $categories[] = $row;
    }
}

$publishers = [];
$queryPublishers = "SELECT publisher_id, publisher_name FROM publisher";
$resultPublishers = $conn->query($queryPublishers);
if ($resultPublishers->num_rows > 0) {
    while ($row = $resultPublishers->fetch_assoc()) {
        $publishers[] = $row;
    }
}

$suppliers = [];
$querySuppliers = "SELECT supplier_id, supplier_name FROM supplier";
$resultSuppliers = $conn->query($querySuppliers);
if ($resultSuppliers->num_rows > 0) {
    while ($row = $resultSuppliers->fetch_assoc()) {
        $suppliers[] = $row;
    }
}

$languages = [];
$queryLanguages = "SELECT language_id, language_name FROM language";
$resultLanguages = $conn->query($queryLanguages);
if ($resultLanguages->num_rows > 0) {
    while ($row = $resultLanguages->fetch_assoc()) {
        $languages[] = $row;
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    $action = $_POST['action'];

    if ($action === 'add_book') {
        // Kiểm tra các giá trị "Thêm mới"
        $newGenre = !empty($_POST['new_genre']) ? $_POST['new_genre'] : null;
        $newPublisher = !empty($_POST['new_publisher']) ? $_POST['new_publisher'] : null;
        $newSupplier = !empty($_POST['new_supplier']) ? $_POST['new_supplier'] : null;
        $newLanguage = !empty($_POST['new_language']) ? $_POST['new_language'] : null;

        // Thêm giá trị mới vào cơ sở dữ liệu nếu có
        if ($newGenre) {
            $stmt = $conn->prepare("INSERT INTO category (category_name) VALUES (?)");
            $stmt->bind_param('s', $newGenre);
            $stmt->execute();
            $genre = $conn->insert_id;
        }

        if ($newPublisher) {
            $stmt = $conn->prepare("INSERT INTO publisher (publisher_name) VALUES (?)");
            $stmt->bind_param('s', $newPublisher);
            $stmt->execute();
            $publisher = $conn->insert_id;
        }

        if ($newSupplier) {
            $stmt = $conn->prepare("INSERT INTO supplier (supplier_name) VALUES (?)");
            $stmt->bind_param('s', $newSupplier);
            $stmt->execute();
            $supplier = $conn->insert_id;
        }

        if ($newLanguage) {
            $stmt = $conn->prepare("INSERT INTO language (language_name) VALUES (?)");
            $stmt->bind_param('s', $newLanguage);
            $stmt->execute();
            $language = $conn->insert_id;
        }

        // Lấy dữ liệu từ form
        $title = $_POST['title'];
        $author = empty($_POST['author']) ? null : $_POST['author'];
        $year = intval($_POST['year']);
        $quantity = intval($_POST['quantity']);
        $height = empty($_POST['height']) ? 0 : floatval($_POST['height']);
        $width = empty($_POST['width']) ? 0 : floatval($_POST['width']);
        $price = floatval($_POST['price']);
        $description = empty($_POST['description']) ? null : $_POST['description'];
        $genre = $genre ?? intval($_POST['genre']);
        $publisher = $publisher ?? intval($_POST['publisher']);
        $supplier = $supplier ?? intval($_POST['supplier']);
        $language = $language ?? intval($_POST['language']);
        $img_url = empty($_POST['img_url']) ? null : $_POST['img_url'];

        // Chuẩn bị câu lệnh SQL để thêm sách
        $sql = "INSERT INTO book (book_title, author, publication_year, quantity, height, width, base_price, description, category_id, publisher_id, supplier_id, language_id, img_url) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

        $stmt = $conn->prepare($sql);
        $stmt->bind_param('ssiiiddssiiii', $title, $author, $year, $quantity, $height, $width, $price, $description, $genre, $publisher, $supplier, $language, $img_url);
        $stmt->execute();

        echo json_encode(["success" => true, "message" => "Sách đã được thêm thành công!"]);
    }
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thêm sách mới</title>
    <script>
        function toggleInput(type) {
            const select = document.getElementById(`new_${type}`);
            const input = document.getElementById(`${type}_input`);

            if (select.value === "add_new") {
                input.style.display = "block";
                input.required = true;
            } else {
                input.style.display = "none";
                input.required = false;
            }
        }

        async function submitNewBook(event) {
            event.preventDefault();
            const form = document.getElementById('addBookForm');
            const formData = new FormData(form);

            try {
                const response = await fetch('add_book.php', {
                    method: 'POST',
                    body: formData
                });

                const result = await response.json();
                const messageBox = document.getElementById('messageBox');
                messageBox.innerHTML = result.message;
                messageBox.style.display = 'block';

                if (result.success) {
                    form.reset();
                    document.querySelectorAll('.new-option-input').forEach(input => input.style.display = 'none');
                }

                setTimeout(() => {
                    messageBox.style.display = 'none';
                }, 5000);
            } catch (error) {
                console.error('Lỗi:', error);
            }
        }
    </script>
</head>
<body>
    <h1>Thêm sách mới</h1>
    <div id="messageBox" style="display:none; padding: 10px; margin-bottom: 10px; border: 1px solid #ccc; background-color: #f9f9f9;"></div>
    <form id="addBookForm" method="POST" onsubmit="submitNewBook(event)">
        <input type="hidden" name="action" value="add_book">

        <label for="new_title">Nhan đề:</label>
        <input type="text" id="new_title" name="title" required>

        <label for="new_author">Tác giả:</label>
        <input type="text" id="new_author" name="author">

        <label for="new_year">Năm xuất bản:</label>
        <input type="number" id="new_year" name="year" required>

        <label for="new_quantity">Số lượng:</label>
        <input type="number" id="new_quantity" name="quantity" required>

        <label for="new_height">Chiều cao (cm):</label>
        <input type="number" id="new_height" name="height" step="0.01">

        <label for="new_width">Chiều rộng (cm):</label>
        <input type="number" id="new_width" name="width" step="0.01">

        <label for="new_price">Giá cơ bản:</label>
        <input type="number" id="new_price" name="price" step="0.01" required>

        <label for="new_description">Mô tả:</label>
        <textarea id="new_description" name="description"></textarea>

        <label for="new_genre">Thể loại:</label>
        <select id="new_genre" name="genre" onchange="toggleInput('genre')" required>
            <option value="">Chọn thể loại</option>
            <?php foreach ($categories as $category): ?>
                <option value="<?php echo htmlspecialchars($category['category_id']); ?>">
                    <?php echo htmlspecialchars($category['category_name']); ?>
                </option>
            <?php endforeach; ?>
            <option value="add_new">Thêm mới</option>
        </select>
        <input type="text" id="genre_input" name="new_genre" class="new-option-input" placeholder="Nhập thể loại mới" style="display:none;">

        <label for="new_publisher">Nhà xuất bản:</label>
        <select id="new_publisher" name="publisher" onchange="toggleInput('publisher')" required>
            <option value="">Chọn nhà xuất bản</option>
            <?php foreach ($publishers as $publisher): ?>
                <option value="<?php echo htmlspecialchars($publisher['publisher_id']); ?>">
                    <?php echo htmlspecialchars($publisher['publisher_name']); ?>
                </option>
            <?php endforeach; ?>
            <option value="add_new">Thêm mới</option>
        </select>
        <input type="text" id="publisher_input" name="new_publisher" class="new-option-input" placeholder="Nhập nhà xuất bản mới" style="display:none;">

        <label for="new_supplier">Nhà cung cấp:</label>
        <select id="new_supplier" name="supplier" onchange="toggleInput('supplier')" required>
            <option value="">Chọn nhà cung cấp</option>
            <?php foreach ($suppliers as $supplier): ?>
                <option value="<?php echo htmlspecialchars($supplier['supplier_id']); ?>">
                    <?php echo htmlspecialchars($supplier['supplier_name']); ?>
                </option>
            <?php endforeach; ?>
            <option value="add_new">Thêm mới</option>
        </select>
        <input type="text" id="supplier_input" name="new_supplier" class="new-option-input" placeholder="Nhập nhà cung cấp mới" style="display:none;">

        <label for="new_language">Ngôn ngữ:</label>
        <select id="new_language" name="language" onchange="toggleInput('language')" required>
            <option value="">Chọn ngôn ngữ</option>
            <?php foreach ($languages as $language): ?>
                <option value="<?php echo htmlspecialchars($language['language_id']); ?>">
                    <?php echo htmlspecialchars($language['language_name']); ?>
                </option>
            <?php endforeach; ?>
            <option value="add_new">Thêm mới</option>
        </select>
        <input type="text" id="language_input" name="new_language" class="new-option-input" placeholder="Nhập ngôn ngữ mới" style="display:none;">

        <label for="img_url">URL ảnh:</label>
        <input type="url" id="img_url" name="img_url" placeholder="URL ảnh">

        <button type="submit">Bổ sung sách</button>
    </form>
</body>
</html>
