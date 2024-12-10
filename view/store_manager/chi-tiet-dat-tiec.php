<?php
// Kết nối cơ sở dữ liệu
$servername = "localhost";
$username = "root";
$password = "";
$database = "db_beekeeper";

$conn = new mysqli($servername, $username, $password, $database);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Lấy ID đơn tiệc và ID cửa hàng từ URL
$idDonTiec = isset($_GET['id']) ? intval($_GET['id']) : 0;
$idCuaHang = isset($_GET['idCuaHang']) ? intval($_GET['idCuaHang']) : 0;

// Kiểm tra xem đơn tiệc có tồn tại không
$sqlCheckOrder = "SELECT * FROM dontiec WHERE ID_DatTiec = $idDonTiec AND ID_CuaHang = $idCuaHang";
$resultCheckOrder = $conn->query($sqlCheckOrder);

if ($resultCheckOrder->num_rows == 0) {
    die("$idDonTiec");
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

if (isset($_POST['update']) && isset($_POST['so_luong'])) {
    $idChiTiet = intval($_POST['id_chitiet']);
    $soLuong = intval($_POST['so_luong']);
    if ($soLuong > 0) {
        $sqlUpdate = "UPDATE chitietdattiec SET SoLuong = $soLuong WHERE ID_DatTiec = $idDonTiec AND ID_MonAn = $idChiTiet";
        if ($conn->query($sqlUpdate) === TRUE) {
            echo "<script>alert('Cập nhật thành công!'); window.location.href = window.location.href;</script>";
        } else {
            echo "<script>alert('Lỗi khi cập nhật: " . $conn->error . "');</script>";
        }
    } else {
        echo "<script>alert('Số lượng phải là số nguyên dương.');</script>";
    }
}

// Xử lý xóa món ăn
if (isset($_POST['delete'])) {
    $idChiTiet = intval($_POST['id_chitiet']);
    $sqlDelete = "DELETE FROM chitietdattiec WHERE ID_DatTiec = $idDonTiec AND ID_MonAn = $idChiTiet";
    if ($conn->query($sqlDelete) === TRUE) {
        echo "<script>alert('Xóa món ăn thành công!'); window.location.href = window.location.href;</script>";
    } else {
        echo "<script>alert('Lỗi khi xóa món ăn: " . $conn->error . "');</script>";
    }
}

// Xử lý thêm món ăn mới
if (isset($_POST['add'])) {
    $idMonAn = intval($_POST['id_mon_an']);
    $soLuong = intval($_POST['so_luong_moi']);
    if ($soLuong > 0) {
        // Lấy giá của món ăn
        $sqlGetPrice = "SELECT Gia FROM monan WHERE ID_MonAn = $idMonAn";
        $resultGetPrice = $conn->query($sqlGetPrice);
        $price = 0;
        if ($resultGetPrice->num_rows > 0) {
            $row = $resultGetPrice->fetch_assoc();
            $price = $row['Gia'];
        }
         
        // Kiểm tra xem món ăn đã tồn tại trong đơn tiệc chưa
        $sqlCheck = "SELECT * FROM chitietdattiec WHERE ID_DatTiec = $idDonTiec AND ID_MonAn = $idMonAn";
        $resultCheck = $conn->query($sqlCheck);
        if ($resultCheck->num_rows > 0) {
            echo "<script>alert('Món ăn này đã có trong đơn tiệc. Vui lòng cập nhật số lượng.');</script>";
        } else {
            $sqlInsert = "INSERT INTO chitietdattiec (ID_DatTiec, ID_MonAn, SoLuong, Gia) VALUES ($idDonTiec, $idMonAn, $soLuong, $price)";
            if ($conn->query($sqlInsert) === TRUE) {
                echo "<script>alert('Thêm món ăn mới thành công!'); window.location.href = window.location.href;</script>";
            } else {
                echo "<script>alert('Lỗi khi thêm món ăn mới: " . $conn->error . "');</script>";
            }
        }
    } else {
        echo "<script>alert('Số lượng phải là số nguyên dương.');</script>";
    }
}

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
    <script>
        // Hàm kiểm tra xem số lượng đã thay đổi chưa
        function checkUpdateButton(idMonAn, currentQty) {
            var inputQty = document.getElementById('so_luong_' + idMonAn).value;
            var updateButton = document.getElementById('update_' + idMonAn);
            if (inputQty == currentQty) {
                updateButton.disabled = true;
                updateButton.style.backgroundColor = '#007bff'; // Màu xám
            } else {
                updateButton.disabled = false;
                updateButton.style.backgroundColor = '#007bff';
            }
        }
    </script>
</head>
<body>
    <div class="container mt-5">
        <h2>Chi tiết đơn tiệc #<?php echo $idDonTiec; ?></h2>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Tên món ăn</th>
                    <th>Số lượng</th>
                    <th>Thao tác</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                        $idMonAn = $row["ID_MonAn"];
                        $tenMonAn = htmlspecialchars($row["TenMonAn"]);
                        $soLuong = $row["SoLuong"];
                        echo "<tr>";
                        echo "<td>$tenMonAn</td>";
                        echo "<form method='post'> 
                                <td><input type='number' id='so_luong_$idMonAn' name='so_luong' value='$soLuong' class='form-control' min='1' required onchange='checkUpdateButton($idMonAn, $soLuong)'></td>
                                <td>
                                    <input type='hidden' name='id_chitiet' value='$idMonAn'>
                                    <button type='submit' name='update' id='update_$idMonAn' class='btn btn-primary' disabled>Cập nhật</button>
                                    <button type='submit' name='delete' class='btn btn-danger' onclick='return confirm(\"Bạn có chắc chắn muốn xóa món ăn này?\")'>Xóa</button>
                                </td>
                            </form>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='3'>Không có món ăn nào trong đơn tiệc này.</td></tr>";
                }
                ?>
            </tbody>

        </table>

        <h3 class="mt-4">Thêm món ăn mới</h3>
        <form method="post" class="form-inline">
            <select name="id_mon_an" class="form-control mr-2" required>
                <option value="">Chọn món ăn</option>
                <?php
                foreach ($monAn as $id => $ten) {
                    echo "<option value='" . $id . "'>" . htmlspecialchars($ten) . "</option>";
                }
                ?>
            </select>
            <input type="number" name="so_luong_moi" placeholder="Số lượng" min="1" class="form-control mr-2" required>
            <button type="submit" name="add" class="btn btn-success">Thêm món ăn</button>
        </form>

        <a href="index.php?action=quan-ly-dat-tiec" class="btn btn-secondary mt-3">Quay lại</a>
    </div>

    <script src="../../asset/js/jquery.min.js"></script>
    <script src="../../asset/js/bootstrap.bundle.min.js"></script>
</body>
</html>
