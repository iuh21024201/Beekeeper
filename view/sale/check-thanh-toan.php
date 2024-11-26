<?php
include_once("../../controller/cDonHang.php");
include_once("../../controller/cCuaHang.php");

// Đảm bảo session đã được khởi tạo
session_start();

// Kiểm tra nếu người dùng chưa đăng nhập
if (!isset($_SESSION['ID_TaiKhoan'])) {
    echo "Bạn cần đăng nhập để xem thông tin!";
    exit;
}

// Lấy ID tài khoản từ session
$accountId = $_SESSION['ID_TaiKhoan'];

// Khởi tạo đối tượng để xử lý đơn hàng và cửa hàng
$p = new controlDonHang();
$storeController = new cCuaHang();

// Xử lý hành động xác nhận thanh toán nếu form đã được gửi
if (isset($_POST['action']) && $_POST['action'] == 'confirm_payment' && isset($_POST['order_id'])) {
    $orderId = $_POST['order_id'];

    // Cập nhật trạng thái đơn hàng từ "Đặt thành công" sang "Thanh toán thành công"
    $result = $p->updateOrderStatusToPaid($orderId);

    if ($result) {
        echo "<script>alert('Đơn hàng đã được xác nhận thanh toán thành công!');</script>";
    } else {
        echo "<script>alert('Có lỗi xảy ra khi cập nhật trạng thái.');</script>";
    }
}

// Lấy danh sách đơn hàng của nhân viên
$kq = $p->getOrdersByEmployeeAccount($accountId);
?>
<h2>Đơn hàng thành công</h2>
<?php
if ($kq && mysqli_num_rows($kq) > 0) {
    // Hiển thị bảng đơn hàng
    echo "<table border='1' cellpadding='10' cellspacing='0' style='border-collapse: collapse; width: 80%; margin:auto;'>";
    echo "<thead>
            <tr>
                <th>Đơn hàng ID</th>
                <th>Cửa hàng</th>
                <th>Ngày đặt</th>
                <th>Địa chỉ giao hàng</th>
                <th>Trạng thái</th>
                <th>Ảnh thanh toán</th>
                <th>Tổng tiền</th>
                <th>Hành động</th>
            </tr>
          </thead>";
    echo "<tbody>";

    // Duyệt qua từng đơn hàng
    while ($order = mysqli_fetch_assoc($kq)) {
        $orderId = $order['ID_DonHang'];
        $storeId = $order['ID_CuaHang'];
        $orderDate = $order['NgayDat'];
        $status = $order['TrangThai'];
        $address = $order['DiaChiGiaoHang'];
        $paymentImage = $order['AnhThanhToan'];
        $totalPrice = number_format($order['TongTien'], 0, ',', '.'); // Định dạng tổng tiền

        // Lấy tên cửa hàng từ ID cửa hàng
        $storeNameResult = $storeController->getStoreByID($storeId);
        $storeName = '';
        if ($storeNameResult && mysqli_num_rows($storeNameResult) > 0) {
            $storeData = mysqli_fetch_assoc($storeNameResult);
            $storeName = $storeData['TenCuaHang'];
        }

        // Hiển thị mỗi đơn hàng dưới dạng một hàng trong bảng
        echo "<tr>";
        echo "<td>$orderId</td>";
        echo "<td>$storeName</td>";
        echo "<td>$orderDate</td>";
        echo "<td>$address</td>";
        echo "<td>$status</td>";

        // Hiển thị ảnh thanh toán
        if ($paymentImage) {
            echo "<td><img src='../../uploads/payment_images/$paymentImage' width='100' height='100'></td>";
        } else {
            echo "<td>Chưa có ảnh</td>";
        }

        // Hiển thị tổng tiền
        echo "<td>$totalPrice VNĐ</td>";

        echo "<td>
        <form action='check-thanh-toan.php' method='POST'>
            <input type='hidden' name='order_id' value='$orderId'>
            <input type='hidden' name='action' value='confirm_payment'>
            <button type='submit'>Xác nhận thanh toán</button>
        </form>
        </td>";
        echo "</tr>";
    }

    echo "</tbody>";
    echo "</table>";
} else {
    echo "<p>Không có đơn hàng nào.</p>";
}
?>
