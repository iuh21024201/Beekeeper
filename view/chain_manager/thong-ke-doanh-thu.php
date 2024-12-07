<?php
include_once("../../controller/cThongKeDoanhThu.php");

// Instantiate the class
$p = new CThongKeDoanhThu();

// Initialize variables
$data = [];
$chartData = [];
$startDate = $_POST['start_date'] ?? null;
$endDate = $_POST['end_date'] ?? null;
$labels = [];
$doanhThuDonHang = [];
$doanhThuDatTiec = [];
$filterType = $_POST['filter_type'] ?? 'store'; // Default: store

// Get data from the controller
$datan = $p->getDoanhThu($filterType, $startDate, $endDate);


// Process data if available
if ($datan && is_array($datan)) {
    foreach ($datan as $row) {
        if ($filterType === 'time') {
            $data[] = [
                "Ngay" => $row["Ngay"],
                "DoanhThuDonHang" => $row["DoanhThuDonHang"],
                "DoanhThuDatTiec" => $row["DoanhThuDatTiec"],
            ];
            $labels[] = $row["Ngay"];
            $doanhThuDonHang[] = $row["DoanhThuDonHang"];
            $doanhThuDatTiec[] = $row["DoanhThuDatTiec"];
        } else {
            $data[] = [
                "TenCuaHang" => $row["TenCuaHang"],
                "DoanhThuDonHang" => $row["DoanhThuDonHang"],
                "DoanhThuDatTiec" => $row["DoanhThuDatTiec"],
                "TongDoanhThu" => $row["TongDoanhThu"]
            ];
            $chartData[] = [
                "TenCuaHang" => $row["TenCuaHang"],
                "DoanhThuDonHang" => $row["DoanhThuDonHang"],
                "DoanhThuDatTiec" => $row["DoanhThuDatTiec"],
                "TongDoanhThu" => $row["TongDoanhThu"]
            ];
        }
    }
} else {
    echo "<p>Không có dữ liệu phù hợp.</p>";
}
$tongDoanhThuDonHang = array_sum(array_column($chartData, 'DoanhThuDonHang'));
$tongDoanhThuDatTiec = array_sum(array_column($chartData, 'DoanhThuDatTiec'));
$tongDoanhThuTatCa = array_sum(array_column($chartData, 'TongDoanhThu'));

?>

<!DOCTYPE html>
<html lang="en">
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
    <!-- Form lọc dữ liệu -->
    <form method="post" id="filterForm" class="mt-4">
        <div class="form-row">
            <div class="col">
                <label for="start_date">Ngày bắt đầu</label>
                <input type="date" class="form-control" name="start_date" id="start_date" 
                    value="<?php echo htmlspecialchars($startDate ?? ''); ?>">
            </div>
            <div class="col">
                <label for="end_date">Ngày kết thúc</label>
                <input type="date" class="form-control" name="end_date" id="end_date" 
                    value="<?php echo htmlspecialchars($endDate ?? ''); ?>">
            </div>
            <div class="col">
                <label for="filter_type">Lọc theo</label>
                <select class="form-control" name="filter_type" id="filter_type">
                    <option value="store" <?php echo ($filterType === 'store') ? 'selected' : ''; ?>>Cửa hàng</option>
                    <option value="time" <?php echo ($filterType === 'time') ? 'selected' : ''; ?>>Thời gian</option>
                </select>
            </div>
            <div class="col d-flex align-items-end">
                <button type="submit" class="btn btn-primary">Thống kê</button>
                <input type="hidden" name="action" value="thong-ke-doanh-thu">
                <button type="button" class="btn btn-secondary" onclick="resetForm()">Làm lại</button>
            </div>
        </div>
    </form>

    <!-- Biểu đồ -->
    <div class="mt-4">
        <?php if ($filterType === 'store') { ?>
        <table class="table table-bordered mt-4">
        <thead class="thead-light">
            <tr>
                <th scope="col">Tên Cửa Hàng</th>
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
                    echo "<td>" . htmlspecialchars($row["TenCuaHang"]) . "</td>";
                    echo "<td>" . number_format($row["DoanhThuDonHang"], 0, ',', '.') . " VNĐ</td>";
                    echo "<td>" . number_format($row["DoanhThuDatTiec"], 0, ',', '.') . " VNĐ</td>";
                    echo "<td>" . number_format($row["TongDoanhThu"], 0, ',', '.') . " VNĐ</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='4' class='text-center'>Không có dữ liệu</td></tr>";
            }
            ?>
            <!-- Hàng hiển thị tổng doanh thu -->
            <tr class="font-weight-bold">
                <td>Tổng cộng</td>
                <td><?php echo number_format($tongDoanhThuDonHang, 0, ',', '.') . " VNĐ"; ?></td>
                <td><?php echo number_format($tongDoanhThuDatTiec, 0, ',', '.') . " VNĐ"; ?></td>
                <td><?php echo number_format($tongDoanhThuTatCa, 0, ',', '.') . " VNĐ"; ?></td>
            </tr>
        </tbody>
    </table>
            <canvas id="storeSalesChart"></canvas>
        <?php } else { ?>
            <canvas id="timeSalesChart"></canvas>
        <?php } ?>
    </div>
