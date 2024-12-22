<?php
// Thông tin kết nối cơ sở dữ liệu
$host = 'mysql-server'; // Tên container MySQL từ docker-compose.yml
$username = 'user';
$password = 'password';
$database = 'testdb';

// Kết nối MySQL
$conn = new mysqli($host, $username, $password, $database);

// Kiểm tra kết nối
if ($conn->connect_error) {
    die("Kết nối thất bại: " . $conn->connect_error);
}

// Hàm xử lý tải lên ảnh
function uploadImage($file, $target_dir = "uploads/") {
    if (!empty($file['tmp_name'])) {
        $image_name = basename($file['name']);
        $unique_name = uniqid() . "_" . $image_name; // Tạo tên duy nhất
        $target_file = $target_dir . $unique_name;

        if (move_uploaded_file($file['tmp_name'], $target_file)) {
            return $target_file; // Trả về đường dẫn ảnh
        } else {
            return false; // Lỗi tải ảnh
        }
    }
    return null; // Không có ảnh
}

// Xử lý thêm sách
if (isset($_POST['add_book'])) {
    $id = (int)$_POST['id'];
    $title = $conn->real_escape_string($_POST['title']);
    $author = $conn->real_escape_string($_POST['author']);
    $genre = $conn->real_escape_string($_POST['genre']);
    $published_year = (int)$_POST['published_year'];
    $quantity = (int)$_POST['quantity'];
    $image_url = uploadImage($_FILES['image']); // Gọi hàm upload ảnh

    if ($image_url === false) {
        echo "Lỗi tải lên hình ảnh.";
        exit;
    }

    $sql = "INSERT INTO books (id, title, author, genre, published_year, image_url, quantity) 
            VALUES (?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("isssisi", $id, $title, $author, $genre, $published_year, $image_url, $quantity);

    if ($stmt->execute()) {
        //echo "Thêm sách thành công!";
    } else {
        echo "Lỗi thêm sách: " . $stmt->error;
    }

    $stmt->close();
}

// Xử lý xóa sách
if (isset($_GET['delete_id'])) {
    $delete_id = (int)$_GET['delete_id'];

    $sql = "DELETE FROM books WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $delete_id);

    if ($stmt->execute()) {
        echo "Xóa sách thành công!";
    } else {
        echo "Lỗi xóa sách: " . $stmt->error;
    }

    $stmt->close();
    exit;
}


// Xử lý cập nhật sách
/*if (isset($_POST['edit_book'])) {
    $id = (int)$_POST['id'];
    $title = $conn->real_escape_string($_POST['title']);
    $author = $conn->real_escape_string($_POST['author']);
    $genre = $conn->real_escape_string($_POST['genre']);
    $published_year = (int)$_POST['published_year'];
    $quantity = (int)$_POST['quantity'];
    $image_url = null;

    // Kiểm tra nếu có file hình ảnh được tải lên
    if (!empty($_FILES['image']['tmp_name'])) {
        $image_name = basename($_FILES['image']['name']);
        $target_dir = "uploads/";
        $target_file = $target_dir . "_" . $image_name; //uniqid()

        // Kiểm tra lỗi tải file
        if (!isset($_FILES['image']['error']) || is_array($_FILES['image']['error'])) {
            echo "Lỗi tập tin tải lên.";
            exit;
        }

        // Xử lý từng loại lỗi
        switch ($_FILES['image']['error']) {
            case UPLOAD_ERR_OK:
                break;
            case UPLOAD_ERR_NO_FILE:
                echo "Không có tệp nào được tải lên.";
                exit;
            case UPLOAD_ERR_INI_SIZE:
            case UPLOAD_ERR_FORM_SIZE:
                echo "Tệp vượt quá kích thước tối đa cho phép.";
                exit;
            default:
                echo "Lỗi không xác định.";
                exit;
        }

        // Kiểm tra và di chuyển tệp
        if (move_uploaded_file($_FILES['image']['tmp_name'], $target_file)) {
            $image_url = $target_file;
        } else {
            echo "Không thể tải lên hình ảnh.";
            exit;
        }
    }

    // Câu lệnh SQL cơ bản
    $sql = "UPDATE books SET title=?, author=?, genre=?, published_year=?, quantity=?";
    if ($image_url !== null) {
        $sql .= ", image_url=? WHERE id=?";
    } else {
        $sql .= " WHERE id=?";
    }

    // Chuẩn bị câu lệnh
    $stmt = $conn->prepare($sql);

    // Gán tham số
    if ($image_url !== null) {
        $stmt->bind_param("sssiiis", $title, $author, $genre, $published_year, $quantity, $image_url, $id);
    } else {
        $stmt->bind_param("sssiii", $title, $author, $genre, $published_year, $quantity, $id);
    }

    // Thực thi câu lệnh
    if ($stmt->execute()) {
        echo "Cập nhật sách thành công!";
    } else {
        echo "Lỗi cập nhật sách: " . $stmt->error;
    }

    // Đóng câu lệnh chuẩn bị
    $stmt->close();
}*/


// Xử lý cập nhật sách
/*if (isset($_POST['edit_book'])) {
    $id = (int)$_POST['id'];
    $title = $conn->real_escape_string($_POST['title']);
    $author = $conn->real_escape_string($_POST['author']);
    $genre = $conn->real_escape_string($_POST['genre']);
    $published_year = (int)$_POST['published_year'];
    $quantity = (int)$_POST['quantity'];
    $image_url = null;

    // Kiểm tra nếu có file hình ảnh được tải lên
    if (!empty($_FILES['image']['tmp_name'])) {
        $image_name = basename($_FILES['image']['name']);
        $target_dir = "uploads/";
        $target_file = $target_dir . uniqid() . "_" . $image_name; // Đặt tên file duy nhất để tránh trùng lặp

        // Di chuyển file tải lên đến thư mục đích
        if (move_uploaded_file($_FILES['image']['tmp_name'], $target_file)) {
            $image_url = $target_file; // Đường dẫn của hình ảnh
        } else {
            echo "Không thể tải lên hình ảnh.";
            exit;
        }
    }

    // Câu lệnh SQL cơ bản
    $sql = "UPDATE books SET title=?, author=?, genre=?, published_year=?, quantity=?";
    if ($image_url !== null) {
        $sql .= ", image_url=?"; // Thêm trường cập nhật đường dẫn hình ảnh nếu có
    }
    $sql .= " WHERE id=?";

    // Chuẩn bị câu lệnh
    $stmt = $conn->prepare($sql);

    // Gán tham số dựa trên việc có hình ảnh hay không
    if ($image_url !== null) {
        $stmt->bind_param("sssiiii", $title, $author, $genre, $published_year, $quantity, $image_url, $id);
    } else {
        $stmt->bind_param("sssiii", $title, $author, $genre, $published_year, $quantity, $id);
    }

    // Thực thi câu lệnh và kiểm tra kết quả
    if ($stmt->execute()) {
        echo "Cập nhật sách thành công!";
    } else {
        echo "Lỗi cập nhật sách: " . $stmt->error;
    }

    // Đóng câu lệnh chuẩn bị
    $stmt->close();
}*/

/*if (isset($_POST['edit_book'])) {
    $id = (int)$_POST['id'];
    $title = $conn->real_escape_string($_POST['title']);
    $author = $conn->real_escape_string($_POST['author']);
    $genre = $conn->real_escape_string($_POST['genre']);
    $published_year = (int)$_POST['published_year'];
    $quantity = (int)$_POST['quantity'];
    $image_url = null;

    // Kiểm tra nếu có file hình ảnh được tải lên
    if (!empty($_FILES['image']['tmp_name'])) {
        $image_name = basename($_FILES['image']['name']);
        $target_dir = "uploads/";
        $target_file = $target_dir . uniqid() . "_" . $image_name;

        // Kiểm tra lỗi tải file
        if (!isset($_FILES['image']['error']) || is_array($_FILES['image']['error'])) {
            echo "Lỗi tập tin tải lên.";
            exit;
        }

        // Xử lý từng loại lỗi
        switch ($_FILES['image']['error']) {
            case UPLOAD_ERR_OK:
                break;
            case UPLOAD_ERR_NO_FILE:
                echo "Không có tệp nào được tải lên.";
                exit;
            case UPLOAD_ERR_INI_SIZE:
            case UPLOAD_ERR_FORM_SIZE:
                echo "Tệp vượt quá kích thước tối đa cho phép.";
                exit;
            default:
                echo "Lỗi không xác định.";
                exit;
        }

        // Kiểm tra và di chuyển tệp
        if (move_uploaded_file($_FILES['image']['tmp_name'], $target_file)) {
            $image_url = $target_file;
        } else {
            echo "Không thể tải lên hình ảnh.";
            exit;
        }
    }

    // Câu lệnh SQL cơ bản
    $sql = "UPDATE books SET title=?, author=?, genre=?, published_year=?, quantity=?";
    if ($image_url !== null) {
        $sql .= ", image_url=? WHERE id=?";
    } else {
        $sql .= " WHERE id=?";
    }

    // Chuẩn bị câu lệnh
    $stmt = $conn->prepare($sql);

    // Gán tham số
    if ($image_url !== null) {
        $stmt->bind_param("sssiiis", $title, $author, $genre, $published_year, $quantity, $image_url, $id);
    } else {
        $stmt->bind_param("sssiii", $title, $author, $genre, $published_year, $quantity, $id);
    }

    // Thực thi câu lệnh
    if ($stmt->execute()) {
        echo "Cập nhật sách thành công!";
    } else {
        echo "Lỗi cập nhật sách: " . $stmt->error;
    }

    // Đóng câu lệnh chuẩn bị
    $stmt->close();
}*/


if (isset($_POST['edit_book'])) {
    $id = (int)$_POST['id'];
    $title = $conn->real_escape_string($_POST['title']);
    $author = $conn->real_escape_string($_POST['author']);
    $genre = $conn->real_escape_string($_POST['genre']);
    $published_year = (int)$_POST['published_year'];
    $quantity = (int)$_POST['quantity'];
    $image_url = null;

    // Check if a new image is uploaded based on the error code
    if ($_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $image_name = basename($_FILES['image']['name']);
        $target_dir = "uploads/";
        $target_file = $target_dir . uniqid() . "_" . $image_name;

        // Move the uploaded file
        if (move_uploaded_file($_FILES['image']['tmp_name'], $target_file)) {
            $image_url = $target_file;
        } else {
            echo "Không thể tải lên hình ảnh.";
            exit;
        }
    }

    // Build the SQL statement
    $sql = "UPDATE books SET title=?, author=?, genre=?, published_year=?, quantity=?";
    if ($image_url !== null) {
        $sql .= ", image_url=? WHERE id=?";
    } else {
        $sql .= " WHERE id=?";
    }

    // Prepare the statement
    $stmt = $conn->prepare($sql);

    // Bind parameters based on image upload
    if ($image_url !== null) {
        $stmt->bind_param("sssiiii", $title, $author, $genre, $published_year, $quantity, $image_url, $id);
    } else {
        $stmt->bind_param("sssiii", $title, $author, $genre, $published_year, $quantity, $id);
    }

    // Execute the statement and handle the result
    if ($stmt->execute()) {
        echo "Cập nhật sách thành công!";
    } else {
        echo "Lỗi cập nhật sách: " . $stmt->error;
    }

    // Close the prepared statement
    $stmt->close();
}

     


    // Tìm kiếm sách
    $search = '';
    if (isset($_GET['search'])) {
        $search = $conn->real_escape_string($_GET['search']);
        $sql = "SELECT * FROM books WHERE title LIKE '%$search%' OR author LIKE '%$search%' OR id LIKE '%$search%' OR genre LIKE '%$search%'";
    } else {
        $sql = "SELECT * FROM books";
    }
    $result = $conn->query($sql);
    
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Library HUB</title>
    <link rel="icon" href="hinh_anh/hinh_anh/HUB logo-08.png" type="image/icon type">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f2f2f2;
            
        }
        header {
            display: flex;
            align-items: right; /* Căn giữa theo chiều dọc */
            justify-content: flex-start; /* Đẩy nội dung sang bên trái, nhưng có thể chỉnh qua phải bằng padding */
            background: url('hinh_anh/hinh_anh/ảnh bài thư viện hub.jpg') no-repeat center center;
            background-position: 10% 75%;
            background-size: cover;
            margin-bottom: 20px; /* Nới rộng khoảng cách bên dưới */
            color: white;
            padding: 30px 0; /* Giữ padding trên và dưới */
            padding-left: 120px; /* Điều chỉnh để đẩy nội dung sang phải */
        }

        header img {
            width: 150px; /* Thay đổi kích thước logo */
            height: auto;
            margin-right: 10px; /* Khoảng cách giữa logo và tiêu đề */
        }

        header h1 {
            text-align: left; /* Đảm bảo tiêu đề được căn trái */
            margin: 0; /* Loại bỏ khoảng cách mặc định */
        }

        .container {
            min-height: calc(100vh - 160px); /* Chiều cao màn hình trừ chiều cao header và footer */
            width: 80%;
            margin: auto;
            padding: 20px;
            background: white;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            margin-bottom: 60px; /* Để tránh đè lên footer */
        }
        .tab {
            display: flex;
            gap: 10px;
            margin-bottom: 20px;
        }
        .tab button {
            padding: 10px;
            cursor: pointer;
            border: none;
            background-color: #ddd;
            font-size: 16px;
            border-radius: 8px;
        }
        .tab button.active {
            background-color: #b30000;
            color: #fff;
        }
        .content {
            display: none;
        }
        .content.active {
            display: block;
        }
        form {
            display: flex;
            flex-direction: column; /* Sắp xếp theo chiều dọc */
            max-width: 400px; /* Chiều rộng tối đa của form */
            margin: auto; /* Căn giữa form */
        }
 
        form label {
            margin-top: 15px; /* Khoảng cách trên cho label */
            font-weight: bold;
        }

        form input[type="text"], 
        form input[type="number"], 
        form input[type="file"] {
            padding: 10px;
            margin-top: 5px; /* Khoảng cách trên cho input */
        }
        button[type="submit"] {
            padding: 10px 15px;
            background-color: #b30000;
            border-radius: 8px;
            color: white;
            border: none;
            cursor: pointer;
            margin: 10px;
        }
        footer {
            text-align: center;
            padding: 20px;
            background-color: #b30000;
            color: white;
            bottom: 0;
            width: 100%;
            padding: 20px;
            background-color: #b30000;
            color: white;
            position: relative; /* Hoặc sử dụng fixed nếu bạn muốn footer luôn hiện diện */
            bottom: 0;
            width: 100%;
        }
        h3{
            color: white;
        }
        p{
            text-align: center;
        }

        .table-responsive {
            display: table;
            width: 100%;
            text-align: center; /* Căn giữa theo chiều ngang */
            border: 1px solid #ddd;
            max-height: 600px; /* Giới hạn chiều cao của bảng */
            overflow-y: auto; /* Bật cuộn dọc */
            overflow-x: hidden; /* Ẩn cuộn ngang nếu không cần thiết */
        }

        .table-responsive td, .table-responsive th {
            vertical-align: middle; /* Căn giữa theo chiều dọc */
            text-align: center; /* Căn giữa theo chiều ngang */
            padding: 10px;
            border: 1px solid #ddd;
        }

        .content {
            padding: 20px; /* Khoảng cách cho nội dung */
            background-color: #f9f9f9; /* Màu nền cho nội dung */
        }

        .wrapper {
            max-width: 1200px; /* Chiều rộng tối đa của nội dung */
            margin: 0 auto; /* Căn giữa nội dung */
            background: white; /* Màu nền trắng cho wrapper */
            border-radius: 8px; /* Bo góc cho wrapper */
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1); /* Đổ bóng cho wrapper */
            padding: 20px; /* Khoảng cách bên trong wrapper */
        }

        .text-center {
            text-align: center; /* Căn giữa tiêu đề */
            margin-bottom: 20px; /* Khoảng cách dưới tiêu đề */
            color: #000000;
        }

        .dashboard-container {
            overflow: hidden; /* Để tránh tràn nội dung */
            border: 1px solid #ddd; /* Viền cho container */
            border-radius: 8px; /* Bo góc cho container */
            padding: 10px; /* Khoảng cách bên trong container */
        }

        .dashboard-container iframe {
            width: 100%; /* Chiều rộng 100% để nằm vừa trong container */
            height: 800px; /* Chiều cao của iframe */
            border: none; /* Bỏ viền cho iframe */
        }


    </style>
    <script>
        function showTab(tabName) {
            const contents = document.querySelectorAll('.content');
            const tabs = document.querySelectorAll('.tab button');
            contents.forEach(content => content.classList.remove('active'));
            tabs.forEach(tab => tab.classList.remove('active'));
            document.getElementById(tabName).classList.add('active');
            document.querySelector(`.tab button[data-tab="${tabName}"]`).classList.add('active');
        }

        function editBook(row) {
            const cells = row.getElementsByTagName('td');
            document.getElementById('book_id').value = cells[0].innerText;
            document.getElementById('book_title').value = cells[1].innerText;
            document.getElementById('book_author').value = cells[2].innerText;
            document.getElementById('book_genre').value = cells[3].innerText;
            document.getElementById('book_published_year').value = cells[4].innerText;
            document.getElementById('book_quantity').value = cells[5].innerText;
        }

        function deleteBook() {
        const bookId = document.getElementById("book_id").value;

        // Kiểm tra nếu không có ID sách
        if (!bookId) {
            alert("Không tìm thấy ID sách cần xóa. Vui lòng chọn sách trước.");
            return;
        }

        if (confirm("Bạn có chắc chắn muốn xóa sách này không?")) {
            // Gửi yêu cầu xóa tới file PHP xử lý
            fetch(`?delete_id=${encodeURIComponent(bookId)}`, {
                method: 'GET',
            })
            .then(response => response.text())
            .then(result => {
                // Hiển thị thông báo từ server
                alert(result);

                // Tải lại danh sách sách
                location.reload();
            })
            .catch(error => {
                console.error("Lỗi khi gửi yêu cầu xóa sách:", error);
                alert("Đã xảy ra lỗi khi xóa sách. Vui lòng thử lại.");
            })
        }
    }

    </script>
