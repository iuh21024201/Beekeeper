<?php
// Kết nối đến database
$servername = "localhost";
$username = "root";
$password = "";
$database = "beekeeper"; // Replace with your actual database name

$conn = new mysqli(hostname: $servername, username: $username, password: $password, database: $database);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
// Truy vấn để lấy thông tin lương của nhân viên
$query = "
    SELECT 
        nv.ID_NhanVien, 
        nv.HoTen, 
        ch.TenCuaHang AS CuaHang, 
        l.TongGioLam, 
        l.LuongTheoGio, 
        l.Thuong, 
        l.TongLuong
    FROM 
        luong l
    JOIN 
        nhanvien nv ON l.ID_NhanVien = nv.ID_NhanVien
    JOIN 
        cuahang ch ON nv.ID_CuaHang = ch.ID_CuaHang
";

$result = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Xem Lương Nhân Viên</title>
    <link rel="stylesheet" href="style.css"> <!-- CSS liên kết nếu cần -->
    <style>
        body {
    font-family: Arial, sans-serif;
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
    margin: 0;
    background-color: #f4f4f9;
}

.container {
    text-align: center;
    padding: 2rem;
    background-color: #fff;
    border-radius: 8px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    width: 80%;
}

h1 {
    color: #333;
}

table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 20px;
}

table, th, td {
    border: 1px solid #ddd;
}

th, td {
    padding: 10px;
    text-align: left;
}

th {
    background-color: #f2f2f2;
}

tr:nth-child(even) {
    background-color: #f9f9f9;
}

    </style>
</head>
<body>
    <div class="container">
        <h1>Thông Tin Lương Nhân Viên</h1>
        <table>
            <thead>
                <tr>
                    <th>Mã Nhân Viên</th>
                    <th>Họ Tên</th>
                    <th>Cửa Hàng</th>
                    <th>Tổng Giờ Làm</th>
                    <th>Lương Theo Giờ</th>
                    <th>Thưởng</th>
                    <th>Tổng Lương</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Hiển thị dữ liệu lương nhân viên
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $row['ID_NhanVien'] . "</td>";
                        echo "<td>" . $row['HoTen'] . "</td>";
                        echo "<td>" . $row['CuaHang'] . "</td>";
                        echo "<td>" . $row['TongGioLam'] . "</td>";
                        echo "<td>" . number_format($row['LuongTheoGio'], 2) . " VND</td>";
                        echo "<td>" . number_format($row['Thuong'], 2) . " VND</td>";
                        echo "<td>" . number_format($row['TongLuong'], 2) . " VND</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='7'>Không có dữ liệu</td></tr>";
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
