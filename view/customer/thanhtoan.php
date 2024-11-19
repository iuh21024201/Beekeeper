<?php
include_once("../../controller/cDonHang.php");
include_once("../../controller/cChiTietDonHang.php");

// Lấy ID_DonHang từ URL
$idDonHang = isset($_GET['idDonHang']) ? intval($_GET['idDonHang']) : 0;

if ($idDonHang <= 0) {
    echo "<script>alert('Không tìm thấy thông tin đơn hàng.'); window.location.href = 'index.php?action=giohang';</script>";
    exit;
}

// Tạo đối tượng truy vấn
$chiTietDonHang = new controlCTDonHang();

// Tính tổng tiền
$tongTien = $chiTietDonHang->getTotalAmountByOrderId($idDonHang);

if ($tongTien === false) {
    echo "<script>alert('Không tìm thấy chi tiết đơn hàng.'); window.location.href = 'index.php?action=giohang';</script>";
    exit;
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thanh Toán</title>
    <style>
        .container{
            display: flex;
        }
        .right{
            margin-top: 70px;
        }
        .qr-container {
            text-align: center;
            margin: 20px 0;
        }

        .qr-container img {
            max-width: 250px;
            margin-bottom: 15px;
        }

        .money {
            color: #ff4d4d;
            font-size: 26px;
            font-weight: bold;
        }
        .btn-back {
            display: block;
            margin-top:100px;
            margin-left: 150px;
            padding: 10px 20px;
            font-size: 16px;
            color: #fff;
            background-color: #007bff;
            border: none;
            border-radius: 5px;
            text-align: center;
            cursor: pointer;
            text-decoration: none;
            width: 250px;
        }
        .upload-container {
            text-align: center;
            margin: 20px 0;
        }

        .upload-container input[type="file"] {
            margin-bottom: 10px;
        }

        .upload-container button {
            padding: 10px 20px;
            font-size: 16px;
            background-color: #28a745;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .upload-container button:hover {
            background-color: #218838;
        }
    </style>
</head>
<body>
    <h2>Thông Tin Thanh Toán</h2>
    <div class="container">
        
        <div class="qr-container">
            <!-- Hiển thị ảnh QR từ thư mục image -->
            <img src="../customer/image/qr.png" alt="Mã QR chuyển khoản">
            <p class="money">Tổng tiền cần thanh toán: <?= number_format($tongTien, 0, ',', '.') ?> VND</p>
        </div>
        <div class="right">
            <p style='margin-left:30px; font-size:20px;'><strong>Nội dung chuyển khoản:</strong>Họ tên + Thanh toán đơn hàng #<?= $idDonHang ?></p>
            
            <!-- Form tải ảnh lên -->
            <div class="upload-container">
                    <form action="upload_payment_image.php" method="POST" enctype="multipart/form-data">
                        <input type="hidden" name="idDonHang" value="<?= $idDonHang ?>">
                        <label for="payment-image">Tải lên ảnh xác nhận thanh toán:</label><br>
                        <input type="file" name="payment_image" id="payment-image" accept="image/*" required><br>
                        <button type="submit">Tải Lên</button>
                    </form>
                </div>

                <a href="index.php?action=giohang" class="btn-back">Quay lại Giỏ hàng</a>
            </div>
        </div>
        
    </div>
    
</body>
</html>
