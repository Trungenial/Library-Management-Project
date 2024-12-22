<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Biên Bản Vi Phạm</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        body {
            background-color: #f4f4f8;
            font-family: Arial, sans-serif;
            color: #333;
        }

        .container {
            background: #ffffff;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            padding: 20px 30px;
            max-width: 800px;
            margin: 40px auto;
            animation: fadeIn 1s ease-in-out;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        h2 {
            color: #b71c1c;
            font-weight: bold;
            text-align: center;
            margin-bottom: 20px;
        }

        .row {
            margin-bottom: 15px;
        }

        label {
            font-weight: bold;
            color: #555;
        }

        .form-control {
            border: none;
            border-bottom: 2px solid #ddd;
            border-radius: 0;
            box-shadow: none;
            font-size: 14px;
        }

        .form-control:focus {
            border-bottom: 2px solid #b71c1c;
            outline: none;
            box-shadow: none;
        }

        .form-check-input {
            border-color: #b71c1c;
        }

        .form-check-input:checked {
            background-color: #b71c1c;
            border-color: #b71c1c;
        }

        .btn-custom {
            background-color: #b71c1c;
            color: white;
            border: none;
            margin: 10px 5px;
        }

        .btn-custom:hover {
            background-color: #8e1515;
        }

        .total-fine {
            font-size: 18px;
            font-weight: bold;
            color: #b71c1c;
            text-align: right;
        }

        /* Ẩn viền của table */
        .table-custom td, .table-custom th {
            border: none;
            padding: 8px;
            vertical-align: middle;
        }

        .table-custom {
            width: 100%;
            margin: 20px 0;
        }

        /* Hiệu ứng cho các ô dữ liệu */
        .table-custom input[type="text"], .table-custom textarea {
            background-color: #fafafa;
            transition: all 0.3s ease-in-out;
        }

        .table-custom input[type="text"]:focus, .table-custom textarea:focus {
            background-color: #fff;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

    </style>
</head>
<body>
    <div class="container">
        <h2>Biên Bản Vi Phạm</h2>
        <form>
            <!-- Mã biên bản và Mã SV -->
            <div class="row">
                <div class="col-md-6">
                    <label>Mã biên bản:</label>
                    <input type="text" class="form-control" placeholder="Nhập mã biên bản">
                </div>
                <div class="col-md-6">
                    <label>Mã thẻ SV:</label>
                    <input type="text" class="form-control" placeholder="Nhập mã thẻ SV">
                </div>
            </div>

            <!-- Họ và tên, Mã sách -->
            <div class="row">
                <div class="col-md-6">
                    <label>Họ và tên:</label>
                    <input type="text" class="form-control" placeholder="Nhập họ và tên">
                </div>
                <div class="col-md-6">
                    <label>Mã sách:</label>
                    <input type="text" class="form-control" placeholder="Nhập mã sách">
                </div>
            </div>

            <!-- Nội dung vi phạm -->
            <div class="row">
                <label>Nội dung vi phạm:</label>
                <div class="col-12">
                    <div class="form-check form-check-inline">
                        <input type="checkbox" class="form-check-input" id="late">
                        <label class="form-check-label" for="late">Quá hạn</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input type="checkbox" class="form-check-input" id="damaged">
                        <label class="form-check-label" for="damaged">Hư sách</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input type="checkbox" class="form-check-input" id="lost">
                        <label class="form-check-label" for="lost">Mất sách</label>
                    </div>
                </div>
            </div>

            <!-- Số ngày quá hạn và Tiền phạt -->
            <div class="row">
                <div class="col-md-3">
                    <label>Số ngày quá hạn:</label>
                    <input type="text" class="form-control" placeholder="Nhập số ngày">
                </div>
                <div class="col-md-3">
                    <label>Tiền phạt:</label>
                    <input type="text" class="form-control" placeholder="VNĐ">
                </div>
                <div class="col-md-3">
                    <label>Số trang hư hại:</label>
                    <input type="text" class="form-control" placeholder="Nhập số trang">
                </div>
                <div class="col-md-3">
                    <label>Tiền phạt:</label>
                    <input type="text" class="form-control" placeholder="VNĐ">
                </div>
            </div>

            <!-- Hình thức xử lý -->
            <div class="row mt-3">
                <div class="col-md-6">
                    <label>Hình thức xử lý:</label>
                    <div class="col-12">
                    <div class="form-check form-check-inline">
                        <input type="checkbox" class="form-check-input" id="late">
                        <label class="form-check-label" for="late">Phạt tiền </label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input type="checkbox" class="form-check-input" id="damaged">
                        <label class="form-check-label" for="damaged">Trả sách </label>
                    </div>
                </div>
                <div class="col-md-6 total-fine">
                    Tổng tiền phạt: 0 VNĐ
                </div>
            </div>

            <!-- Nút thao tác -->
            <div class="text-center mt-4">
                <button type="button" class="btn btn-custom">Tạo lại</button>
                <button type="button" class="btn btn-custom">Xác nhận</button>
                <button type="button" class="btn btn-secondary">In biên bản</button>
                <button type="button" class="btn btn-secondary">Gửi email</button>
            </div>
        </form>
    </div>
</body>
</html>
