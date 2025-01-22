<?php
session_start();

if ($_SESSION['admin'] == null || $_SESSION['admin'] == '' || !isset($_SESSION['admin'])) {
    header('Location: ../index.php');
    exit();
} else {
?>
<?php
require 'connect_data.php'; // Kết nối database
$search = isset($_GET['search']) ? trim($_GET['search']) : '';
$searchResults = [];
$search = isset($_GET['search']) ? trim($_GET['search']) : '';
$searchResults = [];

$query = "
    SELECT b.book_id, b.book_title, b.author, c.category_name, b.publication_year 
    FROM book b
    JOIN category c ON b.category_id = c.category_id
";

if ($search !== '') {
    $query .= " WHERE b.book_title LIKE ? OR b.author LIKE ? OR c.category_name LIKE ? 
                ORDER BY b.book_title ASC";
    $stmt = $conn->prepare($query);
    $searchParam = "%{$search}%";
    $stmt->bind_param("sss", $searchParam, $searchParam, $searchParam);
} else {
    $query .= " ORDER BY b.book_title ASC";
    $stmt = $conn->prepare($query);
}

$stmt->execute();
$result = $stmt->get_result();

while ($row = $result->fetch_assoc()) {
    $searchResults[] = $row;
}
$stmt->close();


$categories = [];
$queryCategories = "SELECT category_id, category_name FROM category";
$resultCategories = $conn->query($queryCategories);

if ($resultCategories && $resultCategories->num_rows > 0) {
    while ($row = $resultCategories->fetch_assoc()) {
        $categories[] = $row;
    }
} else {
    // Xử lý khi không có dữ liệu
    error_log("Không có thể loại nào trong cơ sở dữ liệu.");
}


// Lấy danh sách năm xuất bản từ cơ sở dữ liệu
$years = [];
$queryYears = "SELECT DISTINCT publication_year FROM book ORDER BY publication_year DESC";
$resultYears = $conn->query($queryYears);

if ($resultYears->num_rows > 0) {
    while ($row = $resultYears->fetch_assoc()) {
        $years[] = $row['publication_year'];
    }
}
if (isset($_GET['edit_book_id'])) {
    $bookId = intval($_GET['edit_book_id']);
    $query = "SELECT 
                b.book_id, 
                b.book_title, 
                b.description, 
                b.quantity, 
                b.publication_year, 
                b.height, 
                b.width, 
                b.base_price, 
                b.publisher_id, 
                b.supplier_id, 
                b.category_id, 
                b.language_id, 
                b.author, 
                b.img_url 
              FROM book b 
              WHERE b.book_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $bookId);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $bookDetails = $result->fetch_assoc();
        echo json_encode($bookDetails); // Trả về JSON
    } else {
        echo json_encode(null); // Không tìm thấy sách
    }
    exit;
}
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['edit_book'])) {
    $bookId = intval($_POST['book_id']);
    $bookTitle = trim($_POST['book_title']);
    $description = trim($_POST['description']);
    $quantity = intval($_POST['quantity']);
    $publicationYear = intval($_POST['publication_year']);
    $height = floatval($_POST['height']);
    $width = floatval($_POST['width']);
    $basePrice = floatval($_POST['base_price']);
    $publisherId = intval($_POST['publisher_id']);
    $supplierId = intval($_POST['supplier_id']);
    $categoryId = intval($_POST['category_id']);
    $languageId = intval($_POST['language_id']);
    $author = trim($_POST['author']);
    $imgUrl = trim($_POST['img_url']);

    if ($bookId > 0 && $bookTitle !== '') {
        $query = "
    UPDATE book 
    SET 
        book_title = ?, 
        description = ?, 
        quantity = ?, 
        publication_year = ?, 
        height = ?, 
        width = ?, 
        base_price = ?, 
        publisher_id = ?, 
        supplier_id = ?, 
        category_id = ?, 
        language_id = ?, 
        author = ?, 
        img_url = ?
    WHERE book_id = ?
";

$stmt = $conn->prepare($query);
$stmt->bind_param(
    "ssiidiiiiissii", 
    $bookTitle, $description, $quantity, $publicationYear, $height, 
    $width, $basePrice, $publisherId, $supplierId, $categoryId, 
    $languageId, $author, $imgUrl, $bookId
);

if ($stmt->execute()) {
    echo "<script>alert('Cập nhật thông tin sách thành công!');</script>";
} else {
    echo "<script>alert('Lỗi khi cập nhật sách: " . $conn->error . "');</script>";
}
$stmt->close();

    } else {
        echo "<script>alert('Vui lòng điền đầy đủ thông tin sách.');</script>";
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['delete_id'])) {
    $bookId = intval($_GET['delete_id']); // Lấy book_id từ yêu cầu

    if ($bookId > 0) {
        // Xóa các bản ghi liên quan trong bảng book_loan
        $queryDeleteLoans = "DELETE FROM book_loan WHERE book_id = ?";
        $stmtDeleteLoans = $conn->prepare($queryDeleteLoans);
        $stmtDeleteLoans->bind_param("i", $bookId);
        $stmtDeleteLoans->execute();
        $stmtDeleteLoans->close();

        // Sau đó xóa sách
        $query = "DELETE FROM book WHERE book_id = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("i", $bookId);

        if ($stmt->execute()) {
            echo "<script>alert('Xóa sách thành công!');</script>";
        } else {
            echo "<script>alert('Lỗi khi xóa sách: " . $conn->error . "');</script>";
        }
        $stmt->close();
    } else {
        echo "<script>alert('ID sách không hợp lệ.');</script>";
    }
}

