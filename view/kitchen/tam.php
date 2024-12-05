<?php
// chi-tiet-don-hang.php

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

// Get the order ID from the URL
if (isset($_GET['id'])) {
    $idDonHang = $_GET['id'];
} else {
    die("ID đơn hàng không hợp lệ.");
}

// Update the order status if the button is clicked
if (isset($_POST['update_status'])) {
    $sql_update = "UPDATE DonHang SET TrangThai = 'Đang chế biến' WHERE ID_DonHang = ?";
    $stmt_update = $conn->prepare($sql_update);
    $stmt_update->bind_param("i", $idDonHang);
    if ($stmt_update->execute()) {
        $statusUpdated = true; // Flag to show label
    }
    $stmt_update->close();
}

// Fetch the order details
$sql = "SELECT c.ID_DonHang, m.TenMonAn, m.HinhAnh, c.SoLuong, c.Ghichu, 
               GROUP_CONCAT(DISTINCT CONCAT(n.TenNguyenLieu, ' (', 
               t.SoLuongNguyenLieu * c.SoLuong, 'x ',  n.DonViTinh, ')') SEPARATOR ', ') AS CongThuc
        FROM ChiTietDonHang c
        JOIN MonAn m ON c.ID_MonAn = m.ID_MonAn
        JOIN chitietmonan t ON m.ID_MonAn = t.ID_MonAn
        JOIN nguyenlieu n ON t.ID_NguyenLieu = n.ID_NguyenLieu
        WHERE c.ID_DonHang = ?
        GROUP BY c.ID_DonHang, c.ID_MonAn";



$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $idDonHang);  // Bind the order ID
$stmt->execute();
$result = $stmt->get_result();
?>
