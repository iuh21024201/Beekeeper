<?php
// xem-don-hang.php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Check if the user is logged in
if (!isset($_SESSION['ID_TaiKhoan'])) {
    // Redirect to login page or show an error
    header("Location: login.php");
    exit();
}

// Database connection (replace with your actual database credentials)
$servername = "localhost";
$username = "root";
$password = "";
$database = "db_beekeeper"; // Replace with your actual database name

// Connect to the database
$conn = new mysqli($servername, $username, $password, $database);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get the ID_TaiKhoan from the session
$ID_TaiKhoan = $_SESSION['ID_TaiKhoan'];

// Prepare SQL to get the ID_CuaHang for the logged-in user
$sql_get_store = "SELECT ID_CuaHang FROM nhanvien WHERE ID_TaiKhoan = ?";
$stmt = $conn->prepare($sql_get_store);
$stmt->bind_param("i", $ID_TaiKhoan);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $ID_CuaHang = $row['ID_CuaHang'];
} else {
    die("Không tìm thấy thông tin cửa hàng cho tài khoản này.");
}

// Fetch orders with status "Đã thanh toán" for the specific store
$sql = "SELECT ID_DonHang, ID_KhachHang, NgayDat, DiaChiGiaoHang, TrangThai, PhuongThucThanhToan 
        FROM DonHang 
        WHERE TrangThai = 'Đã thanh toán' AND ID_CuaHang = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $ID_CuaHang);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Danh sách đơn hàng cần chuẩn bị</title>
    <link rel="stylesheet" href="../../asset/css/bootstrap.min.css">
</head>
<body>

<div class="content container mt-4">
    <h2>Danh sách đơn hàng cần chuẩn bị</h2>
    <table class="table table-bordered table-hover">
        <thead class="thead-dark">
            <tr>
                <th>ID Đơn Hàng</th>
                <th>ID Khách hàng</th>
                <th>Ngày đặt</th>
                <th>Địa chỉ giao hàng</th>
                <th>Trạng thái</th>
                <th>Phương thức thanh toán</th>
                <th>Chi Tiết</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // Check if there are results and loop through each row to display data
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($row["ID_DonHang"]) . "</td>";
                    echo "<td>" . htmlspecialchars($row["ID_KhachHang"]) . "</td>";
                    echo "<td>" . htmlspecialchars($row["NgayDat"]) . "</td>";
                    echo "<td>" . htmlspecialchars($row["DiaChiGiaoHang"]) . "</td>";
                    echo "<td>" . htmlspecialchars($row["TrangThai"]) . "</td>";
                    echo "<td>" . htmlspecialchars($row["PhuongThucThanhToan"]) . "</td>";
                    echo "<td><a href='chi-tiet-don-hang.php?id=" . htmlspecialchars($row["ID_DonHang"]) . "&idCuaHang=" . htmlspecialchars($ID_CuaHang) . "' class='btn btn-primary'>Xem Chi Tiết</a></td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='7'>Không có đơn hàng cần chuẩn bị.</td></tr>";
            }
            ?>
        </tbody>
    </table>
</div>

<script src="../../asset/js/jquery-3.4.1.min.js"></script>
<script src="../../asset/js/bootstrap.min.js"></script>
</body>
</html>

<?php
// Close the database connection
$stmt->close();
$conn->close();
?>
