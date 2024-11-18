<?php
include_once("../../controller/cDonHang.php");
include_once("../../controller/cChiTietDonHang.php");

$p = new controlDonHang();
$chiTietController = new controlCTDonHang();

// Lấy ID đơn hàng từ URL
$orderId = isset($_GET['order_id']) ? intval($_GET['order_id']) : 0;

if ($orderId > 0) {
    // Lấy thông tin đơn hàng để kiểm tra trạng thái
    $result = $p->getDHByID($orderId);

    if ($result && mysqli_num_rows($result) > 0) {
        $order = mysqli_fetch_assoc($result);
        $status = $order['TrangThai'];

        // Kiểm tra điều kiện trạng thái cho phép hủy
        if ($status === 'Đặt thành công và chuyển khoản' || $status === 'Đặt thành công và thu tiền mặt') {
            // Xóa chi tiết đơn hàng trước
            $deleteDetails = $chiTietController->deleteCTDHByOrderID($orderId);

            if ($deleteDetails) {
                // Xóa đơn hàng
                $deleteOrder = $p->deleteDH($orderId);

                if ($deleteOrder) {
                    echo "<script>
                        alert('Đơn hàng đã được hủy thành công!');
                        window.location.href = 'index.php?action=donhang';
                    </script>";
                } else {
                    echo "<script>
                        alert('Xảy ra lỗi khi xóa đơn hàng.');
                        window.location.href = 'index.php?action=donhang';
                    </script>";
                }
            } else {
                echo "<script>
                    alert('Xảy ra lỗi khi xóa chi tiết đơn hàng.');
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
