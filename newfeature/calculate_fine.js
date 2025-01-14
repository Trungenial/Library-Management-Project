function calculateFine(basePrice, overdueDays) {
    // Lấy giá trị từ form
    const soNgay = overdueDays || 0;
    const soTrang = parseInt(document.getElementById('soTrang').value) || 0;
    const quaHan = document.getElementById('quaHan').checked;
    const huSach = document.getElementById('huSach').checked;
    const matSach = document.getElementById('matSach').checked;

    let tienPhatQuaHan = 0;
    let tienPhatTrang = 0;
    let tienPhatMatSach = 0;

    // Tính tiền phạt quá hạn
    if (quaHan) {
        tienPhatQuaHan = soNgay * 5000;
    }

    // Tính tiền phạt hư sách
    if (huSach) {
        tienPhatTrang = soTrang * 10000;
    }

    // Tính tiền phạt mất sách
    if (matSach) {
        tienPhatMatSach = basePrice * 2 || 0;
    }

    // Tính tổng tiền phạt
    const tongTienPhat = tienPhatQuaHan + tienPhatTrang + tienPhatMatSach;

    // Hiển thị giá trị vào các ô tương ứng
    document.getElementById('soNgay').value = soNgay;
    document.getElementById('tienPhat').value = tienPhatQuaHan.toLocaleString('vi-VN') + ' VNĐ';
    document.getElementById('tienPhatTrang').value = tienPhatTrang.toLocaleString('vi-VN') + ' VNĐ';
    document.getElementById('tongTienPhat').value = tongTienPhat.toLocaleString('vi-VN') + ' VNĐ';

    // Cập nhật hidden input để gửi dữ liệu
    document.getElementById('hiddenSoTrang').value = soTrang;
    document.getElementById('hiddenTongTienPhat').value = tongTienPhat;
}

// Reset form
function resetForm() {
    document.querySelector('form').reset();
    document.getElementById('tienPhat').value = '0 VNĐ';
    document.getElementById('tienPhatTrang').value = '0 VNĐ';
    document.getElementById('tongTienPhat').value = '0 VNĐ';
    document.getElementById('hiddenSoTrang').value = 0;
    document.getElementById('hiddenTongTienPhat').value = 0;
}

// Mô tả nội dung vi phạm
function updateDescription() {
    const descriptionField = document.getElementById('moTa');
    const checkboxes = [
        { id: 'quaHan', label: 'Quá hạn:' },
        { id: 'huSach', label: 'Hư sách:' },
        { id: 'matSach', label: 'Mất sách:' }
    ];

    let descriptions = [];
    checkboxes.forEach(checkbox => {
        const element = document.getElementById(checkbox.id);
        if (element.checked) {
            descriptions.push(`- ${checkbox.label}`);
        }
    });

    descriptionField.value = descriptions.join('\n');
}

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
