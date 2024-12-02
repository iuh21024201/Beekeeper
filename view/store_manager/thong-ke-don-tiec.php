<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Kết nối cơ sở dữ liệu
$servername = "localhost";
$username = "root";
$password = "";
$database = "db_beekeeper_8"; // Thay thế bằng tên cơ sở dữ liệu thực tế

$conn = new mysqli($servername, $username, $password, $database);
if ($conn->connect_error) {
    die("Lỗi kết nối cơ sở dữ liệu: " . $conn->connect_error);
}

// Kiểm tra quyền truy cập và lấy ID_CuaHang từ session
if (!isset($_SESSION['ID_TaiKhoan']) || empty($_SESSION['ID_TaiKhoan'])) {
    die("Lỗi: Bạn không có quyền truy cập.");
}

$idTaiKhoan = $_SESSION['ID_TaiKhoan'];

// Truy vấn ID_CuaHang từ tài khoản quản lý
$sqlCuaHang = "SELECT ID_CuaHang FROM quanlycuahang WHERE ID_TaiKhoan = ?";
$stmtCuaHang = $conn->prepare($sqlCuaHang);

if (!$stmtCuaHang) {
    die("Lỗi chuẩn bị câu lệnh SQL: " . $conn->error);
}

$stmtCuaHang->bind_param('i', $idTaiKhoan);

if (!$stmtCuaHang->execute()) {
    die("Lỗi thực thi câu lệnh SQL: " . $stmtCuaHang->error);
}

$resultCuaHang = $stmtCuaHang->get_result();

// Kiểm tra nếu kết quả trả về hợp lệ
if ($resultCuaHang && $resultCuaHang->num_rows > 0) {
    $rowCuaHang = $resultCuaHang->fetch_assoc();
    $idCuaHang = $rowCuaHang['ID_CuaHang'];
} else {
    die("Không tìm thấy cửa hàng phù hợp cho tài khoản này.");
}

// Nhận tham số từ yêu cầu GET
$selectedMonth = isset($_GET['selectedMonth']) ? $_GET['selectedMonth'] : '';
$customerName = isset($_GET['customerName']) ? $_GET['customerName'] : '';

// Truy vấn dữ liệu đơn đặt tiệc với bộ lọc
$sql = "SELECT dt.ID_CuaHang, dt.GioHen, lt.TenTrangTri, dt.SoNguoi, dt.TongTien, dt.TienCoc, dt.TienConLai, dt.GhiChu, kh.HoTen, cuahang.TenCuaHang
        FROM DonTiec dt
        JOIN KhachHang kh ON dt.ID_KhachHang = kh.ID_KhachHang
        JOIN CuaHang cuahang ON dt.ID_CuaHang = cuahang.ID_CuaHang
        JOIN LoaiTrangTri lt ON dt.ID_LoaiTrangTri = lt.ID_LoaiTrangTri
        WHERE dt.ID_CuaHang = ? AND dt.TrangThai = 1"; // Chỉ lấy đơn tiệc có trạng thái = 1

// Thêm bộ lọc vào câu truy vấn nếu có
if ($selectedMonth) {
    $sql .= " AND DATE_FORMAT(dt.GioHen, '%Y-%m') = ?";
}
if ($customerName) {
    $sql .= " AND kh.HoTen LIKE ?";
}


$stmt = $conn->prepare($sql);
if (!$stmt) {
    die("Lỗi chuẩn bị câu lệnh SQL: " . $conn->error);
}

$types = 'i'; // ID_CuaHang là kiểu integer
$params = [$idCuaHang];

if ($selectedMonth) {
    $types .= 's';
    $params[] = $selectedMonth;
}
if ($customerName) {
    $types .= 's';
    $params[] = "%" . $customerName . "%";
}

$stmt->bind_param($types, ...$params);

if (!$stmt->execute()) {
    die("Lỗi thực thi câu lệnh SQL: " . $stmt->error);
}

$result = $stmt->get_result();
$tableData = [];
while ($row = $result->fetch_assoc()) {
    $tableData[] = $row;
}

// Truy vấn thống kê số lượng đơn tiệc theo tháng
$sql_monthly = "SELECT DATE_FORMAT(GioHen, '%Y-%m') AS month, COUNT(ID_DatTiec) AS booking_count
                FROM DonTiec
                WHERE ID_CuaHang = ? AND TrangThai = 1
                  AND GioHen >= DATE_SUB(CURDATE(), INTERVAL 6 MONTH)
                GROUP BY month
                ORDER BY month ASC";