</head>
<body>
    <header>
        <img src="hinh_anh/hinh_anh/HUB logo-07.png" alt="Logo" class="logo">
        <h1>LIBRARY</h1>
        <div class="time"><?php
        // Cài đặt múi giờ nếu cần thiết (tùy chỉnh theo múi giờ của bạn)
        date_default_timezone_set('Asia/Ho_Chi_Minh'); 

        // Lấy thời gian hiện tại
        $currentTime = date('l, d/m/Y');

        // Hiển thị thời gian
        echo  $currentTime;
        ?>
        </div>
    </header>

    <div class="container">
    <div class="tab">
        <button class="active" data-tab="search" onclick="showTab('search')">Tìm kiếm</button>
        <button data-tab="edit" onclick="showTab('edit')">Chỉnh sửa</button>
        <button data-tab="add" onclick="showTab('add')">Bổ sung</button>
        <button data-tab="dashboard" onclick="showTab('dashboard')">Dashboard</button>
    </div>

    <!-- Nội dung Tìm kiếm -->
    <div id="search" class="content active">
        <form method="GET">
            <label for="search_input">Từ khóa tìm kiếm:</label>
            <input type="text" name="search" id="search_input" placeholder="Nhập từ khóa" value="<?php echo htmlspecialchars($search); ?>">
            <button type="submit">Tìm kiếm</button>
        </form>
        <div id="books_list">
            <h2>Danh sách tìm kiếm</h2>
            <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead class="thead-dark">
                        <tr>
                            <th>ID</th>
                            <th>Nhan đề</th>
                            <th>Tác giả</th>
                            <th>Thể loại</th>
                            <th>Năm xuất bản</th>
                            <th>Số lượng</th>
                            <th>Hình ảnh</th>
                            <th>Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = $result->fetch_assoc()) { ?>
                            <tr onclick="editBook(this)">
                                <td><?php echo $row['id']; ?></td>
                                <td><?php echo htmlspecialchars($row['title']); ?></td>
                                <td><?php echo htmlspecialchars($row['author']); ?></td>
                                <td><?php echo htmlspecialchars($row['genre']); ?></td>
                                <td><?php echo htmlspecialchars($row['published_year']); ?></td>
                                <td><?php echo htmlspecialchars($row['quantity']); ?></td>
                                <td>
                                    <?php if (!empty($row['image_url'])): ?>
                                        <img src="<?php echo htmlspecialchars($row['image_url']); ?>" alt="<?php echo htmlspecialchars($row['title']); ?>" style="width: 50px; height: auto;"/>
                                    <?php else: ?>
                                        <span>Không có hình</span>
                                    <?php endif; ?>
                                </td>
                                <td><button data-tab="edit" onclick="showTab('edit')">Chỉnh sửa</button></td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Nội dung Chỉnh sửa -->
    <div id="edit" class="content">
        <form method="POST" enctype="multipart/form-data">
            <input type="hidden" name="id" id="book_id">
            <label for="book_title">Nhan đề:</label>
            <input type="text" name="title" id="book_title" placeholder="Tên sách" required>
            <label for="book_author">Tác giả:</label>
            <input type="text" name="author" id="book_author" placeholder="Tác giả" required>
            <label for="book_genre">Thể loại:</label>
            <select name="genre" id="book_genre">
                <option value="">Chọn thể loại</option>
                <option value="Giáo trình">Giáo trình</option>
                <option value="Sách tham khảo">Sách tham khảo</option>
                <option value="Tiểu thuyết">Tiểu thuyết</option>
                <option value="Khoa học">Khoa học</option>
                <option value="Lịch sử">Lịch sử</option>
                <option value="Văn học">Văn học</option>
                <option value="Tâm lý học">Tâm lý học</option>
                <option value="Kinh tế">Kinh tế</option>
                <option value="Nghệ thuật">Nghệ thuật</option>
                <option value="Sách thiếu nhi">Sách thiếu nhi</option>
                <option value="Sách ngoại ngữ">Sách ngoại ngữ</option>
                <option value="Công nghệ thông tin">Công nghệ thông tin</option>
                <option value="Sách chính trị">Sách chính trị</option>
                <option value="Triết học">Triết học</option>
                <option value="Sách kỹ năng sống">Sách kỹ năng sống</option>
            </select>
            <label for="book_published_year">Năm xuất bản:</label>
            <input type="number" name="published_year" id="book_published_year" placeholder="Năm xuất bản" required>
            <label for="book_quantity">Số lượng:</label>
            <input type="number" name="quantity" id="book_quantity" placeholder="Số lượng sách" required min="1">
            <label for="image">Hình ảnh:</label>
            <input type="file" name="image" id="image" accept="image/*">
            <button type="submit" name="edit_book">Cập nhật sách</button>
            <button type="button" onclick="deleteBook()">Xóa</button>
        </form>
    </div>

    <!-- Nội dung Bổ sung -->
    <div id="add" class="content">
    <form method="POST" enctype="multipart/form-data">
        <label for="new_id">ID:</label>
        <input type="number" name="id" id="new_id" placeholder="ID sách (nhập thủ công)" required>
        <label for="new_title">Nhan đề:</label>
        <input type="text" name="title" id="new_title" placeholder="Tên sách" required>
        <label for="new_author">Tác giả:</label>
        <input type="text" name="author" id="new_author" placeholder="Tác giả" required>
        <label for="new_genre">Thể loại:</label>
        <select name="genre" id="new_genre">
            <option value="">Chọn thể loại</option>
            <option value="Giáo trình">Giáo trình</option>
            <option value="Sách tham khảo">Sách tham khảo</option>
            <option value="Tiểu thuyết">Tiểu thuyết</option>
            <option value="Khoa học">Khoa học</option>
            <option value="Lịch sử">Lịch sử</option>
            <option value="Văn học">Văn học</option>
            <option value="Tâm lý học">Tâm lý học</option>
            <option value="Kinh tế">Kinh tế</option>
            <option value="Nghệ thuật">Nghệ thuật</option>
            <option value="Sách thiếu nhi">Sách thiếu nhi</option>
            <option value="Sách ngoại ngữ">Sách ngoại ngữ</option>
            <option value="Công nghệ thông tin">Công nghệ thông tin</option>
            <option value="Sách chính trị">Sách chính trị</option>
            <option value="Triết học">Triết học</option>
            <option value="Sách kỹ năng sống">Sách kỹ năng sống</option>
        </select>
        <label for="new_published_year">Năm xuất bản:</label>
        <input type="number" name="published_year" id="new_published_year" placeholder="Năm xuất bản" required>
        <label for="new_quantity">Số lượng:</label>
        <input type="number" name="quantity" id="new_quantity" placeholder="Số lượng sách">
        <label for="new_image">Hình ảnh:</label>
        <input type="file" name="image" id="new_image" accept="image/*">
        <button type="submit" name="add_book">Thêm sách</button>
    </form>
    </div>



    <div id="dashboard" class="content">
    <div class="wrapper">
        <h3 class="text-center">BÁO CÁO TỔNG QUAN THƯ VIỆN</h3>
        <div class="dashboard-container">
            <iframe title="Revenue Opportunities" src="https://app.powerbi.com/view?r=eyJrIjoiYjBiMjI5YmYtZTZlNS00Y2E2LWExZDQtZGZlZWM5OTk4NDdhIiwidCI6ImFmMWYzNzUzLTM5MjUtNGU2Zi05NDliLTk3YzAwNzMyMDgwMyIsImMiOjEwfQ%3D%3D" frameborder="0" allowFullScreen="true"></iframe>
        </div>
    </div>
    </div>
</div>

<footer>
    <h3>TRUNG TÂM THÔNG TIN - THƯ VIỆN</h3>
    <h6>Địa chỉ: 56 Hoàng Diệu 2, P.Linh Chiểu, Tp.Thủ Đức, Tp.HCM</h6>
    <p>© 2024 Trường Đại học Ngân hàng Tp.HCM. Tất cả quyền được bảo lưu.</p>
</footer>
</body>
</html>

