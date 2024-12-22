<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>THUVIEN</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>
                /* Tổng quan */
                body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
            margin: 0;
            padding: 20px;
        }

        .container {
            max-width: 900px;
            background-color: white;
            padding: 30px;
            margin: auto;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        h2 {
            text-align: center;
            font-weight: bold;
            color:rgb(221, 6, 6);
            margin-bottom: 10px;
            font-size: 22px;
        }

        label {
            font-weight: bold;
            color: #333;
        }

        .form-control, .form-check-input {
            border: 1px solid #ccc;
            border-radius: 5px;
            transition: all 0.3s;
        }

        .form-control:focus {
            border-color: #b71c1c;
            box-shadow: 0 0 5px rgba(183, 28, 28, 0.3);
        }

        .form-check-input:checked {
            background-color: #b71c1c;
            border-color: #b71c1c;
        }

        .total-fine {
            color: #b71c1c;
            font-weight: bold;
            font-size: 18px;
            text-align: center;
            margin-top: 15px;
        }

        textarea {
            resize: none;
            height: 80px;
        }

        .btn-custom {
            background-color: #b71c1c;
            color: white;
            border: none;
            padding: 8px 15px;
            margin: 5px;
            border-radius: 5px;
        }

        .btn-custom:hover {
            background-color: #8e1515;
        }

        .btn-secondary {
            margin: 5px;
            padding: 8px 15px;
        }

        /* Header */
        .header {
            background: url('https://i.postimg.cc/G3Z1BVXj/Nen.png') no-repeat center center;
            background-size: cover;
            height: 185px;
            
        }
        /* Navbar */
        .navbar {
            background-color: #b71c1c;
            height: 50px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0 20px;
        }
        .navbar div {
            display: flex;
            align-items: stretch;
        }
        .navbar a {
            color: white;
            text-decoration: none;
            font-weight: bold;
            padding: 0 15px;
            display: flex;
            align-items: center;
            height: 100%;
            position: relative;
        }
        .navbar a:not(:last-child)::after {
            content: "";
            position: absolute;
            right: 0;
            top: 0;
            bottom: 0;
            width: 1px;
            background-color: white;
            opacity: 0.6;
        }
        .navbar a:hover {
            background-color: #8e1515;
            color: #ddd;
        }
        .navbar .user {
            display: flex;
            align-items: center;
        }
        .navbar .user a {
            color: white;
            text-decoration: none;
            margin-right: 15px;
        }
        .navbar .user i {
            margin-right: 5px;
        }
        .navbar .user img {
            width: 20px;
            margin-left: 10px;
        }
        /* Biến Gốc */
        :root {
            --circle-size: 16px; /* Đường kính hình tròn */
            --spacing: 80px; /* Khoảng cách giữa các hình tròn */
            --line-padding: 20px; /* Khoảng cách đường line hai bên */
            --left-panel-width: 267px; /* Chiều rộng phần XỬ LÝ VI PHẠM */
            --right-panel-width: 340px; /* Chiều rộng phần Stepper */
            --step-container-height: 63px; /* Chiều cao container Stepper */
            }

            /* Wrapper Chính */
            .step-wrapper {
              display: flex;
              align-items: center;
              justify-content: space-between;
              width: 100%;
              height: var(--step-container-height);
              border: 1px solid #e0e0e0;
              overflow: hidden;
              background-color: #f9f9f9;
            }

            /* Phần Bên Trái - XỬ LÝ VI PHẠM */
            .step-left {
              width: var(--left-panel-width);
              height: 100%;
              background: linear-gradient(to right,rgb(33, 50, 104),rgb(33, 50, 104)); /* Màu gradient đỏ */
              display: flex;
              align-items: center;
              justify-content: center;
              clip-path: polygon(0 0, 100% 0, 90% 100%, 0 100%); /* Hình thang vuông */
              color: #fff;
              font-size: 1rem;
              font-weight: bold;
              text-transform: uppercase;
            }

            /* Phần Ở Giữa (Trống) */
            .step-middle {
              flex: 1; /* Phần giữa chiếm phần còn lại */
              background-color: transparent; /* Phần giữa để trống */
            }

            /* Phần Bên Phải - Stepper */
            .step-right {
              width: var(--right-panel-width);
              height: 100%;
              background-color: #f9f9f9;
              display: flex;
              align-items: center;
              justify-content: center;
            }

            /* Stepper Container */
            .c-stepper {
              display: flex;
              align-items: center;
              justify-content: space-between;
              text-align: center;
              position: relative;
              padding: 0 var(--line-padding);
              max-width: var(--right-panel-width);
              width: 100%;
            }

            /* Đường Line Chính */
            .c-stepper::before {
              content: "";
              position: absolute;
              top: calc(var(--circle-size) / 2);
              left: var(--line-padding);
              right: var(--line-padding);
              height: 2px;
              background-color: #e0e0e0;
              z-index: 0;
            }

            /* Mỗi Bước Trong Stepper */
            .c-stepper__item {
              display: flex;
              flex-direction: column;
              align-items: center;
              text-align: center;
              position: relative;
              z-index: 1;
              flex: 0 0 auto;
              width: calc(var(--circle-size) + var(--spacing));
            }

            /* Hình Tròn */
            .c-stepper__item:before {
              content: "";
              display: block;
              width: var(--circle-size);
              height: var(--circle-size);
              border-radius: 50%;
              background-color: red;
              opacity: 0.8;
              z-index: 2;
              margin-bottom: 1rem;
            }

            /* Đường Line Riêng Giữa Hình Tròn */
            .c-stepper__item:not(:last-child)::after {
              content: "";
              position: absolute;
              top: calc(var(--circle-size) / 2);
              left: calc(var(--circle-size) / 2);
              width: calc(var(--spacing) - var(--circle-size) - var(--line-padding));
              height: 2px;
              background-color: #e0e0e0;
              z-index: 0;
            }

            /* Tiêu Đề */
            .c-stepper__title {
              font-size: 0.7rem;
              font-weight: bold;
              margin-top: 0.2rem;
              white-space: nowrap;
              position: absolute;
              top: calc(var(--circle-size) + 10px);
            }

            /* Mô Tả */
            .c-stepper__desc {
              font-size: 0.6rem;
              color: grey;
              white-space: nowrap;
              position: absolute;
              top: calc(var(--circle-size) + 25px);
            }
            .c-stepper__item.active::before {
              background-color:rgb(33, 50, 104);
            }
            .c-stepper__item.active::after {
    content: '★';
    font-size: 1.5rem;
    color: gold;
    position: absolute;
    top: -20px;
    right: -10px;
    animation: star-pulse 1s infinite;
}

/* Hiệu ứng Star Pulse */
@keyframes star-pulse {
    0% {
        transform: scale(1);
        opacity: 0.8;
    }
    50% {
        transform: scale(1.2);
        opacity: 1;
    }
    100% {
        transform: scale(1);
        opacity: 0.8;
    }
}
@keyframes bounce {
    0%, 100% {
        transform: translateY(0);
    }
    50% {
        transform: translateY(-10px);
    }
}


            .total-fine {
    color: #b71c1c;
    font-weight: bold;
    font-size: 18px;
    text-align: center;
    margin-top: 15px;
}
/* Nội dung cuộn riêng biệt */
.violation-scrollable {
    max-height: 400px; /* Chiều cao tối đa */
    overflow-y: auto; /* Cho phép cuộn dọc */
    overflow-x: hidden; /* Ẩn cuộn ngang */
    border: 1px solid #ccc;
    padding: 15px;
    margin-top: 10px;
    background-color: #fff;
    border-radius: 5px;
}

/* Thanh cuộn tùy chỉnh */
.violation-scrollable::-webkit-scrollbar {
    width: 8px;
}

.violation-scrollable::-webkit-scrollbar-thumb {
    background-color:rgb(44, 28, 183);
    border-radius: 4px;
}

.violation-scrollable::-webkit-scrollbar-thumb:hover {
    background-color: #8e1515;
}

/* Nút cố định bên ngoài */
.violation-buttons {
    display: flex;
    justify-content: center;
    gap: 10px;
    margin-top: 20px;
    padding: 10px 0;
    border-top: 1px solid #ccc;
    background: #fff;
    border-radius: 5px;
    position: sticky;
    bottom: 0;
    z-index: 10;
}
.language-changed {
    animation: fadeIn 0.5s ease-in-out;
}

@keyframes fadeIn {
    from { opacity: 0.5; }
    to { opacity: 1; }
}

@media print {
    body * {
        visibility: hidden; /* Ẩn tất cả nội dung trang */
    }

    .violation-scrollable, .violation-scrollable * {
        visibility: visible; /* Hiển thị phần Biên bản Vi Phạm */
    }

    .violation-scrollable {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        margin: 0;
        padding: 20px;
        box-shadow: none;
    }

    /* Ẩn các nút và header khi in */
    .navbar, .header, .step-wrapper, .total-fine, .violation-buttons {
        display: none;
    }
}

    </style>
</head>
<body>
    <!-- Header -->
    <div class="header"></div>
    <!-- Navbar -->
    <div class="navbar">
        <div>
        <a href="#" data-lang-key="home">TRANG CHỦ</a>
        <a href="#" data-lang-key="news">TIN TỨC</a>
        <a href="#" data-lang-key="about">GIỚI THIỆU</a>
        <a href="#" data-lang-key="book_management">QUẢN LÝ SÁCH</a>
        <a href="#" data-lang-key="borrow_return">QUẢN LÝ MƯỢN - TRẢ SÁCH</a>
        <a href="#" data-lang-key="violation">XỬ LÝ VI PHẠM</a>
        <a href="#" data-lang-key="guide">HƯỚNG DẪN</a>
        </div>
        <div class="user">
    <a href="#" data-lang-key="login"><i class="fas fa-user"></i> Đăng nhập</a>
    <img src="https://cdn-icons-png.flaticon.com/512/197/197473.png" alt="Vietnam" 
         onclick="changeLanguage('vi')" style="cursor: pointer;">
    <img src="https://cdn-icons-png.flaticon.com/512/197/197374.png" alt="English" 
         onclick="changeLanguage('en')" style="cursor: pointer;">
</div>

    </div>
    <div class="step-wrapper">
    <!-- Phần Bên Trái -->
    <div class="step-left" data-lang-key="violation">XỬ LÝ VI PHẠM</div>
    <!-- Phần Ở Giữa (Trống) -->
    <div class="step-middle"></div>
    <!-- Phần Bên Phải -->
    <div class="step-right">
        <div class="c-stepper">
            <div class="c-stepper__item" id="step-draft">
                <div class="c-stepper__title" data-lang-key="step_input">NHẬP</div>
            </div>
            <div class="c-stepper__item" id="step-confirm">
                <div class="c-stepper__title" data-lang-key="step_confirm">XÁC NHẬN</div>
            </div>
            <div class="c-stepper__item" id="step-email">
                <div class="c-stepper__title" data-lang-key="step_email">IN/GỬI EMAIL</div>
            </div>
        </div>
    </div>
</div>
<script>
  document.addEventListener("DOMContentLoaded", function () {
    const stepperItems = document.querySelectorAll(".c-stepper__item");
    const btnTaoLai = document.querySelector(".btn-custom:nth-child(1)");
    const btnXacNhan = document.querySelector(".btn-custom:nth-child(2)");
    const btnIn = document.querySelector(".btn-secondary:nth-child(3)");
    const btnGuiEmail = document.querySelector(".btn-secondary:nth-child(4)");

    // Hàm kích hoạt hiệu ứng cho bước hiện tại
    function activateStep(index) {
        stepperItems.forEach((item, i) => {
            item.classList.remove("active", "completed");
            if (i === index) {
                item.classList.add("active");
                item.style.animation = 'bounce 0.6s ease-in-out';
            }
            if (i < index) {
                item.classList.add("completed");
            }
        });
    }

    // Hiệu ứng bounce cho bước hiện tại
    stepperItems.forEach((item) => {
        item.addEventListener("animationend", () => {
            item.style.animation = '';
        });
    });

    // Mặc định kích hoạt bước đầu tiên
    activateStep(0);

    // Sự kiện nút
    btnTaoLai.addEventListener("click", () => activateStep(0));
    btnXacNhan.addEventListener("click", () => activateStep(1));
    btnIn.addEventListener("click", () => activateStep(2));
    btnGuiEmail.addEventListener("click", () => activateStep(2));
});

</script>
    <!-- Nội dung chính -->
    <div class="container">
    <h2 data-lang-key="violation_report">BIÊN BẢN VI PHẠM</h2>
        <form>
            <!-- Mã biên bản và Mã thẻ SV -->
            <div class="violation-scrollable">
            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="maBienBan">Mã biên bản:</label>
                    <input type="text" class="form-control" id="maBienBan" placeholder="Nhập mã biên bản">
                </div>
                <div class="col-md-6">
                    <label for="maThe">Mã thẻ SV:</label>
                    <input type="text" class="form-control" id="maThe" placeholder="Nhập mã thẻ SV">
                </div>
            </div>

            <!-- Họ và tên, Mã sách -->
            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="hoTen">Họ và tên:</label>
                    <input type="text" class="form-control" id="hoTen" placeholder="Nhập họ và tên">
                </div>
                <div class="col-md-6">
                    <label for="maSach">Mã sách:</label>
                    <input type="text" class="form-control" id="maSach" placeholder="Nhập mã sách">
                </div>
            </div>

            <!-- Ngày mượn sách và Ngày trả sách -->
            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="ngayMuon">Ngày mượn sách:</label>
                    <input type="date" class="form-control" id="ngayMuon">
                </div>
                <div class="col-md-6">
                    <label for="ngayTra">Ngày trả sách:</label>
                    <input type="date" class="form-control" id="ngayTra">
                </div>
            </div>

            <!-- Nội dung vi phạm -->
            <div class="row mb-3">
                <label class="mb-2">Nội dung vi phạm:</label>
                <div class="col-md-4">
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input" id="quaHan" onchange="calculateFine()">
                        <label for="quaHan" class="form-check-label">Quá hạn</label>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input" id="huSach" onchange="calculateFine()">
                        <label for="huSach" class="form-check-label">Hư sách</label>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input" id="matSach" onchange="calculateFine()">
                        <label for="matSach" class="form-check-label">Mất sách</label>
                    </div>
                </div>
            </div>

            <!-- Mô tả nội dung vi phạm -->
            <div class="row mb-3">
                <label for="moTa">Mô tả nội dung vi phạm:</label>
                <textarea id="moTa" class="form-control" placeholder="Nhập mô tả chi tiết"></textarea>
            </div>

            <!-- Số ngày quá hạn và Tiền phạt -->
            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="soNgay">Số ngày quá hạn:</label>
                    <input type="number" class="form-control" id="soNgay" placeholder="Nhập số ngày">
                </div>
                <div class="col-md-6">
                    <label for="tienPhat">Tiền phạt:</label>
                    <input type="text" class="form-control" id="tienPhat" placeholder="VNĐ">
                </div>
            </div>
             <!-- Số trang hư hại và Tiền phạt -->
             <div class="row mb-3">
                <div class="col-md-6">
                    <label for="soTrang">Số trang hư hại:</label>
                    <input type="text" class="form-control" id="soTrang" placeholder="Nhập số trang">
                </div>
                <div class="col-md-6">
                    <label for="tienPhatTrang">Tiền phạt:</label>
                    <input type="text" class="form-control" id="tienPhatTrang" placeholder="VNĐ">
                </div>
            </div>
            <!-- Hình thức xử lý -->
            <div class="row mb-3">
                <label class="mb-2">Hình thức xử lý:</label>
                <div class="col-md-6">
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input" id="phatTien">
                        <label for="phatTien" class="form-check-label">Phạt tiền</label>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input" id="traSach">
                        <label for="traSach" class="form-check-label">Trả sách</label>
                    </div>
                </div>
            </div>
            </div>
            <!-- Tổng tiền phạt -->
            <div class="total-fine">
    Tổng tiền phạt: <span id="tongTienPhat">0 VNĐ</span>
</div>

            <!-- Nút thao tác -->
            <div class="text-center mt-4">
            <button type="button" class="btn btn-custom" data-lang-key="reset" onclick="resetForm()">Tạo lại</button>
    <button type="button" class="btn btn-custom" data-lang-key="confirm" onclick="confirmForm()">Xác nhận</button>
    <button type="button" class="btn btn-secondary" data-lang-key="print" onclick="printForm()">In biên bản</button>
    <button type="button" class="btn btn-secondary" data-lang-key="email" onclick="sendEmail()">Gửi email</button>
</div>
            
        </form>
    </div>
    <script>
        function setStep(step) {
            document.querySelectorAll('.step').forEach(s => s.classList.remove('active', 'completed'));
            ['draft', 'confirm', 'print', 'email'].forEach((id, index) => {
                if (id === step) document.getElementById(`step-${id}`).classList.add('active');
                if (index < ['draft', 'confirm', 'print', 'email'].indexOf(step)) document.getElementById(`step-${id}`).classList.add('completed');
            });
        }
    </script>
        <script>
        function calculateFine() {
    let fine = 0;
    if (document.getElementById('quaHan').checked) fine += 50000;
    if (document.getElementById('huSach').checked) fine += 100000;
    if (document.getElementById('matSach').checked) fine += 200000;
    document.getElementById('tongTienPhat').innerText = fine.toLocaleString('vi-VN') + ' VNĐ';
}


        function resetForm() {
            document.querySelector('form').reset();
            calculateFine();
        }

        function confirmForm() {
            alert('Thông tin đã được xác nhận.');
        }

        function printForm() {
    const violationContent = document.querySelector('.violation-scrollable').innerHTML; // Lấy nội dung Biên bản vi phạm
    const originalContent = document.body.innerHTML; // Lưu lại toàn bộ nội dung ban đầu của trang

    // Tạm thay đổi nội dung body để chỉ chứa phần Biên bản
    document.body.innerHTML = `<div>${violationContent}</div>`;
    window.print(); // In nội dung đã thay đổi

    // Khôi phục lại nội dung gốc
    document.body.innerHTML = originalContent;
    location.reload(); // Tải lại trang để đảm bảo JavaScript hoạt động bình thường
}
        function sendEmail() {
            alert('Email đã được gửi.');
        }
        function resetForm() {
    document.querySelector('form').reset();
    calculateFine();
}
function confirmForm() {
    alert('Thông tin đã được xác nhận.');
}
function printForm() {
    window.print();
}
function sendEmail() {
    alert('Email đã được gửi.');
}
function changeLanguage(lang) {
    fetch(`trans.php?lang=${lang}`)
        .then(response => response.json())
        .then(data => {
            document.querySelectorAll("[data-lang-key]").forEach(element => {
                const key = element.getAttribute("data-lang-key");
                if (data[key]) {
                    if (['INPUT', 'TEXTAREA'].includes(element.tagName)) {
                        element.placeholder = data[key];
                    } else {
                        element.innerText = data[key];
                    }
                }
            });
        })
        .catch(error => console.error('Translation Error:', error));
}
function changeLanguage(lang) {
    fetch(`trans.php?lang=${lang}`)
        .then(response => response.json())
        .then(data => {
            document.querySelectorAll("[data-lang-key]").forEach(element => {
                const key = element.getAttribute("data-lang-key");
                if (data[key]) {
                    if (['INPUT', 'TEXTAREA'].includes(element.tagName)) {
                        element.placeholder = data[key];
                    } else {
                        element.innerText = data[key];
                    }
                }
            });
            document.body.classList.add('language-changed');
            setTimeout(() => document.body.classList.remove('language-changed'), 500);
        })
        .catch(error => console.error('Translation Error:', error));
}


    </script>

</body>
</html>
 <!-- Nút thao tác -->