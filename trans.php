<?php
$lang = $_GET['lang'] ?? 'vi';

$translations = [
    'vi' => [
        'home' => 'TRANG CHỦ',
        'news' => 'TIN TỨC',
        'about' => 'GIỚI THIỆU',
        'book_management' => 'QUẢN LÝ SÁCH',
        'borrow_return' => 'QUẢN LÝ MƯỢN - TRẢ SÁCH',
        'violation' => 'XỬ LÝ VI PHẠM',
        'guide' => 'HƯỚNG DẪN',
        'login' => 'Đăng nhập',
        'step_input' => 'NHẬP',
        'step_confirm' => 'XÁC NHẬN',
        'step_email' => 'IN/GỬI EMAIL',
        'reset' => 'Tạo lại',
        'confirm' => 'Xác nhận',
        'print' => 'In biên bản',
        'email' => 'Gửi email',
        'violation_report' => 'BIÊN BẢN VI PHẠM'
    ],
    'en' => [
        'home' => 'HOME',
        'news' => 'NEWS',
        'about' => 'ABOUT',
        'book_management' => 'BOOK MANAGEMENT',
        'borrow_return' => 'BORROW - RETURN BOOKS',
        'violation' => 'VIOLATION HANDLING',
        'guide' => 'GUIDE',
        'login' => 'Login',
        'step_input' => 'INPUT',
        'step_confirm' => 'CONFIRM',
        'step_email' => 'PRINT/SEND EMAIL',
        'reset' => 'Reset',
        'confirm' => 'Confirm',
        'print' => 'Print Report',
        'email' => 'Send Email',
         'violation_report' => 'VIOLATION REPORT'

    ]
];

header('Content-Type: application/json');
echo json_encode($translations[$lang]);
?>
 <!-- Nút thao tác -->