// Lấy danh sách nhà xuất bản
$publishers = [];
$queryPublishers = "SELECT publisher_id, publisher_name FROM publisher";
$resultPublishers = $conn->query($queryPublishers);
if ($resultPublishers->num_rows > 0) {
    while ($row = $resultPublishers->fetch_assoc()) {
        $publishers[] = $row;
    }
}

// Lấy danh sách nhà cung cấp
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

if ($resultLanguages && $resultLanguages->num_rows > 0) {
    while ($row = $resultLanguages->fetch_assoc()) {
        $languages[] = $row;
    }
} else {
    error_log("Không có dữ liệu ngôn ngữ trong bảng 'language'.");
}

$sortTitle = isset($_GET['sort_title']) ? $_GET['sort_title'] : '';
$sortAuthor = isset($_GET['sort_author']) ? $_GET['sort_author'] : '';
$filterGenre = isset($_GET['filter_genre']) ? $_GET['filter_genre'] : '';
$filterYear = isset($_GET['filter_year']) ? $_GET['filter_year'] : '';

$query = "
    SELECT b.book_id, b.book_title, b.author, c.category_name, b.publication_year 
    FROM book b
    JOIN category c ON b.category_id = c.category_id
    WHERE 1 = 1
";

$types = ""; // Khởi tạo biến types cho bind_param
$params = []; // Khởi tạo mảng params

// Áp dụng bộ lọc thể loại
if (!empty($filterGenre)) {
    $query .= " AND c.category_name = ?";
    $params[] = $filterGenre;
    $types .= "s";
}

// Áp dụng bộ lọc năm xuất bản
if (!empty($filterYear)) {
    $query .= " AND b.publication_year = ?";
    $params[] = $filterYear;
    $types .= "i";
}

// Áp dụng sắp xếp
if (!empty($sortTitle)) {
    $query .= " ORDER BY b.book_title " . ($sortTitle === 'asc' ? 'ASC' : 'DESC');
} elseif (!empty($sortAuthor)) {
    $query .= " ORDER BY b.author " . ($sortAuthor === 'asc' ? 'ASC' : 'DESC');
} else {
    $query .= " ORDER BY b.book_id ASC";
}

$stmt = $conn->prepare($query);

// Bind tham số nếu có
if (!empty($params)) {
    $stmt->bind_param($types, ...$params);
}

// Thực thi truy vấn
$stmt->execute();
$result = $stmt->get_result();

