<?php
// Kết nối cơ sở dữ liệu
$servername = "localhost";
$username = "root";
$password = "";
$database = "db_beekeeper_10";

$conn = new mysqli($servername, $username, $password, $database);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Lấy ID đơn tiệc từ URL (không cần ID_CuaHang nữa)
$idDonTiec = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Kiểm tra xem đơn tiệc có tồn tại không
$sqlCheckOrder = "SELECT * FROM dontiec WHERE ID_DatTiec = $idDonTiec";
$resultCheckOrder = $conn->query($sqlCheckOrder);

if ($resultCheckOrder->num_rows == 0) {
    die("Đơn tiệc không tồn tại.");
}

// Hàm để lấy danh sách món ăn từ CSDL
function getMonAn($conn) {
    $sql = "SELECT ID_MonAn, TenMonAn FROM monan WHERE TinhTrang = 0";
    $result = $conn->query($sql);
    $monAn = [];
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $monAn[$row['ID_MonAn']] = $row['TenMonAn'];
        }
    }
    return $monAn;
}

$monAn = getMonAn($conn);

// Lấy thông tin chi tiết đơn tiệc
$sql = "SELECT ct.ID_MonAn, m.TenMonAn, ct.SoLuong
        FROM chitietdattiec ct
        JOIN monan m ON ct.ID_MonAn = m.ID_MonAn
        WHERE ct.ID_DatTiec = $idDonTiec";
$result = $conn->query($sql);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chi tiết đơn tiệc #<?php echo $idDonTiec; ?></title>
    <link rel="stylesheet" href="../../asset/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h2>Chi tiết đơn tiệc #<?php echo $idDonTiec; ?></h2>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Tên món ăn</th>
                    <th>Số lượng</th>
                </tr>
            </thead>
            <tbody> 
                <?php
                if ($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                        $tenMonAn = htmlspecialchars($row["TenMonAn"]);
                        $soLuong = $row["SoLuong"];
                        echo "<tr>";
                        echo "<td>$tenMonAn</td>";
                        echo "<td>$soLuong</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='2'>Không có món ăn nào trong đơn tiệc này.</td></tr>";
                }
                ?>
            </tbody>
        </table>

        <a href="index.php?action=quan-ly-dat-tiec" class="btn btn-secondary mt-3">Quay lại</a>
    </div>

    <script src="../../asset/js/jquery.min.js"></script>
    <script src="../../asset/js/bootstrap.bundle.min.js"></script>
</body>
</html>
