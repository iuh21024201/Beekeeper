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

// Thông báo kết quả
$successMessage = '';
if (isset($_POST['update'])) {
    $id = $_POST['id'];
    $gioHen = $_POST['gioHen'];
    $trangTri = $_POST['trangTri'];
    $soNguoi = $_POST['soNguoi'];
    $tongTien = $_POST['tongTien'];
    $tienCoc = $_POST['tienCoc'];
    $tienConLai = $_POST['tienConLai'];
    $ghiChu = $_POST['ghiChu'];

    $sqlUpdate = "UPDATE DonTiec SET 
                  GioHen = '$gioHen', 
                  TrangTri = '$trangTri', 
                  SoNguoi = '$soNguoi', 
                  TongTien = '$tongTien', 
                  TienCoc = '$tienCoc', 
                  TienConLai = '$tienConLai', 
                  GhiChu = '$ghiChu' 
                  WHERE ID_DatTiec = '$id'";
    if ($conn->query(query: $sqlUpdate) === TRUE) {
        $successMessage = "<script>alert('Cập nhật thành công!')</script>";
    }
}

// Xử lý xóa đơn tiệc (thay đổi trạng thái về 0)
if (isset($_POST['delete'])) {
    $id = $_POST['id'];
    $sqlDelete = "UPDATE DonTiec SET TrangThai = 0 WHERE ID_DatTiec = '$id'";
    $conn->query(query: $sqlDelete);
}

// Xử lý lọc dữ liệu
$whereClauses = [];
if (isset($_POST['filter'])) {
    $filterDate = $_POST['filterDate'];
    $filterGuests = $_POST['filterGuests'];
    $searchTerm = $_POST['searchTerm'];

    if (!empty($filterDate)) {
        $whereClauses[] = "DATE_FORMAT(GioHen, '%Y-%m') = '$filterDate'";
    }
    if (!empty($filterGuests)) {
        $whereClauses[] = "SoNguoi >= '$filterGuests'";
    }
    if (!empty($searchTerm)) {
        $whereClauses[] = "ID_KhachHang = '$searchTerm'";
    }
}

$sql = "SELECT ID_DatTiec, ID_KhachHang, ID_CuaHang, GioHen, TrangTri, SoNguoi, TongTien, TienCoc, TienConLai, GhiChu, TrangThai FROM DonTiec";
if (!empty($whereClauses)) {
    $sql .= " WHERE " . implode(separator: " AND ", array: $whereClauses);
}
$result = $conn->query(query: $sql);
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

    <!-- Form lọc đơn tiệc -->
    <form method="POST" class="form-inline mb-4">
        <label class="mr-2">Tháng:</label>
        <input type="month" name="filterDate" class="form-control mr-2" value="<?php echo isset($_POST['filterDate']) ? htmlspecialchars($_POST['filterDate']) : ''; ?>">

        <label class="mr-2">Số người tối thiểu:</label>
        <input type="number" name="filterGuests" class="form-control mr-2" value="<?php echo isset($_POST['filterGuests']) ? htmlspecialchars($_POST['filterGuests']) : ''; ?>">

        <label class="mr-2">Tìm kiếm:</label>
        <input type="text" name="searchTerm" class="form-control mr-2" placeholder="Nhập ID Khách hàng" value="<?php echo isset($_POST['searchTerm']) ? htmlspecialchars($_POST['searchTerm']) : ''; ?>">

        <button type="submit" name="filter" class="btn btn-primary">Lọc</button>
    </form>

    <!-- Bảng danh sách đơn tiệc -->
    <table class="table table-bordered mt-4">
        <thead class="thead-light">
            <tr>
                <th>ID Đặt Tiệc</th>
                <th>ID Khách Hàng</th>
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
                echo "<td>" . htmlspecialchars(string: $row["ID_DatTiec"]) . "</td>";
                echo "<td>" . htmlspecialchars(string: $row["ID_KhachHang"]) . "</td>";
                echo "<td>" . htmlspecialchars(string: $row["ID_CuaHang"]) . "</td>";
                echo "<td>" . htmlspecialchars(string: $row["GioHen"]) . "</td>";
                echo "<td>" . htmlspecialchars(string: $row["TrangTri"]) . "</td>";
                echo "<td>" . htmlspecialchars(string: $row["SoNguoi"]) . "</td>";
                echo "<td>" . htmlspecialchars(string: $row["TongTien"]) . "</td>";
                echo "<td>" . htmlspecialchars(string: $row["TienCoc"]) . "</td>";
                echo "<td>" . htmlspecialchars(string: $row["TienConLai"]) . "</td>";
                echo "<td>" . htmlspecialchars(string: $row["GhiChu"]) . "</td>";
                echo "<td>" . htmlspecialchars(string: $row["TrangThai"]) . "</td>";
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
                                    <h5 class='modal-title' id='editModalLabel" . $row['ID_DatTiec'] . "'>Chỉnh sửa đơn tiệc</h5>
                                    <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                                        <span aria-hidden='true'>&times;</span>
                                    </button>
                                </div>
                                <form method='POST' action=''>
                                    <div class='modal-body'>
                                        <input type='hidden' name='id' value='" . $row['ID_DatTiec'] . "'>
                                        <div class='form-group'>
                                            <label for='gioHen'>Giờ Hẹn</label>
                                            <input type='datetime-local' class='form-control' name='gioHen' value='" . date('Y-m-d\TH:i', strtotime($row['GioHen'])) . "' required>
                                        </div>
                                        <div class='form-group'>
                                            <label for='trangTri'>Trang Trí</label>
                                            <input type='text' class='form-control' name='trangTri' value='" . htmlspecialchars($row['TrangTri']) . "'>
                                        </div>
                                        <div class='form-group'>
                                            <label for='soNguoi'>Số Người</label>
                                            <input type='number' class='form-control' name='soNguoi' value='" . htmlspecialchars($row['SoNguoi']) . "' required>
                                        </div>
                                        <div class='form-group'>
                                            <label for='tongTien'>Tổng Tiền</label>
                                            <input type='number' class='form-control' name='tongTien' value='" . htmlspecialchars($row['TongTien']) . "' required>
                                        </div>
                                        <div class='form-group'>
                                            <label for='tienCoc'>Tiền Cọc</label>
                                            <input type='number' class='form-control' name='tienCoc' value='" . htmlspecialchars($row['TienCoc']) . "' required>
                                        </div>
                                        <div class='form-group'>
                                            <label for='tienConLai'>Tiền Còn Lại</label>
                                            <input type='number' class='form-control' name='tienConLai' value='" . htmlspecialchars($row['TienConLai']) . "' required>
                                        </div>
                                        <div class='form-group'>
                                            <label for='ghiChu'>Ghi Chú</label>
                                            <textarea class='form-control' name='ghiChu'>" . htmlspecialchars($row['GhiChu']) . "</textarea>
                                        </div>
                                    </div>
                                    <div class='modal-footer'>
                                        <button type='button' class='btn btn-secondary' data-dismiss='modal'>Đóng</button>
                                        <button type='submit' name='update' class='btn btn-primary'>Lưu</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                      </div>";
            }
        } else {
            echo "<tr><td colspan='12' class='text-center'>Không có kết quả phù hợp</td></tr>";
        }
        ?>
        </tbody>
    </table>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
function confirmDelete(id) {
    if (confirm('Bạn có chắc chắn muốn xóa đơn tiệc này không?')) {
        document.getElementById('deleteForm' + id).submit();
    }
}
</script>
</body>
</html>