// Lấy dữ liệu
$searchResults = [];
while ($row = $result->fetch_assoc()) {
    $searchResults[] = $row;
}

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
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Library HUB</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
  <link rel="stylesheet" href="Handle_violations.css">
  <link rel="stylesheet" href="Book_management.css">
  <script>
    // Chuyển tab
    function showTab(tabName) {
        const contents = document.querySelectorAll('.content');
        const tabs = document.querySelectorAll('.tab button');

        contents.forEach(content => content.classList.remove('active'));
        tabs.forEach(tab => tab.classList.remove('active'));

        document.getElementById(tabName).classList.add('active');
        document.querySelector(`.tab button[data-tab="${tabName}"]`).classList.add('active');
    }

    // Xem chi tiết sách
    function viewDetails(bookId) {
        window.location.href = `view_details.php?book_id=${bookId}`;
    }

    // Chỉnh sửa sách
    function loadBookDetails(bookId) {
    if (!bookId) {
        alert("Không tìm thấy ID sách.");
        return;
    }

    // Gửi yêu cầu để lấy thông tin sách từ server
    fetch(`Book_Management.php?edit_book_id=${bookId}`)
        .then(response => response.json())
        .then(data => {
            if (data) {
                // Điền thông tin vào form chỉnh sửa
                document.getElementById('book_id').value = data.book_id || '';
                document.getElementById('book_title').value = data.book_title || '';
                document.getElementById('description').value = data.description || '';
                document.getElementById('quantity').value = data.quantity || '';
                document.getElementById('publication_year').value = data.publication_year || '';
                document.getElementById('height').value = data.height || '';
                document.getElementById('width').value = data.width || '';
                document.getElementById('base_price').value = data.base_price || '';
                document.getElementById('publisher_id').value = data.publisher_id || '';
                document.getElementById('supplier_id').value = data.supplier_id || '';
                document.getElementById('category_id').value = data.category_id || '';
                document.getElementById('language_id').value = data.language_id || '';
                document.getElementById('author').value = data.author || '';
                document.getElementById('img_url').value = data.img_url || '';
            } else {
                alert('Không tìm thấy thông tin sách.');
            }
        })
        .catch(error => {
            console.error('Lỗi khi tải thông tin sách:', error);
            alert('Đã xảy ra lỗi. Vui lòng thử lại.');
        });
}

function editBook(bookId) {
    if (!bookId) {
        alert("Không tìm thấy ID sách.");
        return;
    }

    // Gọi hàm loadBookDetails để tải dữ liệu sách
    loadBookDetails(bookId);

    // Chuyển đến tab chỉnh sửa
    showTab('edit');
}


    // Xóa sách
    function deleteBook(bookId) {
        if (!bookId) {
            alert("Không tìm thấy ID sách cần xóa. Vui lòng chọn sách trước.");
            return;
        }
        if (confirm("Bạn có chắc chắn muốn xóa sách này không?")) {
            fetch(`Book_Management.php?delete_id=${encodeURIComponent(bookId)}`, { method: 'GET' })
                .then(response => response.text())
                .then(result => {
                    alert(result);
                    location.reload();
                })
                .catch(error => {
                    console.error("Lỗi khi gửi yêu cầu xóa sách:", error);
                    alert("Đã xảy ra lỗi khi xóa sách. Vui lòng thử lại.");
                });
        }
    }

    // Bộ lọc
    function toggleFilter(filterId) {
        document.querySelectorAll('.filter-popup').forEach(popup => {
            if (popup.id !== filterId) popup.classList.remove('show');
        });

        const popup = document.getElementById(filterId);
        if (popup) popup.classList.toggle('show');
    }

    function applyFilter(column, value) {
    const urlParams = new URLSearchParams(window.location.search);

    // Thêm hoặc cập nhật tham số lọc/sắp xếp
    urlParams.set(column, value);

    // Làm mới trang với tham số mới
    window.location.search = urlParams.toString();
}


    // Ẩn popup khi nhấp ra ngoài
    document.addEventListener('click', (e) => {
        if (!e.target.closest('.filter-container')) {
            document.querySelectorAll('.filter-popup').forEach(popup => popup.classList.remove('show'));
        }
    });
</script>

</head>
<body>
    <!-- Header -->
    <div class="header"></div>
    <!-- Navbar -->
    <?php 
    $current_page = basename($_SERVER['PHP_SELF']); 
        include 'Navbar.php';
    ?>
  <div class="container">
      <div class="tab">
          <button class="active" data-tab="search" onclick="showTab('search')">Tìm kiếm</button>
          <button data-tab="edit" onclick="showTab('edit')">Chỉnh sửa</button>
          <button data-tab="add" onclick="showTab('add')">Bổ sung</button>
          <button data-tab="dashboard" onclick="showTab('dashboard')">Dashboard</button>
      </div>
      <div id="search" class="content active">
    <form method="GET">
        <label for="search_input">Từ khóa tìm kiếm:</label>
        <input type="text" name="search" id="search_input" placeholder="Nhập từ khóa" value="<?php echo htmlspecialchars($search); ?>">
        <button type="submit">Tìm kiếm</button>
    </form>

    <?php if (count($searchResults) > 0): ?>
       
        <div class="table-responsive">
            <h3>Danh sách sách</h3>
            <div class="table-container">
            <table class="table table-bordered">
    <thead>
    <tr>
        <th>ID</th>
        <th>
            <div class="filter-container">
                Nhan đề
                <i class="fa fa-filter filter-icon" onclick="toggleFilter('titleFilter')"></i>
                <div id="titleFilter" class="filter-popup">
                <button class="filter-option" onclick="applyFilter('sort_title', 'asc')">A-Z</button>
