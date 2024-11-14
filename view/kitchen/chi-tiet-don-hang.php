<?php
// chi-tiet-don-hang.php

// Database connection (replace with your actual database credentials)
$servername = "localhost";
$username = "root";
$password = "";
$database = "beekeeper"; // Replace with your actual database name

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
    <table class="table table-bordered table-hover">
        <thead class="thead-dark">
            <tr>
                <th>Tên Món Ăn</th>
                <th>Hình Ảnh</th>
                <th>Số Lượng</th>
                <th>Ghi Chú</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // Check if there are results and loop through each row to display data
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row["TenMonAn"] . "</td>";
                    echo "<td><img src='" . $row["HinhAnh"] . "' alt='" . $row["TenMonAn"] . "' width='100'></td>";
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
</div>

</body>
</html>

<?php
// Close the database connection
$stmt->close();
$conn->close();
?>
