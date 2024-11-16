<h2>Đơn hàng của tôi</h2>
<?php
include_once("../../controller/cDonHang.php");
include_once("../../controller/cNguoiDung.php");
include_once("../../controller/cCuaHang.php");  // Bao gồm file chứa hàm getStoreByID

$p = new controlDonHang();
$controlNguoiDung = new controlNguoiDung();
$storeController = new cCuaHang(); // Tạo đối tượng của lớp cCuaHang
$idTaiKhoan = $_SESSION['ID_TaiKhoan'];
$idKH = $controlNguoiDung->getCustomerIdByAccountId($idTaiKhoan);
$kq = $p->getDHByIDKH($idKH);

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
                <th>Chi tiết</th>
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

        // Lấy tên cửa hàng từ ID cửa hàng bằng hàm getStoreByID
        $storeNameResult = $storeController->getStoreByID($storeId);
        $storeName = ''; // Mặc định tên cửa hàng là rỗng
        if ($storeNameResult && mysqli_num_rows($storeNameResult) > 0) {
            $storeData = mysqli_fetch_assoc($storeNameResult);
            $storeName = $storeData['TenCuaHang'];  // Lấy tên cửa hàng
        }

        // Hiển thị mỗi đơn hàng dưới dạng một hàng trong bảng
        echo "<tr>";
        echo "<td>$orderId</td>";
        echo "<td>$storeName</td>";  // Hiển thị tên cửa hàng
        echo "<td>$orderDate</td>";
        echo "<td>$address</td>";
        echo "<td>$status</td>";
        echo "<td><a href='index.php?action=chitietdonhang&order_id=$orderId'>Xem chi tiết</a></td>";
        echo "</tr>";
    }

    echo "</tbody>";
    echo "</table>";
} else {
    echo "<p>Không có đơn hàng nào.</p>";
}
?>
