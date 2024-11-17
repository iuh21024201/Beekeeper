<?php
include_once("../../model/ketnoi.php");
$p = new clsketnoi();
$conn = $p->moKetNoi();
if($conn){
    // Truy vấn để lấy tên cửa hàng và doanh thu
    $sql = "SELECT ch.TenCuaHang, 
               IFNULL(dh_tong.DoanhThuDonHang, 0) AS DoanhThuDonHang,
               IFNULL(dt_tong.DoanhThuDatTiec, 0) AS DoanhThuDatTiec,
               (IFNULL(dh_tong.DoanhThuDonHang, 0) + IFNULL(dt_tong.DoanhThuDatTiec, 0)) AS TongDoanhThu
                FROM CuaHang ch
                LEFT JOIN (
                    SELECT dh.ID_CuaHang, SUM(ct.Soluong * m.Gia) AS DoanhThuDonHang
                    FROM DonHang dh
                    JOIN ChiTietDonHang ct ON dh.ID_DonHang = ct.ID_DonHang
                    JOIN MonAn m ON ct.ID_MonAn = m.ID_MonAn
                    GROUP BY dh.ID_CuaHang
                ) dh_tong ON ch.ID_CuaHang = dh_tong.ID_CuaHang
                LEFT JOIN (
                    SELECT dt.ID_CuaHang, SUM(ctdt.SoLuong * m.Gia) AS DoanhThuDatTiec
                    FROM DonTiec dt
                    JOIN ChiTietDatTiec ctdt ON dt.ID_DatTiec = ctdt.ID_DatTiec
                    JOIN MonAn m ON ctdt.ID_MonAn = m.ID_MonAn
                    GROUP BY dt.ID_CuaHang
                ) dt_tong ON ch.ID_CuaHang = dt_tong.ID_CuaHang
                GROUP BY ch.TenCuaHang
                ORDER BY TongDoanhThu DESC";
    $result = $conn->query($sql); 
}


// Lưu dữ liệu vào mảng để hiển thị bảng và biểu đồ
$data = [];
while ($row = $result->fetch_assoc()) {
    $data[] = [
        "TenCuaHang" => $row["TenCuaHang"],
        "DoanhThuDonHang" => $row["DoanhThuDonHang"],
        "DoanhThuDatTiec" => $row["DoanhThuDatTiec"],
        "TongDoanhThu" => $row["TongDoanhThu"]
    ];
}
$conn->close();


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Thống kê doanh thu</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link rel="stylesheet" href="../../asset/css/bootstrap.min.css">
</head>
<body>
<div class="container">
    <h2 class="mt-4">Thống kê doanh thu theo cửa hàng</h2>

    <!-- Bảng hiển thị doanh thu -->
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
            if (!empty($data)) {
                foreach ($data as $row) {
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
        </tbody>
    </table>

    <!-- Biểu đồ -->
    <canvas id="revenueChart" width="800" height="400"></canvas>
</div>

<script>
    // Lấy dữ liệu từ PHP
    const chartData = <?php echo json_encode($data); ?>;

    // Tạo mảng dữ liệu cho biểu đồ
    const labels = chartData.map(item => item.TenCuaHang);
    const dataDonHang = chartData.map(item => item.DoanhThuDonHang);
    const dataDatTiec = chartData.map(item => item.DoanhThuDatTiec);

    // Cấu hình biểu đồ
    const ctx = document.getElementById('revenueChart').getContext('2d');
    const revenueChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: labels,
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
            plugins: {
                legend: {
                    position: 'top',
                },
                title: {
                    display: true,
                    text: 'Thống kê doanh thu theo cửa hàng'
                }
            },
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
</script>

</body>
</html>
