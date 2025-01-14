<html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HUB - LIBRARY</title>
    <link rel="stylesheet" href="../Handle_violations.css">
    <link rel="stylesheet" href="./MuonTraStyle.css">
    <link rel="stylesheet" href="./fontawesome-free-6.7.2-web">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/8.0.1/normalize.min.css">
</head>
<body>
    <div class="muonTraModule">
        <div class="header"></div>

        <div class="muonTra__container">

            <div class="navigation_bar">
                <?php include '../Navbar-muon-tra.php' ?>
                <!-- <ul class="navBar">
                    <li><a href="../Home.php">Trang chủ</a></li>
                    <li><a href="../news.php">Tin tức</a></li>
                    <li><a href="../about.php">Giới thiệu</a></li>
                    <li><a href="../book_management.php">Quản lý sách</a></li>
                    <li><a class="active" href="./book-lending-returning.php" target="_self">Mượn - Trả sách</a></li>
                    <li><a href="../Search_violations.php">Xử lý vi phạm</a></li>                        
                    <li><a href="../guide.php">Hướng dẫn</a></li>
                </ul> -->
            </div>
            <div class="searchingBox">
                <form method="POST" >
                    <table class="search">         
                        <tr>
                            <th>Mã số sinh viên</th>
                            <td><input name="student_id" type="text"></td>
                            <th>Mã phiếu mượn sách</th>
                            <td><input name="book_loan_id" type="text"></td>
                            <td><input name="check" type="submit"></td>
                        </tr>
                    </table>
                </form>
            </div>
            <?php
                require_once "connect.php";
                if (isset($_POST['check'])) {
                    $student_id = $_POST['student_id'];
                    $book_loan_id = $_POST['book_loan_id'];
                    $student_id = mysqli_real_escape_string($conn, $student_id);
                    $book_loan_id = mysqli_real_escape_string($conn, $book_loan_id);
                    if (!empty($student_id) || !empty($book_loan_id)) {
                        $sql = "SELECT bl.book_id, b.book_title, bl.borrow_date, bl.actual_return_date, bl.renewal_count
                                FROM student AS s
                                JOIN book_loan AS bl ON s.student_id = bl.student_id
                                JOIN book AS b ON b.book_id = bl.book_id
                                WHERE s.student_id = '$student_id' OR bl.book_loan_id = '$book_loan_id'";
                        $result = mysqli_query($conn, $sql);
                        if (!$result){
                            die("Kết nối thất bại: " . mysqli_error($conn));
                        }
                }else
                {
                    echo "Bạn chưa điền thông tin";
                }
                }
            ?>
            <div class="resultBox">
            <table class="show">
                <tr style="background-color: rgb(169, 167, 167); color:black">
                    <th>STT</th>
                    <th>Mã số sách</th>
                    <th>Tên sách</th>
                    <th>Ngày mượn</th>
                    <th>Ngày trả</th>
                    <th>Số ngày đã mượn</th>
                    <th>Số lần gia hạn</th>
                    <th>Số ngày quá hạn</th>
                </tr>
                <?php
                    if (isset($result) && mysqli_num_rows($result) > 0) {
                        $stt = 1;
                        while ($row = mysqli_fetch_assoc($result)) {
                            // Tính số ngày đã mượn và số ngày quá hạn
                            $borrow_date = new DateTime($row['borrow_date']);
                            $return_date = $row['actual_return_date'] ? new DateTime($row['actual_return_date']) : new DateTime();
                            $days_borrowed = $borrow_date->diff($return_date)->days;
                            $due_date = (clone $borrow_date)->modify('+14 days');
                            $overdue_days = max(0, $return_date->diff($due_date)->days * -1);
                            echo "<tr>
                                    <td>{$stt}</td>
                                    <td>{$row['book_id']}</td>
                                    <td>{$row['book_title']}</td>
                                    <td>{$row['borrow_date']}</td>
                                    <td>" . ($row['actual_return_date'] ?? "Chưa trả") . "</td>
                                    <td>{$days_borrowed}</td>
                                    <td>{$row['renewal_count']}</td>
                                    <td>{$overdue_days}</td>
                                </tr>";
                            $stt++;
                        }
                    }else 
                    {
                        echo "<tr><td colspan='8'>Không tìm thấy thông tin phù hợp</td></tr>";
                    }
                ?>
            </table>
            </div>
        </div>
        
        <footer class="muonTra__footer">
            <div class="grid">
                <div class="grid_row">
                    <div class="grid_coloumn">
                        <h4 class="footer-heading">TRỤ SỞ/ CƠ SỞ HUB</h4>
                        <hr class="hrline"><br>
                        <ul>
                            <h5 class="footer-heading">TRỤ SỞ CHÍNH</h5>
                            <hr class="hrline">
                            <ul class="footer-list">
                                <li class="footer-item">
                                    <a class="footer-item">
                                    <i class="fa-solid fa-location-dot"></i>    
                                    36 Tôn Thất Đạm, Quận 1, TP.Hồ Chí Minh</a>
                                </li>
                                <li class="footer-item">   
                                    <a class="footer-item">
                                    <i class="fa-solid fa-phone"></i>
                                    (028) 38 291901
                                    </a>
                                </li>
                                <li class="footer-item">
                                    <a class="footer-item">
                                    <i class="fa-regular fa-phone"></i>
                                    (028) 0888 35 34 88 </a>
                                </li>
                                <li class="footer-item">
                                    <a class="footer-item">
                                    <i class="footer-item_icon fa-solid fa-envelope"></i>   
                                    dhnhtphcm@hub.edu.vn </a>
                                </li>
                            </ul><br>
                        </ul>
                        <ul>
                            <h5 class="footer-heading">CƠ SỞ HÀM NGHI</h5>
                            <hr class="hrline">
                            <li class="footer-item">
                                <a class="footer-item">
                                <i class="footer-item_icon fa-solid fa-location-dot"></i>   
                                39 Hàm Nghi, Quận 1, TP.Hồ Chí Minh </a>
                            </li>
                        </ul><br>
                        <ul>
                            <h5 class="footer-heading">TRỤ SỞ THỦ ĐỨC</h5>
                            <hr class="hrline">
                            <li class="footer-item">
                                <a class="footer-item">
                                <i class="footer-item_icon fa-solid fa-location-dot"></i>   
                                56 Hoàng Diệu II, TP.Thủ Đức, TP.Hồ Chí Minh </a>
                            </li>
                        </ul><br>
                    </div>

                    <div class="grid_coloumn">
                        <h4 class="footer_heading">THÔNG TIN CHUNG</h4>
                        <hr class="hrline"><br>
                        <ul>
                            <li class="footer-item">
                                    <a>Giới thiệu</a>
                            </li>
                            <li class="footer-item">
                                    <a>Tuyển sinh</a>
                            </li>
                            <li class="footer-item">
                                    <a>Tra cứu văn bằng</a>
                            </li>
                            <li class="footer-item">
                                    <a>Liên hệ hỏi đáp</a>
                            </li>
                            <li class="footer-item">
                                    <a>Tuyển dụng</a>
                            </li>
                            <li class="footer-item">
                                    <a>HUB Tour</a>
                            </li>
                        <ul>
        
                    </div>

                    <div class="grid_coloumn">
                        <h4 class="footer_heading">DÀNH CHO NGƯỜI HỌC</h4>
                        <hr class="hrline"><br>
                        <ul>
                            <li class="footer-item">
                                    <a>Cổng thông tin đào tạo</a>
                            </li>
                            <li class="footer-item">
                                    <a>E-Student</a>
                            </li>
                            <li class="footer-item">
                                    <a>Học trực tuyến HUB-LMS</a>
                            </li>
                            <li class="footer-item">
                                    <a>Thư viện</a>
                            </li>
                            <li class="footer-item">
                                    <a>Cẩm nang sinh viên</a>
                            </li>
                            <li class="footer-item">
                                    <a>Ký túc xá</a>
                            </li>
                        <ul>
                    
                    </div>

                    <div class="grid_coloumn">
                        <h4 class="footer_heading">DÀNH CHO CBCNV</h4>
                        <hr class="hrline"><br>
                        <ul>
                            <li class="footer-item">
                                    <a>Hệ thống E-OFFICE</a>
                            </li>
                            <li class="footer-item">
                                    <a>Hệ thống HRM</a>
                            </li>
                            <li class="footer-item">
                                    <a>Biểu mẫu</a>
                            </li>
                            <li class="footer-item">
                                    <a>Cổng thông tin đào tạo</a>
                            </li>
                        <ul>
                    
                    </div>
                </div>
            </div>           
        </footer> 
    </div>
</body>
</html>