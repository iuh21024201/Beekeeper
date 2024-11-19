<?php
include_once("../../controller/cDonHang.php");
include_once("../../controller/cChiTietDonHang.php");

$p = new controlDonHang();
$chiTietController = new controlCTDonHang();

// Lấy ID đơn hàng từ URL
$orderId = isset($_GET['order_id']) ? $_GET['order_id'] : 0;

if ($orderId > 0) {
    $result = $p->getDHByID($orderId);
    
    // Nếu đơn hàng tồn tại và trả về dữ liệu
    if ($result && mysqli_num_rows($result) > 0) {
        $order = mysqli_fetch_assoc($result); 
        echo "<div style='margin-left:140px;'>";
        echo "<h2>Chi tiết đơn hàng #$orderId</h2>";
        echo "<p><strong>Cửa hàng:</strong> " . $order['TenCuaHang'] . "</p>";
        echo "<p><strong>Ngày đặt:</strong> " . $order['NgayDat'] . "</p>";
        echo "<p><strong>Địa chỉ giao hàng:</strong> " . $order['DiaChiGiaoHang'] . "</p>";
        echo "<p><strong>Trạng thái:</strong> " . $order['TrangThai'] . "</p>";
        $paymentMethod = $order['PhuongThucThanhToan'] == 1 ? "Chuyển khoản" : "Tiền mặt";
        echo "<p><strong>Phương thức thanh toán:</strong> " . $paymentMethod . "</p>";
        echo "</div>";
        // Lấy chi tiết đơn hàng
        $orderDetails = $chiTietController->getCTDHByOrderID($orderId);
        
        // Nếu có chi tiết đơn hàng
        if ($orderDetails && mysqli_num_rows($orderDetails) > 0) {
            echo "<table border='1' cellpadding='10' cellspacing='0' style='border-collapse: collapse; width: 80%; margin:auto'>";
            echo "<thead>
                    <tr>
                        <th>Món ăn</th>
                        <th>Số lượng</th>
                        <th>Ghi chú</th>
                        <th>Giá</th>
                        <th>Tổng</th>
                    </tr>
                  </thead>";
            echo "<tbody>";
            
            while ($detail = mysqli_fetch_assoc($orderDetails)) {
                $foodName = $detail['TenMonAn'];
                $quantity = $detail['SoLuong'];
                $note = !empty($detail['GhiChu']) ? $detail['GhiChu'] : 'Không có ghi chú';
                
                $price = $detail['Gia'];
                $total = $quantity * $price;
            
                echo "<tr>";
                echo "<td>$foodName</td>";
                echo "<td>$quantity</td>";
                echo "<td>$note</td>"; // Hiển thị ghi chú
                echo "<td>" . number_format($price, 0, ',', '.') . " VNĐ</td>";
                echo "<td>" . number_format($total, 0, ',', '.') . " VNĐ</td>";
                echo "</tr>";
            }

            echo "</tbody>";
            echo "</table>";
        } else {
            echo "<p>Không có chi tiết đơn hàng.</p>";
        }
        echo "<div style='text-align:center; margin-top:20px;'>";
        echo "<a href='index.php?action=donhang' style='text-decoration:none; padding:10px 20px; background-color: #4CAF50; color: white; border-radius: 5px;'>Quay lại</a>";
        echo "&nbsp;";
        
        // Nút hủy đơn hàng
        echo "<a href='huydonhang.php?order_id=$orderId' onclick='return confirm(\"Bạn có chắc chắn muốn hủy đơn hàng này không?\")' style='text-decoration:none; padding:10px 20px; background-color: #f44336; color: white; border-radius: 5px;'>Hủy đơn hàng</a>";
        echo "</div>";
    } else {
        echo "<p>Không tìm thấy đơn hàng này.</p>";
    }
} else {
    echo "<p>Không có thông tin đơn hàng.</p>";
}
?>