$stmt_monthly = $conn->prepare($sql_monthly);
if (!$stmt_monthly) {
    die("Lỗi chuẩn bị câu lệnh SQL: " . $conn->error);
}

$stmt_monthly->bind_param('i', $idCuaHang);

if (!$stmt_monthly->execute()) {
    die("Lỗi thực thi câu lệnh SQL: " . $stmt_monthly->error);
}

$monthlyResult = $stmt_monthly->get_result();
$months = [];
$bookingCounts = [];
while ($row = $monthlyResult->fetch_assoc()) {
    $months[] = $row['month'];
    $bookingCounts[] = $row['booking_count'];
}

$conn->close();

// Xử lý nếu là yêu cầu AJAX
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

    <!-- Bộ lọc -->
    <form id="filterForm" class="mb-3">
        <div class="form-row">
            <div class="col">
                <label for="selectedMonth">Chọn tháng:</label>
                <input type="month" id="selectedMonth" name="selectedMonth" class="form-control" value="<?= $selectedMonth ?>">
            </div>
            <div class="col">
                <label for="customerName">Tên khách hàng:</label>
                <input type="text" id="customerName" name="customerName" class="form-control" value="<?= $customerName ?>">
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
            <th scope="col">Tên Cửa Hàng</th>
            <th scope="col">Giờ Hẹn</th>
            <th scope="col">Loại Trang Trí</th>
            <th scope="col">Số Người</th>
            <th scope="col">Tổng Tiền</th>
            <th scope="col">Tiền Cọc</th>
            <th scope="col">Tiền Còn Lại</th>
            <th scope="col">Ghi Chú</th>
        </tr>
    </thead>
    <tbody id="tableBody">
        <?php
        if (count($tableData) > 0) {
            foreach ($tableData as $row) {
                echo "<tr>";
                echo "<td>{$row['HoTen']}</td>";
                echo "<td>{$row['TenCuaHang']}</td>";
                echo "<td>{$row['GioHen']}</td>";
                echo "<td>{$row['TenTrangTri']}</td>"; // Hiển thị Tên Trang trí
                echo "<td>{$row['SoNguoi']}</td>";
                echo "<td>{$row['TongTien']}</td>";
                echo "<td>{$row['TienCoc']}</td>";
                echo "<td>{$row['TienConLai']}</td>";
                echo "<td>{$row['GhiChu']}</td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='9' class='text-center'>Không có đơn tiệc nào</td></tr>";
        }
        ?>
    </tbody>
</table>


    <!-- Biểu đồ -->
    <div class="mt-5">
        <h3>Biểu đồ thống kê số lượng đơn tiệc các tháng gần nhất</h3>
        <canvas id="bookingChart"></canvas>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script>
    $("#filterForm").submit(function(e) {
        e.preventDefault();
        $.ajax({
            url: "thong-ke-don-tiec.php",
            type: "GET",
            data: $(this).serialize() + "&ajax=1",
            success: function(response) {
                var data = JSON.parse(response);
                updateTable(data.tableData);
                updateChart(data.chartData);
            }
        });
    });

    function updateTable(data) {
        var tableBody = $("#tableBody");
        tableBody.empty();
        data.forEach(function(row) {
            var rowHtml = "<tr>";
            rowHtml += "<td>" + row.HoTen + "</td>";
            rowHtml += "<td>" + row.TenCuaHang + "</td>";
            rowHtml += "<td>" + row.GioHen + "</td>";
            rowHtml += "<td>" + row.ID_LoaiTrangTri + "</td>";
            rowHtml += "<td>" + row.SoNguoi + "</td>";
            rowHtml += "<td>" + row.TongTien + "</td>";
            rowHtml += "<td>" + row.TienCoc + "</td>";
            rowHtml += "<td>" + row.TienConLai + "</td>";
            rowHtml += "<td>" + row.GhiChu + "</td>";
            rowHtml += "</tr>";
            tableBody.append(rowHtml);
        });
    }

    function updateChart(chartData) {
    var ctx = document.getElementById("bookingChart").getContext('2d');
    if (ctx) {
        var chart = new Chart(ctx, {
            type: 'bar', // Thay đổi loại biểu đồ thành cột (bar)
            data: {
                labels: chartData.months,
                datasets: [{
                    label: 'Số lượng đơn tiệc',
                    data: chartData.bookingCounts,
                    backgroundColor: 'rgba(75, 192, 192, 0.9)', // Màu nền cho cột
                    borderColor: 'rgb(75, 192, 192)', // Màu viền cho cột
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true // Đảm bảo trục y bắt đầu từ 0
                    }
                }
            }
        });
    }
}

</script>
</body>
</html>
