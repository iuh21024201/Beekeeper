<?php
// thong-ke-don-hang.php

// Khởi động session nếu chưa có
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$database = "db_beekeeper";

$conn = new mysqli($servername, $username, $password, $database);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Kiểm tra đăng nhập (tuỳ chọn)
if (!isset($_SESSION['ID_TaiKhoan'])) {
    echo "Bạn cần đăng nhập để xem thống kê.";
    exit;
}

// Lấy danh sách cửa hàng
$sql_stores = "SELECT ID_CuaHang, TenCuaHang FROM CuaHang";
$storeResult = $conn->query($sql_stores);
$stores = [];
if ($storeResult->num_rows > 0) {
    while ($row = $storeResult->fetch_assoc()) {
        $stores[] = $row;
    }
}

// Lấy dữ liệu lọc từ form
$selectedMonth = isset($_GET['month']) ? $_GET['month'] : '';
$customerName = isset($_GET['customerName']) ? $_GET['customerName'] : '';
$selectedStore = isset($_GET['store']) ? $_GET['store'] : '';

// Xây dựng câu truy vấn cơ bản
$sql = "SELECT 
            donhang.ID_DonHang, 
            KhachHang.HoTen AS TenKhachHang, 
            nhanvien.HoTen AS TenNhanVien, 
            donhang.NgayDat, 
            donhang.DiaChiGiaoHang, 
            donhang.PhuongThucThanhToan 
        FROM donhang 
        LEFT JOIN KhachHang ON donhang.ID_KhachHang = KhachHang.ID_KhachHang
        LEFT JOIN nhanvien ON donhang.ID_NhanVien = nhanvien.ID_NhanVien
        WHERE donhang.TrangThai = 'đã giao hàng'";

$params = [];
$types = "";

// Thêm điều kiện lọc
if (!empty($selectedMonth)) {
    $sql .= " AND DATE_FORMAT(donhang.NgayDat, '%Y-%m') = ?";
    $params[] = $selectedMonth;
    $types .= "s";
}
if (!empty($customerName)) {
    $sql .= " AND (KhachHang.HoTen LIKE ? OR nhanvien.HoTen LIKE ?)";
    $params[] = "%" . $customerName . "%";
    $params[] = "%" . $customerName . "%";
    $types .= "ss";
}
if (!empty($selectedStore)) {
    $sql .= " AND donhang.ID_CuaHang = ?";
    $params[] = $selectedStore;
    $types .= "i";
}

// Chuẩn bị và thực thi truy vấn
$stmt = $conn->prepare($sql);
if (!empty($params)) {
    $stmt->bind_param($types, ...$params);
}
$stmt->execute();
$result = $stmt->get_result();

// Lấy số liệu biểu đồ
$sql_monthly = "SELECT DATE_FORMAT(NgayDat, '%Y-%m') AS month, COUNT(ID_DonHang) AS order_count
                FROM donhang
                WHERE NgayDat >= DATE_SUB(CURDATE(), INTERVAL 6 MONTH)
                  AND TrangThai = 'đã giao hàng'";

if (!empty($selectedStore)) {
    $sql_monthly .= " AND ID_CuaHang = '$selectedStore'";
}

$sql_monthly .= " GROUP BY month
                  ORDER BY month ASC";

$monthlyResult = $conn->query($sql_monthly);

// Chuẩn bị dữ liệu biểu đồ
$months = [];
$orderCounts = [];
if ($monthlyResult->num_rows > 0) {
    while ($row = $monthlyResult->fetch_assoc()) {
        $months[] = $row['month'];
        $orderCounts[] = $row['order_count'];
    }
}

// Tháng cho dropdown
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

        <!-- Form lọc -->
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

            <label for="store" class="mr-2">Chọn cửa hàng:</label>
            <select name="store" id="store" class="form-control mr-2">
                <option value="">Tất cả</option>
                <?php
                foreach ($stores as $store) {
                    $selected = ($store['ID_CuaHang'] == $selectedStore) ? 'selected' : '';
                    echo "<option value='{$store['ID_CuaHang']}' $selected>{$store['TenCuaHang']}</option>";
                }
                ?>
            </select>

            <label for="customerName" class="mr-2">Nhập tên cần tìm: </label>
            <input type="text" name="customerName" id="customerName" class="form-control mr-2" value="<?= htmlspecialchars($customerName) ?>">
            <button type="submit" class="btn btn-primary">Lọc</button>
        </form>

        <!-- Bảng thống kê -->
        <table class="table table-bordered mt-4">
            <thead class="thead-light">
                <tr>
                    <th>Khách Hàng</th>
                    <th>Nhân Viên</th>
                    <th>Ngày Đặt</th>
                    <th>Địa Chỉ Giao Hàng</th>
                    <th>Phương Thức Thanh Toán</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>
                                <td>" . htmlspecialchars($row['TenKhachHang']) . "</td>
                                <td>" . htmlspecialchars($row['TenNhanVien']) . "</td>
                                <td>" . htmlspecialchars($row['NgayDat']) . "</td>
                                <td>" . htmlspecialchars($row['DiaChiGiaoHang']) . "</td>
                                <td>" . ($row['PhuongThucThanhToan'] == 0 ? "Thu tiền mặt" : "Chuyển khoản") . "</td>
                              </tr>";
                    }
                } else {
                    echo "<tr><td colspan='5' class='text-center'>Không có đơn hàng nào</td></tr>";
                }
                ?>
            </tbody>
        </table>

        <!-- Biểu đồ -->
        <div class="mt-5">
            <h3>Thống kê số lượng đơn hàng gần nhất</h3>
            <canvas id="orderChart" width="400" height="200"></canvas>
        </div>
    </div>

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
                    backgroundColor: 'rgba(75, 192, 192, 0.8)',
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: { beginAtZero: true },
                    x: { title: { display: true, text: 'Tháng' } }
                }
            }
        });
    });
    </script>
</body>
</html>

<?php
$stmt->close();
$conn->close();
?>
