<?php
// thong-ke-don-hang.php

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

// Fetch order data for the table
$sql = "SELECT ID_DonHang, ID_CuaHang, ID_KhachHang, NgayDat, DiaChiGiaoHang, TrangThai, PhuongThucThanhToan FROM DonHang";
$result = $conn->query($sql);

// Fetch monthly order counts for the last 6 months
$sql_monthly = "SELECT DATE_FORMAT(NgayDat, '%Y-%m') AS month, COUNT(ID_DonHang) AS order_count
                FROM DonHang
                WHERE NgayDat >= DATE_SUB(CURDATE(), INTERVAL 6 MONTH)
                GROUP BY month
                ORDER BY month ASC";
$monthlyResult = $conn->query($sql_monthly);

// Prepare data for the chart
$months = [];
$orderCounts = [];
if ($monthlyResult->num_rows > 0) {
    while($row = $monthlyResult->fetch_assoc()) {
        $months[] = $row['month'];
        $orderCounts[] = $row['order_count'];
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Thống kê đơn hàng</title>
    <link rel="stylesheet" href="../../asset/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
<div class="container">
    <h2 class="mt-4">Thống kê đơn hàng</h2>
    
    <!-- Order Statistics Table -->
    <table class="table table-bordered mt-4">
        <thead class="thead-light">
            <tr>
                <th scope="col">ID Đơn Hàng</th>
                <th scope="col">ID Cửa Hàng</th>
                <th scope="col">ID Khách Hàng</th>
                <th scope="col">Ngày Đặt</th>
                <th scope="col">Địa Chỉ Giao Hàng</th>
                <th scope="col">Trạng Thái</th>
                <th scope="col">Phương Thức Thanh Toán</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($row["ID_DonHang"]) . "</td>";
                    echo "<td>" . htmlspecialchars($row["ID_CuaHang"]) . "</td>";
                    echo "<td>" . htmlspecialchars($row["ID_KhachHang"]) . "</td>";
                    echo "<td>" . htmlspecialchars($row["NgayDat"]) . "</td>";
                    echo "<td>" . htmlspecialchars($row["DiaChiGiaoHang"]) . "</td>";
                    echo "<td>" . htmlspecialchars($row["TrangThai"]) . "</td>";
                    echo "<td>" . htmlspecialchars($row["PhuongThucThanhToan"]) . "</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='7' class='text-center'>Không có đơn hàng nào</td></tr>";
            }
            ?>
        </tbody>
    </table>

    <!-- Monthly Orders Bar Chart -->
    <div class="mt-5">
        <h3>Biểu đồ thống kê số lượng đơn hàng các tháng gần nhất</h3>
        <canvas id="orderChart"></canvas>
    </div>
</div>

<script src="../../asset/js/jquery-3.4.1.min.js"></script>
<script src="../../asset/js/bootstrap.min.js"></script>
<script>
    // Data for the chart
    const months = <?php echo json_encode($months); ?>;
    const orderCounts = <?php echo json_encode($orderCounts); ?>;

    // Render the bar chart
    const ctx = document.getElementById('orderChart').getContext('2d');
    const orderChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: months,
            datasets: [{
                label: 'Số lượng đơn hàng',
                data: orderCounts,
                backgroundColor: 'rgba(75, 192, 192, 0.6)',
                borderColor: 'rgba(75, 192, 192, 1)',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true,
                    title: {
                        display: true,
                        text: 'Số lượng đơn hàng'
                    }
                },
                x: {
                    title: {
                        display: true,
                        text: 'Tháng'
                    }
                }
            },
            plugins: {
                legend: {
                    position: 'top'
                }
            }
        }
    });
</script>
</body>
</html>

<?php
// Close the database connection
$conn->close();
?>
