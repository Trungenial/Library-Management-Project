<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dynamic Stepper</title>
    <style>
        /* Biến Gốc */
        :root {
            --circle-size: 16px; 
            --spacing: 80px; 
            --line-padding: 20px; 
            --step-container-height: 63px;
        }

        /* Tổng quan */
        body {
            font-family: Arial, sans-serif;
            background-color: #f9f9f9;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        /* Wrapper */
        .layout-container {
            display: flex;
            align-items: flex-start;
            gap: 30px;
        }

        .step-wrapper {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 100%;
            max-width: 800px;
            height: var(--step-container-height);
            border: 1px solid #e0e0e0;
            background-color: #fff;
            position: relative;
            overflow: hidden;
        }

        /* Stepper */
        .c-stepper {
            display: flex;
            align-items: center;
            justify-content: space-between;
            position: relative;
            width: 100%;
            padding: 0 var(--line-padding);
        }

        .c-stepper::before {
            content: "";
            position: absolute;
            top: calc(var(--circle-size) / 2);
            left: var(--line-padding);
            right: var(--line-padding);
            height: 2px;
            background-color: #e0e0e0;
            z-index: 0;
            transition: all 0.5s ease;
        }

        .c-stepper__item {
            position: relative;
            display: flex;
            flex-direction: column;
            align-items: center;
            z-index: 1;
            flex: 0 0 auto;
            width: calc(var(--circle-size) + var(--spacing));
            transition: transform 0.5s ease;
        }

        /* Hình Tròn */
        .c-stepper__item::before {
            content: "";
            width: var(--circle-size);
            height: var(--circle-size);
            border-radius: 50%;
            background-color: #d3d3d3;
            margin-bottom: 8px;
            transition: background-color 0.3s ease, transform 0.3s ease;
            transform: scale(1);
        }

        .c-stepper__item.active::before {
            background-color: #007bff;
            animation: pulse 1s infinite alternate;
        }

        .c-stepper__item.completed::before {
            background-color: #28a745;
        }

        /* Hiệu ứng động khi bước hoạt động */
        .c-stepper__item.active {
            transform: scale(1.1);
        }

        /* Tiêu Đề */
        .c-stepper__title {
            font-size: 0.8rem;
            font-weight: bold;
            margin-top: 4px;
            opacity: 0.7;
            transition: opacity 0.3s ease, transform 0.3s ease;
        }

        .c-stepper__item.active .c-stepper__title {
            opacity: 1;
            transform: scale(1.1);
        }

        /* Hiệu ứng animation */
        @keyframes pulse {
            0% {
                transform: scale(1);
                box-shadow: 0 0 10px rgba(0, 123, 255, 0.5);
            }
            100% {
                transform: scale(1.2);
                box-shadow: 0 0 20px rgba(0, 123, 255, 0.7);
            }
        }

        /* Button Group */
        .button-group {
    display: flex;
    flex-direction: row; /* Chuyển thành hàng ngang */
    align-items: center;
    gap: 20px; /* Khoảng cách giữa các nút */
}

.button {
    display: flex;
    flex-direction: row;
    align-items: center; /* Căn giữa theo chiều dọc */
    justify-content: center; /* Căn giữa theo chiều ngang */
    width: 50px;
    height: 50px;
    border-radius: 50%;
    background-color: rgb(20, 20, 20);
    border: none;
    font-weight: 600;
    box-shadow: 0px 0px 20px rgba(0, 0, 0, 0.164);
    cursor: pointer;
    transition: all 0.3s;
    overflow: hidden;
    position: relative;
}

.button:hover {
    width: 140px;
    border-radius: 50px;
    background-color: rgb(255, 69, 69);
    transition-duration: 0.3s;
}

.svgIcon {
    width: 20px;
    height: 20px;
    margin-right: 8px; /* Khoảng cách giữa icon và chữ */
    transition-duration: 0.3s;
}

.button span {
    font-size: 14px;
    color: white;
    font-weight: bold;
    white-space: nowrap;
    opacity: 0;
    transition: opacity 0.3s ease;
}

.button:hover span {
    opacity: 1;
}

        .button:hover span {
            opacity: 1;
        }

        .button-content {
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .button.cancel {
            background-color: black;
        }

        .button.reset {
            background-color: gray;
        }

        .button.confirm {
            background-color: rgb(0, 123, 255);
        }

        .button.print {
            background-color: rgb(255, 165, 0);
        }

        .button.email {
            background-color: rgb(34, 193, 195);
        }
    </style>
</head>
<body>
<div class="layout-container">
    <div class="step-wrapper">
        <!-- Stepper -->
        <div class="c-stepper">
            <div class="c-stepper__item" id="step-draft">
                <div class="c-stepper__title">NHẬP</div>
            </div>
            <div class="c-stepper__item" id="step-confirm">
                <div class="c-stepper__title">XÁC NHẬN</div>
            </div>
            <div class="c-stepper__item" id="step-email">
                <div class="c-stepper__title">IN/GỬI EMAIL</div>
            </div>
        </div>
    </div>

    <div class="button-group">
        <!-- Nút Hủy bỏ -->
        <button class="button cancel">
            <div class="button-content">
                <svg viewBox="0 0 448 512" class="svgIcon">
                    <path d="M135.2 17.7L128 32H32C14.3 32 0 46.3 0 64S14.3 96 32 96H416c17.7 0 32-14.3 32-32s-14.3-32-32-32H320l-7.2-14.3C307.4 6.8 296.3 0 284.2 0H163.8c-12.1 0-23.2 6.8-28.6 17.7zM416 128H32L53.2 467c1.6 25.3 22.6 45 47.9 45H346.9c25.3 0 46.3-19.7 47.9-45L416 128z"></path>
                </svg>
                <span>Hủy bỏ</span>
            </div>
        </button>

        <!-- Nút Tạo lại -->
        <button class="button reset">
            <div class="button-content">
                <svg viewBox="0 0 512 512" class="svgIcon">
                    <path d="M500.33 93.65C510.59 104.66 512.45 121.29 501.43 131.55L445.82 179.2C440.77 183.74 434.17 186.29 427.38 186.29C413.18 186.29 401.65 174.75 401.65 160.56V128C229.31 128 119.64 211.19 73.69 293.62C64.4 310.68 45.71 315.86 28.65 306.57C11.59 297.28 6.41 278.59 15.7 261.53C72.57 152.93 201.24 64 401.65 64V32C401.65 17.8 413.18 6.27 427.38 6.27C434.17 6.27 440.77 8.82 445.82 13.37L501.43 61.02C512.45 71.27 510.59 87.91 500.33 93.65ZM401.65 480C430.7 480 453.44 457.26 453.44 428.21C453.44 399.16 430.7 376.41 401.65 376.41H127.25C98.2 376.41 75.46 399.16 75.46 428.21C75.46 457.26 98.2 480 127.25 480H401.65Z"></path>
                </svg>
                <span>Tạo lại</span>
            </div>
        </button>

        <!-- Nút Xác nhận -->
        <button class="button confirm">
            <div class="button-content">
                <svg viewBox="0 0 512 512" class="svgIcon">
                    <path d="M504 256c0 136.967-111.033 248-248 248S8 392.967 8 256 119.033 8 256 8s248 111.033 248 248zm-368-16l-80-80c-9.375-9.375-24.569-9.375-33.941 0s-9.375 24.569 0 33.941l96 96c9.375 9.375 24.569 9.375 33.941 0l224-224c9.375-9.375 9.375-24.569 0-33.941s-24.569-9.375-33.941 0L136 240z"></path>
                </svg>
                <span>Xác nhận</span>
            </div>
        </button>

        <!-- Nút In -->
        <button class="button print">
            <div class="button-content">
                <svg viewBox="0 0 512 512" class="svgIcon">
                    <path d="M432 128h-32V56c0-30.9-25.1-56-56-56H168c-30.9 0-56 25.1-56 56v72H80c-44.1 0-80 35.9-80 80v96c0 17.7 14.3 32 32 32h16v96c0 22.1 17.9 40 40 40h288c22.1 0 40-17.9 40-40v-96h16c17.7 0 32-14.3 32-32v-96c0-44.1-35.9-80-80-80zM144 56c0-13.3 10.7-24 24-24h176c13.3 0 24 10.7 24 24v72H144V56zm224 400H144V352h224v104zm80-184c0 8.8-7.2 16-16 16h-16v-48c0-8.8-7.2-16-16-16H112c-8.8 0-16 7.2-16 16v48H80c-8.8 0-16-7.2-16-16v-96c0-26.5 21.5-48 48-48h304c26.5 0 48 21.5 48 48v96z"></path>
                </svg>
                <span>In</span>
            </div>
        </button>

        <!-- Nút Gửi email -->
        <button class="button email">
            <div class="button-content">
                <svg viewBox="0 0 512 512" class="svgIcon">
                    <path d="M502.3 190.8l-192-160C300.4 22.4 289.2 16 277.5 16H64C28.7 16 0 44.7 0 80v352c0 35.3 28.7 64 64 64h384c35.3 0 64-28.7 64-64V224c0-19.2-8.4-37.3-22.7-49.2zM384 136L216 262.7 48 136h336zm80 264c0 8.8-7.2 16-16 16H64c-8.8 0-16-7.2-16-16V200l200 166.7c6 5 13.7 7.3 21.3 7.3s15.3-2.3 21.3-7.3L464 200v200z"></path>
                </svg>
                <span>Gửi email</span>
            </div>
        </button>
    </div>
</div>
<script>
    function setStep(step) {
        const steps = ['draft', 'confirm', 'email'];
        steps.forEach((id, index) => {
            const stepElement = document.getElementById(`step-${id}`);
            stepElement.classList.remove('active', 'completed');
            if (id === step) {
                stepElement.classList.add('active');
            }
            if (index < steps.indexOf(step)) {
                stepElement.classList.add('completed');
            }
        });
    }
</script>

</body>
</html>
