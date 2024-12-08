<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "db_beekeeper";

$conn = new mysqli($servername, $username, $password, $database);
if ($conn->connect_error) {
    die("Kết nối thất bại: " . $conn->connect_error);
}

// Nhận tham số lọc từ yêu cầu GET
$selectedMonth = isset($_GET['selectedMonth']) ? $_GET['selectedMonth'] : '';
$selectedStore = isset($_GET['selectedStore']) ? $_GET['selectedStore'] : '';

// Truy vấn danh sách cửa hàng
$sql_stores = "SELECT ID_CuaHang, TenCuaHang FROM CuaHang";
$storeResult = $conn->query($sql_stores);

$storeOptions = [];
if ($storeResult && $storeResult->num_rows > 0) {
    while ($row = $storeResult->fetch_assoc()) {
        $storeOptions[] = $row;
    }
}

// Khởi tạo biến $tableData là mảng trống để tránh lỗi nếu không có kết quả
$tableData = [];

// Truy vấn dữ liệu đơn đặt tiệc với bộ lọc
$sql = "SELECT dt.ID_DatTiec, dt.GioHen, dt.ID_LoaiTrangTri, dt.SoNguoi, dt.GhiChu, dt.TrangThai, kh.HoTen, 
               SUM(ctdt.Gia * ctdt.SoLuong) AS TongTien
        FROM DonTiec dt
        JOIN KhachHang kh ON dt.ID_KhachHang = kh.ID_KhachHang
        JOIN chitietdattiec ctdt ON dt.ID_DatTiec = ctdt.ID_DatTiec";

if ($selectedStore) {
    $sql .= " WHERE dt.ID_CuaHang = '$selectedStore'";
} else {
    $sql .= " WHERE 1=1";
}

$sql .= " AND dt.TrangThai = '3'"; // Chỉ lấy những đơn đã hoàn thành

if ($selectedMonth) {
    $sql .= " AND DATE_FORMAT(dt.GioHen, '%Y-%m') = '$selectedMonth'";
}

$sql .= " GROUP BY dt.ID_DatTiec";

$result = $conn->query($sql);
if (!$result) {
    die("Lỗi truy vấn: " . $conn->error);
}

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $tableData[] = $row;
    }
}

// Truy vấn thống kê số lượng đơn tiệc theo tháng
$sql_monthly = "SELECT DATE_FORMAT(GioHen, '%Y-%m') AS month, COUNT(ID_DatTiec) AS booking_count 
                FROM DonTiec 
                WHERE TrangThai = '3'"; // Đã hoàn thành đơn

if ($selectedStore) {
    $sql_monthly .= " AND ID_CuaHang = '$selectedStore'";
}

$sql_monthly .= " AND GioHen >= DATE_SUB(CURDATE(), INTERVAL 6 MONTH)
                  GROUP BY month
                  ORDER BY month ASC";

$monthlyResult = $conn->query($sql_monthly);
if (!$monthlyResult) {
    die("Lỗi truy vấn thống kê tháng: " . $conn->error);
}

$months = [];
$bookingCounts = [];
if ($monthlyResult->num_rows > 0) {
    while ($row = $monthlyResult->fetch_assoc()) {
        $months[] = $row['month'];
        $bookingCounts[] = $row['booking_count'];
    }
}

$conn->close();