</div>

<script>
    // Dữ liệu biểu đồ
    const chartData = <?php echo json_encode($chartData); ?>;
    const salesData = <?php echo json_encode($data); ?>;
    const labels = <?php echo json_encode($labels); ?>;
    const doanhThuDonHang = <?php echo json_encode($doanhThuDonHang); ?>;
    const doanhThuDatTiec = <?php echo json_encode($doanhThuDatTiec); ?>;

    // Vẽ biểu đồ doanh thu theo cửa hàng
    if (chartData.length > 0) {
        const ctx = document.getElementById('storeSalesChart').getContext('2d');
        const storeLabels = chartData.map(item => item.TenCuaHang);
        const dataDonHang = chartData.map(item => item.DoanhThuDonHang);
        const dataDatTiec = chartData.map(item => item.DoanhThuDatTiec);

        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: storeLabels,
                datasets: [
                    {
                        label: 'Doanh Thu Đơn Hàng (VNĐ)',
                        data: dataDonHang,
                        backgroundColor: 'rgba(54, 162, 235, 0.6)',
                        borderColor: 'rgba(54, 162, 235, 1)',
                        borderWidth: 1
                    },
                    {
                        label: 'Doanh Thu Đặt Tiệc (VNĐ)',
                        data: dataDatTiec,
                        backgroundColor: 'rgba(255, 99, 132, 0.6)',
                        borderColor: 'rgba(255, 99, 132, 1)',
                        borderWidth: 1
                    }
                ]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: 'Doanh thu (VNĐ)'
                        }
                    }
                }
            }
        });
    }

    // Vẽ biểu đồ doanh thu theo thời gian
    if (salesData.length > 0) {
        const ctx = document.getElementById('timeSalesChart').getContext('2d');

        new Chart(ctx, {
            type: 'line',
            data: {
                labels: labels,
                datasets: [
                    {
                        label: 'Doanh thu từ đơn hàng (VNĐ)',
                        data: doanhThuDonHang,
                        backgroundColor: 'rgba(54, 162, 235, 0.6)',
                        borderColor: 'rgba(54, 162, 235, 1)',
                        borderWidth: 1,
                        fill: false
                    },
                    {
                        label: 'Doanh thu từ đặt tiệc (VNĐ)',
                        data: doanhThuDatTiec,
                        backgroundColor: 'rgba(255, 99, 132, 0.6)',
                        borderColor: 'rgba(255, 99, 132, 1)',
                        borderWidth: 1,
                        fill: false
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
                            text: 'Doanh thu (VNĐ)'
                        }
                    }
                }
            }
        });
    }

    // Hàm làm mới form
    function resetForm() {
        const form = document.getElementById('filterForm');
        if (form) {
            form.reset(); // Reset tất cả các trường trong form
        }
        // Đặt lại các giá trị mặc định
        document.getElementById('start_date').value = '';
        document.getElementById('end_date').value = '';
        document.getElementById('filter_type').selectedIndex = 0; // Đặt về mục đầu tiên
    }

</script>

</body>
</html>