<button class="filter-option" onclick="applyFilter('sort_title', 'desc')">Z-A</button>

                </div>
            </div>
        </th>
        <th>
            <div class="filter-container">
                Tác giả
                <i class="fa fa-filter filter-icon" onclick="toggleFilter('authorFilter')"></i>
                <div id="authorFilter" class="filter-popup">
                <button class="filter-option" onclick="applyFilter('sort_title', 'asc')">A-Z</button>
<button class="filter-option" onclick="applyFilter('sort_title', 'desc')">Z-A</button>

                </div>
            </div>
        </th>
        <th>
            <div class="filter-container">
                Thể loại
                <i class="fa fa-filter filter-icon" onclick="toggleFilter('genreFilter')"></i>
                <div id="genreFilter" class="filter-popup">
                    <button class="filter-option" onclick="applyFilter('filter_genre', '')">Tất cả</button>
                    <?php foreach ($categories as $category): ?>
                        <button class="filter-option" onclick="applyFilter('filter_genre', '<?php echo htmlspecialchars($category['category_name']); ?>')">
                            <?php echo htmlspecialchars($category['category_name']); ?>
                        </button>
                    <?php endforeach; ?>
                </div>
            </div>
        </th>
        <th>
            <div class="filter-container">
                Năm xuất bản
                <i class="fa fa-filter filter-icon" onclick="toggleFilter('yearFilter')"></i>
                <div id="yearFilter" class="filter-popup">
                    <button class="filter-option" onclick="applyFilter('filter_year', '')">Tất cả</button>
                    <?php foreach ($years as $year): ?>
                        <button class="filter-option" onclick="applyFilter('filter_year', '<?php echo htmlspecialchars($year); ?>')">
                            <?php echo htmlspecialchars($year); ?>
                        </button>
                    <?php endforeach; ?>
                </div>
            </div>
        </th>
        <th>Thao tác</th>
    </tr>
</thead>


        <tbody id="bookTableBody">
            <?php foreach ($searchResults as $book): ?>
                <tr>
                    <td><?php echo htmlspecialchars($book['book_id']); ?></td>
                    <td><?php echo htmlspecialchars($book['book_title']); ?></td>
                    <td><?php echo htmlspecialchars($book['author']); ?></td>
                    <td><?php echo htmlspecialchars($book['category_name']); ?></td>
                    <td><?php echo htmlspecialchars($book['publication_year']); ?></td>
                    <td>
                        <div class="action-menu-container">
                            <span class="action-menu-trigger">⋮</span>
                            <div class="action-menu">
                                <button onclick="viewDetails(<?php echo $book['book_id']; ?>)">Xem chi tiết</button>
                    
                                <button onclick="editBook(<?php echo $book['book_id']; ?>)">Chỉnh sửa</button>

                            </div>
                        </div>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
            </div>
</div>
<style>
    .filter-select {
        width: 100%;
        margin-top: 5px;
        padding: 5px;
        border: 1px solid #ddd;
        border-radius: 5px;
        font-size: 14px;
    }
    
</style>
</div>

    <?php elseif ($search !== ''): ?>
        <p>Không tìm thấy kết quả nào cho từ khóa "<strong><?php echo htmlspecialchars($search); ?></strong>".</p>
    <?php endif; ?>
