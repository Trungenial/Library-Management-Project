
<?php
session_start();

if ($_SESSION['admin'] == null || $_SESSION['admin'] == '' || !isset($_SESSION['admin'])) {
    header('Location: ../index.php');
    exit();
} else {

require 'connect_data.php'; // Import kết nối và các hàm

// Truy vấn lấy danh mục từ bảng category
$sql = $query = "
SELECT 
    c.category_name,
    COUNT(bl.book_loan_id) AS borrow_count
FROM 
    book_loan bl
JOIN 
    book b ON bl.book_id = b.book_id
JOIN 
    category c ON b.category_id = c.category_id
GROUP BY 
    c.category_id, c.category_name
ORDER BY 
    borrow_count DESC
LIMIT 9;
";

$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="Handle_violations.css">
    <title>Trang chủ</title>
    <style>

/* Print-specific styles */
@media print {
    .navbar, .header, .step-wrapper, .total-fine, .violation-buttons {
        display: none;
    }
}
 /* Thống kê rộng ra */
 .statistics {
    width: 25%;
    margin: 20px 20px 20px 0;
    max-width: 500px;
    background-color: white;
    box-shadow: 0 0 5px rgba(0, 0, 0, 0.2);
    padding: 0px;
    box-sizing: border-box;
}

.statistics h3 {
    margin: 0;
    padding: 10px;
    text-align: left;
    font-size: 18px;
    font-weight: bold;
    background-color: #bd0b20;
    color: white;
}
.statistics canvas {
            margin: 20px auto;
            display: block;
            max-width: 100%;
        }

        .borrow-return-stats {
            margin-top: 20px;
            text-align: center;
        }

        .borrow-return-stats p {
            font-size: 16px;
            margin: 10px 0;
        }

        .borrow-return-stats p strong {
            color: #bd0b20;
        }

.notifications {
    width: 20%;
    max-width: 300px;
    margin: 20px 0 20px 20px;
    background-color: #fff;
    box-shadow: 0 0 5px rgba(0, 0, 0, 0.2);
    font-family: Arial, sans-serif;
}

.notifications h3 {
    margin: 0;
    padding: 10px;
    text-align: left;
    font-size: 18px;
    font-weight: bold;
    background-color: #bd0b20;
    color: white;
}

.notification-item {
    display: flex;
    align-items: center;
    border-bottom: 1px solid #ddd;
    padding: 10px;
    box-sizing: border-box;
}

.notification-item:last-child {
    border-bottom: none;
}

.date-box {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    background-color: #1976d2;
    color: white;
    font-weight: bold;
    padding: 5px;
    width: 50px;
    height: 50px;
    margin-right: 10px;
    border-radius: 3px;
}

.date-box .day {
    font-size: 20px;
    line-height: 1;
}

.date-box .month-year {
    font-size: 10px;
    line-height: 1;
}

.notification-item p {
    margin: 0;
    font-size: 14px;
    color: #333;
}

/* Phần thư viện chiếm phần còn lại */
.library-items {
    width: 55%;
    margin: 15px auto 0;
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 10px;
    padding: 10px;
    box-sizing: border-box;
}

/* Các ô sách */
.item {
    background-color: #fff;
    border: 1px solid #ddd;
    box-shadow: 0 0 3px rgba(0, 0, 0, 0.2);
    border-radius: 5px;
    overflow: hidden;
    text-align: center;
    transition: transform 0.2s;
}

.item:hover {
    transform: scale(1.05);
}

.item a {
    text-decoration: none;
    color: inherit;
    display: block;
}

.item img {
    width: 100%;
    height: auto;
}

.item p {
    margin: 0;
    padding: 5px;
    font-size: 15px;
    font-weight: bold;
    background-color: #0288d1;
    color: white;
}

/* Footer */
footer {
    background-color: #b71c1c;
    color: white;
    text-align: center;
    padding: 15px 10px;
    font-size: 14px;
}

/* Main Layout */
main {
    display: flex;
    justify-content: space-between;
}
    </style>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trang chủ</title>

</head>
<body>
     <!-- Header -->
     <div class="header"></div>
    <!-- Navbar -->
    <?php 
    $current_page = basename($_SERVER['PHP_SELF']); 
        include 'Navbar.php';
    ?>
    <main>
    <div class="statistics">
    <h3 style ="text-align: center;">THỐNG KÊ</h3>
    <canvas id="bookChart" width="400" height="400"></canvas>
</div>


        <!-- Library Content -->
        <div class="library-items">
        <?php
        // Kiểm tra và hiển thị danh sách
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo '<div class="item">';
                echo '<a href="#">';
                echo '<img src="https://hoangphucphoto.com/wp-content/uploads/2024/05/anh-sach-nen.jpeg" alt="' . htmlspecialchars($row["category_name"]) . '">';
                echo '<p>' . htmlspecialchars($row["category_name"]) . '</p>';
                echo '</a>';
                echo '</div>';
            }
        } else {
            echo "<p>Không có danh mục nào.</p>";
        }

        $conn->close();
        ?>
        </div>

        <div class="notifications">
            <h3>THÔNG BÁO</h3>
            <div class="notification-item">
                <div class="date-box">
                    <span class="day">16</span>
                    <span class="month-year">12/2024</span>
                </div>
                <p>Quyết định công nhận trúng tuyển ĐH VB2 hệ VLVH đợt 2 năm 2024</p>
            </div>
            <div class="notification-item">
                <div class="date-box">
                    <span class="day">11</span>
                    <span class="month-year">12/2024</span>
                </div>
                <p>4176/QĐ-ĐHNH Quyết định v/v công nhận đủ điều kiện học tiếng Anh chuyên ngành đối với sinh viên đại học chính quy</p>
            </div>
            <div class="notification-item">
                <div class="date-box">
                    <span class="day">11</span>
                    <span class="month-year">12/2024</span>
                </div>
                <p>4164/QĐ-ĐHNH Quyết định v/v công nhận đạt Tiếng Anh chuẩn đầu ra đ/v SV ĐHCQ nộp tháng 11/2024</p>
            </div>
            <div class="notification-item">
                <div class="date-box">
                    <span class="day">10</span>
                    <span class="month-year">12/2024</span>
                </div>
                <p>Thông báo v/v điều chỉnh thời gian đăng ký học phần đợt 2 HK2 NH 2024-2025 dành cho SV ĐHCQ</p>
            </div>
            <div class="notification-item">
                <div class="date-box">
                    <span class="day">09</span>
                    <span class="month-year">12/2024</span>
                </div>
                <p>Thông báo v/v điều chỉnh thời gian đóng học phí hệ ĐHCQ CT CLC NH 2024-2025 và hoàn thành công nợ HP</p>
            </div>
        </div>
    </main>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Hàm tạo màu ngẫu nhiên
    function generateColors(count) {
        const colors = [];
        for (let i = 0; i < count; i++) {
            const r = Math.floor(Math.random() * 255);
            const g = Math.floor(Math.random() * 255);
            const b = Math.floor(Math.random() * 255);
            colors.push(`rgba(${r}, ${g}, ${b}, 0.7)`); // Màu trong suốt
        }
        return colors;
    }

    // Lấy dữ liệu từ API
    async function fetchChartData() {
        const response = await fetch('fetch_chart_data.php');
        if (!response.ok) {
            console.error('Lỗi khi lấy dữ liệu:', response.statusText);
            return [];
        }
        return response.json();
    }

    // Tạo biểu đồ
    async function createBookChart() {
        const data = await fetchChartData();

        const labels = data.map(item => item.category_name); // Tên thể loại
        const borrowCounts = data.map(item => item.borrow_count); // Số lượt mượn
        const colors = generateColors(labels.length); // Màu sắc

        const ctx = document.getElementById('bookChart').getContext('2d');
        new Chart(ctx, {
            type: 'pie',
            data: {
                labels: labels,
                datasets: [{
                    data: borrowCounts,
                    backgroundColor: colors,
                    hoverOffset: 4
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'top'
                    },
                    title: {
                        display: true,
                        text: 'Tỷ lệ các loại sách được mượn'
                    }
                },
                onClick: (event, elements) => {
                    if (elements.length > 0) {
                        const index = elements[0].index;
                        const category = labels[index];
                        const count = borrowCounts[index];
                        alert(`Thể loại: ${category}\nSố lượt mượn: ${count}`);
                    }
                }
            }
        });
    }

    // Khởi tạo biểu đồ
    createBookChart();
</script>

    <!-- Footer Section -->
    <footer>
        <p>TRUNG TÂM THÔNG TIN - THƯ VIỆN</p>
        <p>Địa chỉ: 56 Hoàng Diệu 2, P.Linh Chiểu, Tp.Thủ Đức, Tp.HCM</p>
        <p>© 2024 Trường Đại học Ngân hàng Tp.HCM. Tất cả quyền được bảo lưu.</p>
    </footer>

    <script>
        function changeLanguage(lang) {
            console.log("Language switched to:", lang);
            // Add language switch functionality here.
        }
    </script>
   
</body>
</html> 

<?php
}