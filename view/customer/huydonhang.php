<?php
include_once("../../controller/cDonHang.php");
include_once("../../controller/cChiTietDonHang.php");
include_once("../../controller/c_thuc_don.php");

$p = new controlDonHang();
$chiTietController = new controlCTDonHang();
$thucDonController = new cThucDon();

// Lấy ID đơn hàng từ URL
$orderId = isset($_GET['order_id']) ? intval($_GET['order_id']) : 0;

if ($orderId > 0) {
    // Lấy thông tin đơn hàng để kiểm tra trạng thái
    $result = $p->getDHByID($orderId);

    if ($result && mysqli_num_rows($result) > 0) {
        $order = mysqli_fetch_assoc($result);
        $status = $order['TrangThai'];

        // Kiểm tra điều kiện trạng thái cho phép hủy
        if ($status === 'Đặt thành công') {
            // Lấy danh sách chi tiết đơn hàng
            $details = $chiTietController->getCTDHByOrderID($orderId);
        
            if ($details && mysqli_num_rows($details) > 0) {
                include_once("../../controller/c_thuc_don.php");
                $thucDonController = new cThucDon();
        
                while ($row = mysqli_fetch_assoc($details)) {
                    $idMonAn = $row['ID_MonAn'];
                    $soLuong = $row['SoLuong'];
                    $idCH = $order['ID_CuaHang']; // Lấy ID cửa hàng từ thông tin đơn hàng
        
                    // Tăng số lượng tồn trong bảng thucdon
                    $thucDonController->increaseSoLuongTon($idMonAn, $idCH, $soLuong);
                }
            }
        
            // Cập nhật trạng thái đơn hàng thành "Đã hủy"
            $updateStatus = $p->updateOrderStatusToCanceled($orderId);
        
            if ($updateStatus) {
                echo "<script>
                    alert('Đơn hàng đã được hủy thành công và số lượng tồn đã được cập nhật!');
                    window.location.href = 'index.php?action=donhang';
                </script>";
            } else {
                echo "<script>
                    alert('Xảy ra lỗi khi cập nhật trạng thái đơn hàng.');
                    window.location.href = 'index.php?action=donhang';
                </script>";
            }
        } else {
            echo "<script>
                alert('Không thể hủy đơn hàng do trạng thái không phù hợp.');
                window.location.href = 'index.php?action=donhang';
            </script>";
        }        
    } else {
        echo "<script>
            alert('Không tìm thấy đơn hàng.');
            window.location.href = 'index.php?action=donhang';
        </script>";
    }
} else {
    echo "<script>
        alert('Không có thông tin đơn hàng.');
        window.location.href = 'index.php?action=donhang';
    </script>";
}
?>