</div>
<div class="form-group">
<div id="edit" class="content">
    <form method="POST">
        <!-- Ô nhập ID sách -->
        <label for="search_book_id">Nhập ID sách:</label>
        <input type="number" id="search_book_id" placeholder="Nhập ID sách" oninput="loadBookDetails(this.value)">
        
        <!-- Trường ID ẩn -->
        <label for="book_id">Mã số sách:</label>
        <input type="number" name="book_id" id="book_id">

        <label for="book_title">Nhan đề:</label>
        <input type="text" name="book_title" id="book_title" placeholder="Tên sách" required>

        <label for="description">Mô tả:</label>
        <textarea name="description" id="description" placeholder="Mô tả sách" required></textarea>

        <label for="quantity">Số lượng:</label>
        <input type="number" name="quantity" id="quantity" placeholder="Số lượng" required>

        <label for="publication_year">Năm xuất bản:</label>
        <input type="number" name="publication_year" id="publication_year" placeholder="Năm xuất bản" required>

        <label for="height">Chiều cao:</label>
        <input type="number" name="height" id="height" placeholder="Chiều cao" step="0.01">

        <label for="width">Chiều rộng:</label>
        <input type="number" name="width" id="width" placeholder="Chiều rộng" step="0.01">

        <label for="base_price">Giá cơ bản:</label>
        <input type="number" name="base_price" id="base_price" placeholder="Giá cơ bản" required>

        <label for="publisher_id">Nhà xuất bản:</label>
<select name="publisher_id" id="publisher_id">
    <option value="">Chọn nhà xuất bản</option>
    <?php foreach ($publishers as $publisher): ?>
        <option value="<?php echo htmlspecialchars($publisher['publisher_id']); ?>" 
            <?php echo (isset($bookDetails['publisher_id']) && $bookDetails['publisher_id'] == $publisher['publisher_id']) ? 'selected' : ''; ?>>
            <?php echo htmlspecialchars($publisher['publisher_name']); ?>
        </option>
    <?php endforeach; ?>
</select>

<label for="supplier_id">Nhà cung cấp:</label>
<select name="supplier_id" id="supplier_id">
    <option value="">Chọn nhà cung cấp</option>
    <?php foreach ($suppliers as $supplier): ?>
        <option value="<?php echo htmlspecialchars($supplier['supplier_id']); ?>" 
            <?php echo (isset($bookDetails['supplier_id']) && $bookDetails['supplier_id'] == $supplier['supplier_id']) ? 'selected' : ''; ?>>
            <?php echo htmlspecialchars($supplier['supplier_name']); ?>
        </option>
    <?php endforeach; ?>
</select>

<label for="category_id">Thể loại:</label>
<select name="category_id" id="category_id">
    <option value="">Chọn thể loại</option>
    <?php foreach ($categories as $category): ?>
        <option value="<?php echo htmlspecialchars($category['category_id']); ?>" 
            <?php echo (isset($bookDetails['category_id']) && $bookDetails['category_id'] == $category['category_id']) ? 'selected' : ''; ?>>
            <?php echo htmlspecialchars($category['category_name']); ?>
        </option>
    <?php endforeach; ?>
</select>

<label for="language_id">Ngôn ngữ:</label>
<select name="language_id" id="language_id">
    <option value="">Chọn ngôn ngữ</option>
    <?php foreach ($languages as $language): ?>
        <option value="<?php echo htmlspecialchars($language['language_id']); ?>" 
            <?php echo (isset($bookDetails['language_id']) && $bookDetails['language_id'] == $language['language_id']) ? 'selected' : ''; ?>>
            <?php echo htmlspecialchars($language['language_name']); ?>
        </option>
    <?php endforeach; ?>
</select>


        <label for="author">Tác giả:</label>
        <input type="text" name="author" id="author" placeholder="Tác giả" required>

        <label for="img_url">URL ảnh:</label>
        <input type="url" name="img_url" id="img_url" placeholder="URL ảnh">

        <button type="submit" name="edit_book">Cập nhật sách</button>


    </form>
</div>
    </div> 


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
                const response = await fetch('Book_management.php', {
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
      <div id="add" class="content">
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
      </div>
      <div id="dashboard" class="content">
          <div class="wrapper">
              <h3 class="text-center">BÁO CÁO TỔNG QUAN THƯ VIỆN</h3>
              <div class="dashboard-container">
                  <iframe title="Revenue Opportunities" src="https://app.powerbi.com/view?r=eyJrIjoiMzgxNDVhY2MtMDQ0OC00MTM3LTk4ZjQtZDE3NTgxMGIxMDJjIiwidCI6ImFmMWYzNzUzLTM5MjUtNGU2Zi05NDliLTk3YzAwNzMyMDgwMyIsImMiOjEwfQ%3D%3D" frameborder="0" allowfullscreen></iframe>
              </div>
          </div>
      </div>
  </div>
</body>
</html>
<?php
}