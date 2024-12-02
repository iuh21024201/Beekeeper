<?php
// Kết nối cơ sở dữ liệu
$servername = "localhost";
$username = "root";
$password = "";
$database = "db_beekeeper_8"; 

$conn = new mysqli($servername, $username, $password, $database);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Thông báo kết quả
$successMessage = '';
$errorMessage = ''; // Biến để lưu thông báo lỗi

if (isset($_POST['update'])) {
    $id = $_POST['id'];
    $gioHen = $_POST['gioHen'];
    $soNguoi = $_POST['soNguoi'];
    $tongTien = $_POST['tongTien'];
    $tienCoc = $_POST['tienCoc'];
    $tienConLai = $_POST['tienConLai'];
    $ghiChu = $_POST['ghiChu'];

    // Thực hiện câu lệnh cập nhật
    $sqlUpdate = "UPDATE DonTiec SET 
                  GioHen = '$gioHen', 
                  SoNguoi = '$soNguoi', 
                  TongTien = '$tongTien', 
                  TienCoc = '$tienCoc', 
                  TienConLai = '$tienConLai', 
                  GhiChu = '$ghiChu' 
                  WHERE ID_DatTiec = '$id'";

    if ($conn->query($sqlUpdate) === TRUE) {
        $successMessage = "Cập nhật thành công!";
    } else {
        $errorMessage = "Lỗi cập nhật: " . $conn->error; // Lấy thông báo lỗi nếu có
    }
}

// Xử lý xóa đơn tiệc (thay đổi trạng thái về 0)
if (isset($_POST['delete'])) {
    $id = $_POST['id'];
    $sqlDelete = "UPDATE DonTiec SET TrangThai = 0 WHERE ID_DatTiec = '$id'";
    $conn->query($sqlDelete);
}

// Xử lý lọc dữ liệu
$whereClauses = [];
if (isset($_POST['filter'])) {
    $filterDate = $_POST['filterDate'];
    $filterGuests = $_POST['filterGuests'];
    $searchTerm = $_POST['searchTerm'];

    if (!empty($filterDate)) {
        $whereClauses[] = "DATE_FORMAT(dt.GioHen, '%Y-%m') = '$filterDate'";
    }
    if (!empty($filterGuests)) {
        $whereClauses[] = "dt.SoNguoi >= '$filterGuests'";
    }
    if (!empty($searchTerm)) {
        $whereClauses[] = "kh.HoTen LIKE '%$searchTerm%'";
    }
}

$sql = "SELECT dt.ID_DatTiec, kh.HoTen, dt.ID_CuaHang, dt.GioHen, lt.TenTrangTri, dt.SoNguoi, dt.TongTien, dt.TienCoc, dt.TienConLai, dt.GhiChu, dt.TrangThai 
        FROM DonTiec dt
        JOIN khachhang kh ON dt.ID_KhachHang = kh.ID_KhachHang
        JOIN loaitrangtri lt ON dt.ID_LoaiTrangTri = lt.ID_LoaiTrangTri
        JOIN cuahang ch ON dt.ID_CuaHang = ch.ID_CuaHang";

if (!empty($whereClauses)) {
    $sql .= " WHERE " . implode(" AND ", $whereClauses);
}
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Quản lý đặt tiệc</title>
    <link rel="stylesheet" href="../../asset/css/bootstrap.min.css">
