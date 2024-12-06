<?php
// thong-ke-don-hang.php

// Khởi động session nếu chưa có
if (session_status() === PHP_SESSION_NONE) {
    session_start();
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

// Ensure user is logged in (optional: remove this if login is not required)
if (!isset($_SESSION['ID_TaiKhoan'])) {
    echo "Bạn cần đăng nhập để xem thống kê.";
    exit;
}

// Get the selected month and customer name from the form submission (if any)
$selectedMonth = isset($_GET['month']) ? $_GET['month'] : '';
$customerName = isset($_GET['customerName']) ? $_GET['customerName'] : '';

// Prepare the SQL query with placeholders
$sql = "SELECT donhang.ID_donhang, KhachHang.HoTen, donhang.NgayDat, donhang.DiaChiGiaoHang, donhang.PhuongThucThanhToan 
        FROM donhang 
        JOIN KhachHang ON donhang.ID_KhachHang = KhachHang.ID_KhachHang
        WHERE donhang.TrangThai = 'đã giao hàng'";

$params = [];
$types = "";

if (!empty($selectedMonth)) {
    $sql .= " AND DATE_FORMAT(NgayDat, '%Y-%m') = ?";
    $params[] = $selectedMonth;
    $types .= "s";
}

if (!empty($customerName)) {
    $sql .= " AND KhachHang.HoTen LIKE ?";
    $params[] = "%$customerName%";
    $types .= "s";
}

$stmt = $conn->prepare($sql);

// Bind parameters only if there are any
if (!empty($params)) {
    $stmt->bind_param($types, ...$params);
}

$stmt->execute();
$result = $stmt->get_result();

// Fetch monthly order counts for the last 6 months (for chart)
$sql_monthly = "SELECT DATE_FORMAT(NgayDat, '%Y-%m') AS month, COUNT(ID_DonHang) AS order_count
                FROM donhang
                WHERE NgayDat >= DATE_SUB(CURDATE(), INTERVAL 6 MONTH)
                  AND TrangThai = 'đã giao hàng'
                GROUP BY month
                ORDER BY month ASC";
$stmt_monthly = $conn->prepare($sql_monthly);
$stmt_monthly->execute();
$monthlyResult = $stmt_monthly->get_result();

// Prepare data for the chart
$months = [];
$orderCounts = [];
if ($monthlyResult->num_rows > 0) {
    while ($row = $monthlyResult->fetch_assoc()) {
        $months[] = $row['month'];
        $orderCounts[] = $row['order_count'];
    }
}

// Generate the last 12 months for dropdown options
$dropdownMonths = [];
for ($i = 0; $i < 12; $i++) {
    $month = date('Y-m', strtotime("-$i months"));
    $dropdownMonths[] = $month;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thống kê đơn hàng</title>
    <link rel="stylesheet" href="../../asset/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
    <div class="container">
        <h2 class="mt-4">Thống kê đơn hàng</h2>

        <!-- Filter Form -->
        <form method="get" class="form-inline mb-4">
            <input type="hidden" name="action" value="thong-ke-don-hang">
            <label for="month" class="mr-2">Chọn tháng:</label>
            <select name="month" id="month" class="form-control mr-2">
                <option value="">Tất cả</option>
                <?php
                foreach ($dropdownMonths as $month) {
                    $selected = ($month == $selectedMonth) ? 'selected' : '';
                    echo "<option value='$month' $selected>$month</option>";
                }
                ?>
            </select>

            <label for="customerName" class="mr-2">Tên khách hàng:</label>
            <input type="text" name="customerName" id="customerName" class="form-control mr-2" value="<?= htmlspecialchars($customerName) ?>">

            <button type="submit" class="btn btn-primary">Lọc</button>
        </form>
        
        <!-- Order Statistics Table -->
        <table class="table table-bordered mt-4">
            <thead class="thead-light">
                <tr>
                    <th scope="col">Họ Tên</th>
                    <th scope="col">Ngày Đặt</th>
                    <th scope="col">Địa Chỉ Giao Hàng</th>
                    <th scope="col">Phương Thức Thanh Toán</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . htmlspecialchars($row["HoTen"]) . "</td>";
                        echo "<td>" . htmlspecialchars($row["NgayDat"]) . "</td>";
                        echo "<td>" . htmlspecialchars($row["DiaChiGiaoHang"]) . "</td>";
                        
                        // Display payment method based on value
                        $paymentMethod = ($row["PhuongThucThanhToan"] == 0) ? "Thu tiền mặt" : "Chuyển khoản";
                        echo "<td>" . htmlspecialchars($paymentMethod) . "</td>";

                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='4' class='text-center'>Không có đơn hàng đã giao nào</td></tr>";
                }
                ?>
            </tbody>
        </table>

        <!-- Monthly Orders Bar Chart -->
        <div class="mt-5">
            <h3>Biểu đồ thống kê số lượng đơn hàng các tháng gần nhất</h3>
            <canvas id="orderChart" width="400" height="200"></canvas>
        </div>
    </div>

    <script src="../../asset/js/jquery-3.4.1.min.js"></script>
    <script src="../../asset/js/bootstrap.min.js"></script>
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        var ctx = document.getElementById('orderChart').getContext('2d');
        var orderChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: <?= json_encode($months) ?>,
                datasets: [{
                    label: 'Số lượng đơn hàng đã giao',
                    data: <?= json_encode($orderCounts) ?>,
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
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
                        display: true,
                        position: 'top'
                    },
                    title: {
                        display: true,
                        text: 'Thống kê đơn hàng theo tháng'
                    }
                }
            }
        });
    });
    </script>
</body>
</html>

<?php
// Close prepared statements and database connection
$stmt->close();
$stmt_monthly->close();
$conn->close();
?>
