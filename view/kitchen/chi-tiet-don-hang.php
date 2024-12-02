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
$sql = "SELECT c.ID_DonHang, m.TenMonAn, m.HinhAnh, c.SoLuong, c.Ghichu 
        FROM ChiTietDonHang c
        JOIN MonAn m ON c.ID_MonAn = m.ID_MonAn
        WHERE c.ID_DonHang = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $idDonHang);  // Bind the order ID
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chi Tiết Đơn Hàng</title>
    <link rel="stylesheet" href="../../asset/css/bootstrap.min.css">
</head>
<body>

<div class="container mt-4">
    <h2>Chi Tiết Đơn Hàng</h2>
    
    <?php if (isset($statusUpdated) && $statusUpdated): ?>
        <div class="alert alert-success">Trạng thái đã được cập nhật thành "Đang chế biến".</div>
    <?php endif; ?>

    <table class="table table-bordered table-hover">
        <thead class="thead-dark">
            <tr>
                <th>Tên Món Ăn</th>
                <th>Hình Ảnh</th>
                <th>Số Lượng</th>
                <th>Ghi Chú</th>
                <th>Công thức</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // Check if there are results and loop through each row to display data
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row["TenMonAn"] . "</td>";
                    echo "<td><img src='../../image/monan/" . $row["HinhAnh"] . "' width='100px' /></td>";
                    echo "<td>" . $row["SoLuong"] . "</td>";
                    echo "<td>" . $row["Ghichu"] . "</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='4'>Không có chi tiết đơn hàng.</td></tr>";
            }
            ?>
        </tbody>
    </table>

    <div class="mt-4">
        <!-- Button to go back -->
        <a href="index.php?action=xem-don-hang" class="btn btn-secondary">Quay lại</a>

        <!-- Form to update order status -->
        <form method="POST" style="display:inline;">
            <button type="submit" name="update_status" class="btn btn-primary">Đang chế biến</button>
        </form>
    </div>
</div>

</body>
</html>

<?php
// Close the database connection
$stmt->close();
$conn->close();
?>