</head>
<body>
<div class="container">
    <h2 class="mt-4">Quản lý đặt tiệc</h2>

    <?php if ($successMessage): ?>
        <div class="alert alert-success">
            <?php echo $successMessage; ?>
        </div>
    <?php endif; ?>

    <?php if ($errorMessage): ?>
        <div class="alert alert-danger">
            <?php echo $errorMessage; ?>
        </div>
    <?php endif; ?>

    <!-- Form lọc đơn tiệc -->
    <form method="POST" class="form-inline mb-4">
        <label class="mr-2">Tháng:</label>
        <input type="month" name="filterDate" class="form-control mr-2" value="<?php echo isset($_POST['filterDate']) ? htmlspecialchars($_POST['filterDate']) : ''; ?>">

        <label class="mr-2">Số người tối thiểu:</label>
        <input type="number" name="filterGuests" class="form-control mr-2" value="<?php echo isset($_POST['filterGuests']) ? htmlspecialchars($_POST['filterGuests']) : ''; ?>">

        <label class="mr-2">Tìm kiếm:</label>
        <input type="text" name="searchTerm" class="form-control mr-2" placeholder="Nhập tên khách hàng" value="<?php echo isset($_POST['searchTerm']) ? htmlspecialchars($_POST['searchTerm']) : ''; ?>">

        <button type="submit" name="filter" class="btn btn-primary">Lọc</button>
    </form>

    <!-- Bảng danh sách đơn tiệc -->
    <table class="table table-bordered mt-4">
        <thead class="thead-light">
            <tr>
                <th>Tên Khách Hàng</th>
                <th>ID Cửa Hàng</th>
                <th>Giờ Hẹn</th>
                <th>Trang Trí</th>
                <th>Số Người</th>
                <th>Tổng Tiền</th>
                <th>Tiền Cọc</th>
                <th>Tiền Còn Lại</th>
                <th>Ghi Chú</th>
                <th>Trạng Thái</th>
                <th>Hành Động</th>
            </tr>
        </thead>
        <tbody>
        <?php
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . htmlspecialchars($row["HoTen"]) . "</td>";
                echo "<td>" . htmlspecialchars($row["ID_CuaHang"]) . "</td>";
                echo "<td>" . htmlspecialchars($row["GioHen"]) . "</td>";
                echo "<td>" . htmlspecialchars($row["TenTrangTri"]) . "</td>"; 
                echo "<td>" . htmlspecialchars($row["SoNguoi"]) . "</td>";
                echo "<td>" . htmlspecialchars($row["TongTien"]) . "</td>";
                echo "<td>" . htmlspecialchars($row["TienCoc"]) . "</td>";
                echo "<td>" . htmlspecialchars($row["TienConLai"]) . "</td>";
                echo "<td>" . htmlspecialchars($row["GhiChu"]) . "</td>";
                echo "<td>" . ($row["TrangThai"] == 0 ? "Đã Hủy" : "Chưa hoàn thành") . "</td>";
                echo "<td>
                        <button class='btn btn-warning' data-toggle='modal' data-target='#editModal" . $row['ID_DatTiec'] . "'>Sửa</button>
                        <button class='btn btn-danger' onclick='confirmDelete(" . $row['ID_DatTiec'] . ")'>Xóa</button>
                        <form id='deleteForm" . $row['ID_DatTiec'] . "' method='POST' action='' style='display:none;'>
                            <input type='hidden' name='id' value='" . $row['ID_DatTiec'] . "'>
                            <input type='hidden' name='delete'>
                        </form>
                      </td>";
                echo "</tr>";

                // Modal cho chỉnh sửa
                echo "<div class='modal fade' id='editModal" . $row['ID_DatTiec'] . "' tabindex='-1' role='dialog' aria-labelledby='editModalLabel" . $row['ID_DatTiec'] . "' aria-hidden='true'>
                        <div class='modal-dialog' role='document'>
                            <div class='modal-content'>
                                <div class='modal-header'>
                                    <h5 class='modal-title' id='editModalLabel" . $row['ID_DatTiec'] . "'>Chỉnh sửa Đơn Tiệc</h5>
                                    <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                                        <span aria-hidden='true'>&times;</span>
                                    </button>
                                </div>
                                <div class='modal-body'>
                                    <form method='POST' action=''>
                                        <input type='hidden' name='id' value='" . $row['ID_DatTiec'] . "'>
                                        <div class='form-group'>
                                            <label for='gioHen'>Giờ Hẹn</label>
                                            <input type='datetime-local' class='form-control' name='gioHen' value='" . htmlspecialchars($row['GioHen']) . "'>
                                        </div>
                                        <div class='form-group'>
                                            <label for='trangTri'>Trang trí</label>
                                            <input type='text' class='form-control' name='trangTri' value='" . htmlspecialchars($row['TenTrangTri']) . "'disabled>
                                        </div>
                                        <div class='form-group'>
                                            <label for='soNguoi'>Số Người</label>
                                            <input type='number' class='form-control' name='soNguoi' value='" . htmlspecialchars($row['SoNguoi']) . "'>
                                        </div>
                                        <div class='form-group'>
                                            <label for='tongTien'>Tổng Tiền</label>
                                            <input type='number' class='form-control' name='tongTien' value='" . htmlspecialchars($row['TongTien']) . "'>
                                        </div>
                                        <div class='form-group'>
                                            <label for='tienCoc'>Tiền Cọc</label>
                                            <input type='number' class='form-control' name='tienCoc' value='" . htmlspecialchars($row['TienCoc']) . "'>
                                        </div>
                                        <div class='form-group'>
                                            <label for='tienConLai'>Tiền Còn Lại</label>
                                            <input type='number' class='form-control' name='tienConLai' value='" . htmlspecialchars($row['TienConLai']) . "'>
                                        </div>
                                        <div class='form-group'>
                                            <label for='ghiChu'>Ghi Chú</label>
                                            <textarea class='form-control' name='ghiChu'>" . htmlspecialchars($row['GhiChu']) . "</textarea>
                                        </div>
                                        <button type='submit' name='update' class='btn btn-primary'>Cập nhật</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                      </div>";
            }
        } else {
            echo "<tr><td colspan='11' class='text-center'>Không có dữ liệu</td></tr>";
        }
        ?>
        </tbody>
    </table>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>

<script>
// Hàm xác nhận xóa
function confirmDelete(id) {
    if (confirm("Bạn chắc chắn muốn xóa đơn đặt tiệc này?")) {
        document.getElementById('deleteForm' + id).submit();
    }
}
</script>
</body>
</html>