if (isset($_GET['ajax']) && $_GET['ajax'] == '1') {
    echo json_encode([
        'tableData' => $tableData,  // Dữ liệu cho bảng
        'chartData' => [
            'months' => $months,  // Các tháng
            'bookingCounts' => $bookingCounts  // Số lượng đơn tiệc trong các tháng
        ]
    ]);
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Thống kê đơn tiệc</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
<div class="container">
    <h2 class="mt-4">Thống kê đơn tiệc</h2>

    <form id="filterForm" class="mb-3">
        <div class="form-row">
            <div class="col">
                <label for="selectedMonth">Chọn tháng:</label>
                <input type="month" id="selectedMonth" name="selectedMonth" class="form-control" value="<?= $selectedMonth ?>">
            </div>
            <div class="col">
                <label for="selectedStore">Chọn cửa hàng:</label>
                <select id="selectedStore" name="selectedStore" class="form-control">
                    <option value="">Tất cả</option>
                    <?php foreach ($storeOptions as $store): ?>
                        <option value="<?= $store['ID_CuaHang'] ?>" <?= $selectedStore == $store['ID_CuaHang'] ? "selected" : "" ?>>
                            <?= htmlspecialchars($store['TenCuaHang']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col">
                <button type="submit" class="btn btn-primary" style="margin-top: 32px;">Lọc</button>
            </div>
        </div>
    </form>

    <table id="partyTable" class="table table-bordered mt-4">
        <thead class="thead-light">
            <tr>
                <th scope="col">Tên Khách Hàng</th>
                <th scope="col">Giờ Hẹn</th>
                <th scope="col">Số Người</th>
                <th scope="col">Ghi Chú</th>
                <th scope="col">Trạng Thái</th>
                <th scope="col">Tổng Tiền</th>
            </tr>
        </thead>
        <tbody id="tableBody">
            <?php
            if (count($tableData) > 0) {
                foreach ($tableData as $row) {
                    $statusText = $row['TrangThai'] == '3' ? 'Đã hoàn thành' : 'Đã hủy';
                    echo "
                    <tr>
                        <td>{$row['HoTen']}</td>
                        <td>{$row['GioHen']}</td>
                        <td>{$row['SoNguoi']}</td>
                        <td>{$row['GhiChu']}</td>
                        <td>{$statusText}</td>
                        <td>" . number_format($row['TongTien'], 0, ',', '.') . " VNĐ</td>
                    </tr>
                    ";
                }
            } else {
                echo "<tr><td colspan='6' class='text-center'>Không có đơn tiệc nào</td></tr>";
            }
            ?>
        </tbody>
    </table>

    <div class="mt-5">
        <h3>Biểu đồ thống kê số lượng đơn tiệc các tháng gần nhất</h3>
        <canvas id="bookingChart"></canvas>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>

<script>
    // Cập nhật biểu đồ
    const months = <?= json_encode($months) ?>;
    const bookingCounts = <?= json_encode($bookingCounts) ?>;

    var ctx = document.getElementById('bookingChart').getContext('2d');
    var bookingChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: months, // Các tháng
            datasets: [{
                label: 'Số lượng đơn tiệc',
                data: bookingCounts, // Số lượng đơn tiệc trong các tháng
                backgroundColor: 'rgba(54, 162, 235, 0.2)',
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });

    // Sử dụng Ajax để gửi dữ liệu và giữ lại URL trang
    $("#filterForm").submit(function(e) {
        e.preventDefault(); // Ngừng hành động submit mặc định (ngăn trang không tải lại)

        // Lấy giá trị từ các trường nhập liệu
        const selectedMonth = $("#selectedMonth").val();
        const selectedStore = $("#selectedStore").val();

        // Gửi yêu cầu Ajax để lấy dữ liệu
        $.ajax({
            url: "thong-ke-don-tiec.php", // Gửi yêu cầu đến chính trang hiện tại
            type: "GET",
            data: {
                selectedMonth: selectedMonth,
                selectedStore: selectedStore,
                ajax: 1 // Thêm tham số để xác định đây là yêu cầu Ajax
            },
            success: function(response) {
                const data = JSON.parse(response);
                updateTable(data.tableData);  // Cập nhật bảng với dữ liệu mới
                updateChart(data.chartData);  // Cập nhật biểu đồ
            },
            error: function() {
                alert("Đã xảy ra lỗi khi tải dữ liệu.");
            }
        });
    });

    function updateTable(tableData) {
        const tableBody = $("#tableBody");
        tableBody.empty(); // Xóa dữ liệu cũ trong bảng

        if (tableData.length > 0) {
            tableData.forEach(row => {
                const statusText = row.TrangThai === '3' ? 'Đã hoàn thành' : 'Đã hủy';
                tableBody.append(`
                    <tr>
                        <td>${row.HoTen}</td>
                        <td>${row.GioHen}</td>
                        <td>${row.SoNguoi}</td>
                        <td>${row.GhiChu}</td>
                        <td>${statusText}</td>
                        <td>${new Intl.NumberFormat('vi-VN').format(row.TongTien)} VNĐ</td>
                    </tr>
                `);
            });
        } else {
            tableBody.append("<tr><td colspan='6' class='text-center'>Không có đơn tiệc nào</td></tr>");
        }
    }

    function updateChart(chartData) {
        const ctx = document.getElementById('bookingChart').getContext('2d');
        bookingChart.data.labels = chartData.months;
        bookingChart.data.datasets[0].data = chartData.bookingCounts;
        bookingChart.update(); // Cập nhật lại biểu đồ
    }
</script>

</body>
</html>
