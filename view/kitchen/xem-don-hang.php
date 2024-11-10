<?php
// xem-don-hang.php

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

// Fetch only orders with status "chưa hoàn thành"
$sql = "SELECT ID_DonHang, ID_CuaHang, ID_KhachHang, NgayDat, DiaChiGiaoHang, TrangThai, PhuongThucThanhToan 
        FROM DonHang 
        WHERE TrangThai = 'chưa hoàn thành'";
$result = $conn->query($sql);
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

<div class="container mt-4">
    <h2>Danh sách đơn hàng cần chuẩn bị</h2>
    <table class="table table-bordered table-hover">
        <thead class="thead-dark">
            <tr>
                <th>ID Đơn Hàng</th>
                <th>ID Cửa hàng</th>
                <th>ID Khách hàng</th>
                <th>Ngày đặt</th>
                <th>Trạng thái</th>
                <th>Chi Tiết</th> <!-- New column for the "View Details" button -->
            </tr>
        </thead>
        <tbody>
            <?php
            // Check if there are results and loop through each row to display data
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row["ID_DonHang"] . "</td>";
                    echo "<td>" . $row["ID_CuaHang"] . "</td>";
                    echo "<td>" . $row["ID_KhachHang"] . "</td>";
                    echo "<td>" . $row["NgayDat"] . "</td>";
                    echo "<td>" . $row["TrangThai"] . "</td>";
                    echo "<td><a href='chi-tiet-don-hang.php?id=" . $row["ID_DonHang"] . "' class='btn btn-primary'>Xem Chi Tiết</a></td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='6'>Không có đơn hàng chưa hoàn thành.</td></tr>";
            }
            ?>
        </tbody>
    </table>
</div>

</body>
</html>

<?php
// Close the database connection
$conn->close();
?>
