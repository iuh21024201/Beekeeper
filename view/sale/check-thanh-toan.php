<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản trị nhân viên bán hàng</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="../../asset/css/bootstrap.min.css">
    <script src="../../asset/js/jquery-3.4.1.min.js"></script>
    <script src="../../asset/js/bootstrap.min.js"></script>
    <style>
       body {
    font-family: Arial, sans-serif;
    margin: 0;
    box-sizing: border-box;
}

header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    background-color: #f8f9fa;
    padding: 15px 30px;
    border-bottom: 1px solid #ddd;
}

.logo {
    font-family: 'Knewave', cursive;
    font-size: 28px;
    font-weight: bold;
    color: #ff4d4d;
    text-transform: uppercase;
    font-style: italic;
}

nav ul {
    list-style: none;
    padding: 0;
    margin: 0;
    display: flex;
    gap: 20px;
}

nav ul li {
    margin: 0;
}

nav ul li a {
    text-decoration: none;
    color: #333;
    font-weight: bold;
    font-size: 16px;
    transition: color 0.3s ease;
}

nav ul li a:hover {
    color: #ff4d4d;
}

.icons {
    display: flex;
    align-items: center;
    gap: 20px;
}

.icons a {
    text-decoration: none;
    color: #333;
    font-size: 20px;
    transition: color 0.3s ease;
}

.icons a:hover {
    color: #ff4d4d;
}

.dropdown {
    position: relative;
    display: inline-block;
}

.dropdown-content {
    display: none;
    position: absolute;
    right: 0;
    top: 100%;
    background-color: #ffffff;
    min-width: 160px;
    box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.2);
    z-index: 1000;
    border: 1px solid #ddd;
    border-radius: 4px;
}

.dropdown-content a {
    color: #333;
    padding: 10px 15px;
    text-decoration: none;
    display: block;
    font-size: 14px;
    transition: background-color 0.3s ease, color 0.3s ease;
}

.dropdown-content a:hover {
    background-color: #f1f1f1;
    color: #ff4d4d;
}

.dropdown:hover .dropdown-content {
    display: block;
}

#userIcon:hover {
    color: #ff4d4d;
}
</style>
</head>
<body>
<div id="container">
    <header>
        <div class="logo">
            BEEKEEPER
        </div>
        <nav>
            <ul>
                <li><a href="index.php">Trang bán hàng</a></li>
                <li><a href="trang-quan-tri.php">Trang quản trị</a></li>
                <li><a href="check-thanh-toan.php">Trang kiểm tra thanh toán</a></li>
            </ul>
        </nav>
        <div class="icons">
            <div class="dropdown">
                <a href="#" id="userIcon"><i class="fas fa-user"></i></a>
                <div class="dropdown-content">
                    <a href="../account/hosoSale.php">Xem hồ sơ</a>
                    <a href="?action=logout">Đăng xuất</a>
                </div>
            </div> 
        </div>
    </header>


    </div>
  
</header>
<h2 style="color:red; margin-left:40%; font-size:28px; margin-top:30px">Đơn hàng thành công</h2>

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

if ($kq === false) {
    echo "<p>Lỗi xảy ra khi lấy danh sách đơn hàng.</p>";
} elseif ($kq && $kq->num_rows > 0) {
    // Hiển thị bảng đơn hàng
    echo "<table border='1' cellpadding='10' cellspacing='0' style='border-collapse: collapse; width: 80%; margin:auto;'>";
    echo "<thead>
            <tr>
                <th>Đơn hàng ID</th>
                <th>Cửa hàng</th>
                <th>Ngày đặt</th>
                <th>Địa chỉ giao hàng</th>
                <th>Trạng thái</th>
                <th>Phương thức thanh toán</th>
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
        $payment = $order['PhuongThucThanhToan'];
        $address = $order['DiaChiGiaoHang'];
        $paymentImage = $order['AnhThanhToan'];
        $totalPrice = number_format($order['TongTien'], 0, ',', '.'); // Định dạng tổng tiền
        $paymentMethod = ($payment == 0) ? "Tiền mặt" : "Chuyển khoản";
        // Lấy tên cửa hàng từ ID cửa hàng
        $storeNameResult = $storeController->getStoreByID($storeId);
        $storeName = '';
        if ($storeNameResult === false) {
            $storeName = "Lỗi khi lấy thông tin cửa hàng"; // Xử lý lỗi truy vấn
        } elseif ($storeNameResult && $storeNameResult->num_rows > 0) {
            $storeData = mysqli_fetch_assoc($storeNameResult);
            $storeName = $storeData['TenCuaHang'];
        } else {
            $storeName = "Không xác định"; // Không tìm thấy cửa hàng
        }
        // Hiển thị mỗi đơn hàng dưới dạng một hàng trong bảng
        echo "<tr>";
        echo "<td>$orderId</td>";
        echo "<td>$storeName</td>";
        echo "<td>$orderDate</td>";
        echo "<td>$address</td>";
        echo "<td>$status</td>";
        echo "<td>$paymentMethod</td>";

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
