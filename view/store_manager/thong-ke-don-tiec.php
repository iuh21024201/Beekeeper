<?php
// thong-ke-don-tiec.php

$servername = "localhost";
$username = "root";
$password = "";
$database = "beekeeper";

$conn = new mysqli($servername, $username, $password, $database);
if ($conn->connect_error) {
    die("Kết nối thất bại: " . $conn->connect_error);
}

// Nhận tham số tháng và trạng thái từ yêu cầu GET
$selectedMonth = isset($_GET['selectedMonth']) ? $_GET['selectedMonth'] : '';
$status = isset($_GET['status']) ? $_GET['status'] : '';

// Truy vấn dữ liệu đơn đặt tiệc với bộ lọc tháng và trạng thái
$sql = "SELECT ID_DatTiec, ID_KhachHang, ID_CuaHang, GioHen, TrangTri, SoNguoi, TongTien, TienCoc, TienConLai, GhiChu, TrangThai
        FROM DonTiec WHERE 1";

if ($selectedMonth) {
    $sql .= " AND DATE_FORMAT(GioHen, '%Y-%m') = '$selectedMonth'";
}

if ($status !== '') {
    $sql .= " AND TrangThai = '$status'";
}

$result = $conn->query($sql);
$tableData = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $tableData[] = $row;
    }
}

// Truy vấn thống kê số lượng đơn tiệc theo tháng
$sql_monthly = "SELECT DATE_FORMAT(GioHen, '%Y-%m') AS month, COUNT(ID_DatTiec) AS booking_count
                FROM DonTiec
                WHERE GioHen >= DATE_SUB(CURDATE(), INTERVAL 6 MONTH)
                GROUP BY month
                ORDER BY month ASC";
$monthlyResult = $conn->query($sql_monthly);
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
        'tableData' => $tableData,
        'chartData' => [
            'months' => $months,
            'bookingCounts' => $bookingCounts
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

    <!-- Bộ lọc tháng và trạng thái -->
    <form id="filterForm" class="mb-3">
        <div class="form-row">
            <div class="col">
                <label for="selectedMonth">Chọn tháng:</label>
                <input type="month" id="selectedMonth" name="selectedMonth" class="form-control" value="<?= $selectedMonth ?>">
            </div>
            <div class="col">
                <label for="status">Chọn trạng thái:</label>
                <select id="status" name="status" class="form-control">
                    <option value="" <?= $status === '' ? 'selected' : '' ?>>Tất cả</option>
                    <option value="0" <?= $status === '0' ? 'selected' : '' ?>>Đơn hủy</option>
                    <option value="1" <?= $status === '1' ? 'selected' : '' ?>>Đơn đã hoàn thành</option>
                    <option value="2" <?= $status === '2' ? 'selected' : '' ?>>Chưa hoàn thành</option>
                </select>
            </div>
            <div class="col">
                <button type="submit" class="btn btn-primary" style="margin-top: 32px;">Lọc</button>
            </div>
        </div>
    </form>

    <!-- Bảng đơn tiệc -->
    <table id="partyTable" class="table table-bordered mt-4">
        <thead class="thead-light">
            <tr>
                <th scope="col">ID Đặt Tiệc</th>
                <th scope="col">ID Khách Hàng</th>
                <th scope="col">ID Cửa Hàng</th>
                <th scope="col">Giờ Hẹn</th>
                <th scope="col">Trang Trí</th>
                <th scope="col">Số Người</th>
                <th scope="col">Tổng Tiền</th>
                <th scope="col">Tiền Cọc</th>
                <th scope="col">Tiền Còn Lại</th>
                <th scope="col">Ghi Chú</th>
                <th scope="col">Trạng Thái</th>
            </tr>
        </thead>
        <tbody id="tableBody">
            <?php
            if (count($tableData) > 0) {
                foreach ($tableData as $row) {
                    // Hiển thị trạng thái dưới dạng văn bản
                    $statusText = $row['TrangThai'] == '1' ? 'Đã hoàn thành' : ($row['TrangThai'] == '0' ? 'Đã hủy' : 'Chưa hoàn thành');
                    echo "
                    <tr>
                        <td>{$row['ID_DatTiec']}</td>
                        <td>{$row['ID_KhachHang']}</td>
                        <td>{$row['ID_CuaHang']}</td>
                        <td>{$row['GioHen']}</td>
                        <td>{$row['TrangTri']}</td>
                        <td>{$row['SoNguoi']}</td>
                        <td>{$row['TongTien']}</td>
                        <td>{$row['TienCoc']}</td>
                        <td>{$row['TienConLai']}</td>
                        <td>{$row['GhiChu']}</td>
                        <td>{$statusText}</td>
                    </tr>
                    ";
                }
            } else {
                echo "<tr><td colspan='11' class='text-center'>Không có đơn tiệc nào</td></tr>";
            }
            ?>
        </tbody>
    </table>

    <!-- Biểu đồ số lượng đơn tiệc -->
    <div class="mt-5">
        <h3>Biểu đồ thống kê số lượng đơn tiệc các tháng gần nhất</h3>
        <canvas id="bookingChart"></canvas>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
    // Gửi yêu cầu AJAX để lọc theo tháng và trạng thái
    $("#filterForm").submit(function(e) {
        e.preventDefault();

        const selectedMonth = $("#selectedMonth").val();
        const status = $("#status").val();

        $.ajax({
            url: "thong-ke-don-tiec.php",
            type: "GET",
            data: {
                selectedMonth: selectedMonth,
                status: status,
                ajax: 1
            },
            success: function(response) {
                const data = JSON.parse(response);
                updateTable(data.tableData);
                updateChart(data.chartData);
            }
        });
    });

    function updateTable(data) {
        const tableBody = $("#tableBody");
        tableBody.empty();

        if (data.length > 0) {
            data.forEach(row => {
                const statusText = row.TrangThai == '1' ? 'Đã hoàn thành' : (row.TrangThai == '0' ? 'Đã hủy' : 'Chưa hoàn thành');
                tableBody.append(`
                    <tr>
                        <td>${row.ID_DatTiec}</td>
                        <td>${row.ID_KhachHang}</td>
                        <td>${row.ID_CuaHang}</td>
                        <td>${row.GioHen}</td>
                        <td>${row.TrangTri}</td>
                        <td>${row.SoNguoi}</td>
                        <td>${row.TongTien}</td>
                        <td>${row.TienCoc}</td>
                        <td>${row.TienConLai}</td>
                        <td>${row.GhiChu}</td>
                        <td>${statusText}</td>
                    </tr>
                `);
            });
        } else {
            tableBody.append("<tr><td colspan='11' class='text-center'>Không có đơn tiệc nào</td></tr>");
        }
    }

    function updateChart(data) {
        const ctx = document.getElementById('bookingChart').getContext('2d');
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: data.months,
                datasets: [{
                    label: 'Số lượng đơn tiệc',
                    data: data.bookingCounts,
                    backgroundColor: 'rgba(54, 162, 235, 0.6)',
                    borderColor: 'rgba(54, 162, 235, 1)',
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
                            text: 'Số lượng đơn tiệc'
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
    }

    // Cập nhật biểu đồ ban đầu từ dữ liệu PHP
    const chartData = {
        months: <?php echo json_encode(value: $months); ?>,
        bookingCounts: <?php echo json_encode(value: $bookingCounts); ?>
    };
    updateChart(chartData);
</script>
</body>
</html>
