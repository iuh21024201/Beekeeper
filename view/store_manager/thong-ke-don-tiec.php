<?php
// thong-ke-don-tiec.php

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

// Ensure user is logged in and has the 'ID_TaiKhoan' session
if (!isset($_SESSION['ID_TaiKhoan'])) {
    echo "Bạn cần đăng nhập để xem thống kê.";
    exit;
}

$idTaiKhoan = $_SESSION['ID_TaiKhoan'];

// Fetch the store ID of the current user from the session
$sqlStore = "SELECT ID_CuaHang FROM quanlycuahang WHERE ID_TaiKhoan = ?";
$stmtStore = $conn->prepare($sqlStore);
if ($stmtStore === false) {
    die("Error preparing SQL statement for store: " . $conn->error); // Thông báo lỗi khi chuẩn bị câu lệnh SQL
}
$stmtStore->bind_param("i", $idTaiKhoan);
$stmtStore->execute();
$resultStore = $stmtStore->get_result();

// If no store is found for the user, show an error
if ($resultStore->num_rows == 0) {
    echo "Bạn không có quyền truy cập cửa hàng nào.";
    exit;
}

$rowStore = $resultStore->fetch_assoc();
$idCuaHang = $rowStore['ID_CuaHang'];

// Nhận tham số tháng và trạng thái từ yêu cầu GET
$selectedMonth = isset($_GET['selectedMonth']) ? $_GET['selectedMonth'] : '';
$status = isset($_GET['status']) ? $_GET['status'] : '';
// Truy vấn dữ liệu đơn đặt tiệc với bộ lọc tháng, trạng thái và cửa hàng
$sql = "SELECT dt.ID_DatTiec, dt.GioHen, dt.ID_LoaiTrangTri, dt.SoNguoi, dt.GhiChu, dt.TrangThai, kh.HoTen,
               SUM(ma.Gia * ctdt.SoLuong) AS TongTien
        FROM DonTiec dt
        JOIN KhachHang kh ON dt.ID_KhachHang = kh.ID_KhachHang
        JOIN chitietdattiec ctdt ON dt.ID_DatTiec = ctdt.ID_DatTiec
        JOIN monan ma ON ctdt.ID_MonAn = ma.ID_MonAn
        JOIN quanlycuahang qc ON dt.ID_CuaHang = qc.ID_CuaHang
        WHERE dt.TrangThai = '3' AND qc.ID_CuaHang = ?";


if ($selectedMonth) {
    $sql .= " AND DATE_FORMAT(dt.GioHen, '%Y-%m') = ?";
}

if ($status !== '') {
    $sql .= " AND dt.TrangThai = ?";
}

$sql .= " GROUP BY dt.ID_DatTiec";

$stmt = $conn->prepare($sql);
if ($stmt === false) {
    die("Lỗi chuẩn bị câu lệnh SQL: " . $conn->error);
}

// Bind giá trị động vào câu truy vấn
if ($selectedMonth && $status !== '') {
    $stmt->bind_param("iss", $idCuaHang, $selectedMonth, $status);
} elseif ($selectedMonth) {
    $stmt->bind_param("is", $idCuaHang, $selectedMonth);
} elseif ($status !== '') {
    $stmt->bind_param("is", $idCuaHang, $status);
} else {
    $stmt->bind_param("i", $idCuaHang);
}

// Thực thi truy vấn
$stmt->execute();
$result = $stmt->get_result();

$tableData = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $tableData[] = $row;
    }
}
$stmt->close();


// Truy vấn thống kê số lượng đơn tiệc theo tháng
$sql_monthly = "SELECT DATE_FORMAT(dt.GioHen, '%Y-%m') AS month, COUNT(dt.ID_DatTiec) AS booking_count
                FROM DonTiec dt
                JOIN quanlycuahang qc ON dt.ID_CuaHang = qc.ID_CuaHang
                WHERE dt.GioHen >= DATE_SUB(CURDATE(), INTERVAL 6 MONTH)
                  AND dt.TrangThai = '3'
                  AND qc.ID_CuaHang = ?
                GROUP BY month
                ORDER BY month ASC";

$stmtMonthly = $conn->prepare($sql_monthly);
if ($stmtMonthly === false) {
    die("Lỗi chuẩn bị câu lệnh SQL thống kê tháng: " . $conn->error);
}
$stmtMonthly->bind_param("i", $idCuaHang);
$stmtMonthly->execute();
$monthlyResult = $stmtMonthly->get_result();


$months = [];
$bookingCounts = [];
if ($monthlyResult->num_rows > 0) {
    while ($row = $monthlyResult->fetch_assoc()) {
        $months[] = $row['month'];
        $bookingCounts[] = $row['booking_count'];
    }
}
$stmtMonthly->close();


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
                <button type="submit" class="btn btn-primary" style="margin-top: 32px;">Lọc</button>
            </div>
        </div>
    </form>

    <!-- Bảng đơn tiệc -->
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
                const statusText = row.TrangThai == '3' ? 'Đã hoàn thành' : 'Lỗi';
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
        months: <?php echo json_encode($months); ?>,
        bookingCounts: <?php echo json_encode($bookingCounts); ?>
    };
    updateChart(chartData);
</script>
</body>
</html>
