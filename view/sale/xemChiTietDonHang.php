<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chi Tiết Đơn Hàng</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .container {
            margin-top: 50px;
        }
        .order-detail-table {
            margin-top: 30px;
        }
        .back-btn {
            padding: 10px 20px;
            border-radius: 5px;
            text-decoration: none;
            background-color: #4CAF50;
            color: white;
        }
        .back-btn:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
    <div class="container">
        <?php
        include_once("../../Controller/cDonHang.php");
        include_once("../../Controller/cChiTietDonHang.php");

        $pDonHang = new controlDonHang();
        $pChiTietDonHang = new controlCTDonHang();

        // Kiểm tra và lấy ID đơn hàng từ URL
        $orderId = isset($_GET['order_id']) ? intval($_GET['order_id']) : 0;  // Mặc định là 0

        // Kiểm tra nếu ID đơn hàng hợp lệ
        if ($orderId > 0) {
            // Lấy thông tin đơn hàng
            $resultDonHang = $pDonHang->getDHByID($orderId);

            if ($resultDonHang && mysqli_num_rows($resultDonHang) > 0) {
                $donHang = mysqli_fetch_assoc($resultDonHang);
                echo "<h2 class='text-center'>Chi Tiết Đơn Hàng #$orderId</h2>";
                echo "<div class='mt-4'>";
                echo "<p><strong>Cửa hàng:</strong> " . htmlspecialchars($donHang['TenCuaHang']) . "</p>";
                echo "<p><strong>Ngày đặt:</strong> " . date('d/m/Y', strtotime($donHang['NgayDat'])) . "</p>";
                echo "<p><strong>Địa chỉ giao hàng:</strong> " . htmlspecialchars($donHang['DiaChiGiaoHang']) . "</p>";
                echo "<p><strong>Trạng thái:</strong> " . htmlspecialchars($donHang['TrangThai']) . "</p>";
                echo "<p><strong>Phương thức thanh toán:</strong> " . ($donHang['PhuongThucThanhToan'] == 1 ? "Chuyển khoản" : "Tiền mặt") . "</p>";
                if (!empty($donHang['AnhThanhToan'])) {
                    $imagePath = "../../uploads/payment_images/" . htmlspecialchars($donHang['AnhThanhToan']);
                    echo "<p><strong>Ảnh thanh toán:</strong></p>";
                    echo "<img src='$imagePath' alt='Ảnh thanh toán' class='img-thumbnail' style='max-width:400px;'>";
                } else {
                    echo "<p><strong>Ảnh thanh toán:</strong> Không có ảnh</p>";
                }
                echo "</div>";

                // Lấy chi tiết đơn hàng
                $resultChiTiet = $pChiTietDonHang->getCTDHByOrderID($orderId);
                if ($resultChiTiet && mysqli_num_rows($resultChiTiet) > 0) {
                    echo "<table class='table table-striped table-hover table-bordered order-detail-table'>";
                    echo "<thead class='table-dark'>
                            <tr>
                                <th scope='col'>Món ăn</th>
                                <th scope='col'>Số lượng</th>
                                <th scope='col'>Ghi chú</th>
                                <th scope='col'>Giá (VNĐ)</th>
                                <th scope='col'>Tổng (VNĐ)</th>
                            </tr>
                          </thead>";
                    echo "<tbody>";

                    while ($rowChiTiet = mysqli_fetch_assoc($resultChiTiet)) {
                        $tenMonAn = htmlspecialchars($rowChiTiet['TenMonAn']);
                        $soLuong = intval($rowChiTiet['SoLuong']);
                        $ghiChu = !empty($rowChiTiet['GhiChu']) ? htmlspecialchars($rowChiTiet['GhiChu']) : 'Không có ghi chú';
                        $gia = number_format($rowChiTiet['Gia'], 0, ',', '.');
                        $tongTien = number_format($soLuong * $rowChiTiet['Gia'], 0, ',', '.');

                        echo "<tr>";
                        echo "<td>$tenMonAn</td>";
                        echo "<td>$soLuong</td>";
                        echo "<td>$ghiChu</td>";
                        echo "<td>$gia</td>";
                        echo "<td>$tongTien</td>";
                        echo "</tr>";
                    }

                    echo "</tbody>";
                    echo "</table>";
                } else {
                    echo "<p class='alert alert-warning'>Không có chi tiết đơn hàng.</p>";
                }

                // Nút quay lại
                echo "<div class='text-center mt-4'>";
                echo "<a href='trang-quan-tri.php?action=donhang' class='back-btn'>Quay lại</a>";
                echo "</div>";
            } else {
                echo "<p class='alert alert-danger'>Không tìm thấy đơn hàng này.</p>";
            }
        } else {
            echo "<p class='alert alert-danger'>ID đơn hàng không hợp lệ.</p>";
        }
        ?>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
