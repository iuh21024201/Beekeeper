<?php
// Kết nối cơ sở dữ liệu
include_once("../../controller/cThongKeDoanhThu.php");
include_once("../../controller/c_xem_so_luong_ban.php");

// Instantiate the classes
$p = new CThongKeDoanhThu();
$cuaHangController = new CCuaHang();

$data = [];
$labels = [];
$doanhThuDonHang = [];
$doanhThuDatTiec = [];
$chartData = [];
$startDate = $_POST['start_date'] ?? null;
$endDate = $_POST['end_date'] ?? null;

// Lấy thông tin cửa hàng
$CuaHang = $cuaHangController->get1CuaHang($idTaiKhoan);
if ($CuaHang && $CuaHang->num_rows > 0) {
    $row = $CuaHang->fetch_assoc();
    $idCuaHang = $row['ID_CuaHang'];
    $tenCuaHang = $row['TenCuaHang']; // Lấy tên cửa hàng
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Kiểm tra nếu có ngày bắt đầu và ngày kết thúc
    if ($startDate && $endDate) {
        // Kiểm tra nếu ngày bắt đầu lớn hơn ngày kết thúc
        if ($startDate > $endDate) {
            $errorMessage = "Ngày bắt đầu phải trước ngày kết thúc.";
        } else {
            // Nếu ngày hợp lệ, thực hiện thống kê
            $data1 = $p->getDoanhThu1CuaHangByCuaHang($startDate, $endDate, $idCuaHang);
            $data2 = $p->getDoanhThu1CuaHangByThoiGian($startDate, $endDate, $idCuaHang);
        }
    } else {
        // Nếu không có ngày bắt đầu và kết thúc, lấy dữ liệu tất cả (hoặc theo loại lọc)
        $data1 = $p->getDoanhThu1CuaHangByCuaHang(null, null, $idCuaHang);
        $data2 = $p->getDoanhThu1CuaHangByThoiGian(null, null, $idCuaHang);
    }
} else {
    // Khi không phải là POST, lấy dữ liệu mặc định
    $data1 = $p->getDoanhThu1CuaHangByCuaHang(null, null, $idCuaHang);
    $data2 = $p->getDoanhThu1CuaHangByThoiGian(null, null, $idCuaHang);
}

// Xử lý dữ liệu từ `$data1` (Doanh thu theo cửa hàng)
if ($data1 && is_array($data1)) {
    foreach ($data1 as $row) {
        $chartData[] = [
            "DoanhThuDonHang" => $row["DoanhThuDonHang"] ?? 0,
            "DoanhThuDatTiec" => $row["DoanhThuDatTiec"] ?? 0,
            "TongDoanhThu" => $row["TongDoanhThu"] ?? 0,
        ];
    }
}

// Xử lý dữ liệu từ `$data2` (Doanh thu theo thời gian)
if ($data2 && is_array($data2)) {
    foreach ($data2 as $row) {
        $labels[] = $row["Ngay"];
        $doanhThuDonHang[] = $row["DoanhThuDonHang"] ?? 0;
        $doanhThuDatTiec[] = $row["DoanhThuDatTiec"] ?? 0;
    }
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thống kê doanh thu</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link rel="stylesheet" href="../../asset/css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <h3 class="mt-4">Thống kê doanh thu</h3>
        <hr>
        <p>Tên cửa hàng: <strong><?php echo htmlspecialchars($tenCuaHang); ?></strong></p>

        <!-- Form lọc theo ngày -->
        <form action="" method="POST" id="filterForm">
            <div class="form-row">
                <div class="col">
                    <label for="start_date">Ngày bắt đầu</label>
                    <input type="date" class="form-control" name="start_date" id="start_date" 
                        value="<?php echo htmlspecialchars($startDate); ?>">
                </div>
                <div class="col">
                    <label for="end_date">Ngày kết thúc</label>
                    <input type="date" class="form-control" name="end_date" id="end_date" 
                        value="<?php echo htmlspecialchars($endDate); ?>">
                </div>
                <div class="col d-flex align-items-end">
                    <button type="submit" class="btn btn-primary">Thống kê</button>
                    <button type="button" class="btn btn-secondary ml-2" onclick="resetForm()">Làm mới</button>
                </div>
            </div>
        </form>

        <!-- Bảng thống kê -->
        <table class="table table-bordered mt-4">
            <thead class="thead-light">
                <tr>
                    <th scope="col">Doanh Thu Đơn Hàng (VNĐ)</th>
                    <th scope="col">Doanh Thu Đặt Tiệc (VNĐ)</th>
                    <th scope="col">Tổng Doanh Thu (VNĐ)</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if (!empty($chartData)) {
                    foreach ($chartData as $row) {
                        echo "<tr>";
                        echo "<td>" . number_format($row["DoanhThuDonHang"], 0, ',', '.') . " VNĐ</td>";
                        echo "<td>" . number_format($row["DoanhThuDatTiec"], 0, ',', '.') . " VNĐ</td>";
                        echo "<td>" . number_format($row["TongDoanhThu"], 0, ',', '.') . " VNĐ</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='4' class='text-center'>Không có dữ liệu</td></tr>";
                }
                ?>
            </tbody>
        </table>

        <!-- Biểu đồ -->
        <canvas id="doanhThuChart"></canvas>
        <script>
            const ctx = document.getElementById('doanhThuChart').getContext('2d');

            // Initialize the chart
            let doanhThuChart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: <?php echo json_encode($labels); ?>,
                    datasets: [
                        {
                            label: 'Doanh thu từ đơn hàng',
                            data: <?php echo json_encode($doanhThuDonHang); ?>,
                            backgroundColor: 'rgba(54, 162, 235, 0.6)',
                            borderColor: 'rgba(54, 162, 235, 1)',
                            fill: false,
                            borderWidth: 1
                        },
                        {
                            label: 'Doanh thu từ đặt tiệc',
                            data: <?php echo json_encode($doanhThuDatTiec); ?>,
                            backgroundColor: 'rgba(255, 99, 132, 0.6)',
                            borderColor: 'rgba(255, 99, 132, 1)',
                            fill: false,
                            borderWidth: 1
                        }
                    ]
                },
                options: {
                    responsive: true,
                    scales: {
                        x: {
                            title: {
                                display: true,
                                text: 'Ngày'
                            }
                        },
                        y: {
                            beginAtZero: true,
                            title: {
                                display: true,
                                text: 'Doanh thu (VND)'
                            }
                        }
                    }
                }
            });

            function resetForm() {
                const form = document.getElementById('filterForm');
                if (form) {
                    form.reset(); // Reset tất cả các trường trong form
                }
                // Đặt lại các giá trị mặc định cho ngày bắt đầu và ngày kết thúc
                document.getElementById('start_date').value = '';
                document.getElementById('end_date').value = '';
            }

            // Front-end validation for date selection
            document.getElementById('filterForm').addEventListener('submit', function(event) {
            const startDate = document.getElementById('start_date').value;
            const endDate = document.getElementById('end_date').value;

            // Kiểm tra nếu cả ngày bắt đầu và ngày kết thúc đều có giá trị
            if (startDate && endDate) {
                // Chuyển đổi ngày sang đối tượng Date để so sánh chính xác
                const startDateObj = new Date(startDate);
                const endDateObj = new Date(endDate);

                // Kiểm tra nếu ngày bắt đầu lớn hơn ngày kết thúc
                if (startDateObj > endDateObj) {
                    event.preventDefault(); // Ngừng gửi form
                    alert("Ngày bắt đầu phải trước ngày kết thúc.");
                }
            }
        });
        </script>
    </div>
</body>
</html>

