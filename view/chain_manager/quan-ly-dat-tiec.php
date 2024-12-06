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
$errorMessage = '';

// Xử lý cập nhật đơn tiệc
if (isset($_POST['update'])) {
    $id = $_POST['id'];
    $gioHen = $_POST['gioHen'];
    $soNguoi = $_POST['soNguoi'];
    $ghiChu = $_POST['ghiChu'];
    $idLoaiTrangTri = $_POST['idLoaiTrangTri'];

    $sqlUpdate = "UPDATE DonTiec SET 
                  GioHen = '$gioHen', 
                  SoNguoi = '$soNguoi', 
                  GhiChu = '$ghiChu', 
                  ID_LoaiTrangTri = '$idLoaiTrangTri'
                  WHERE ID_DatTiec = '$id'";

    if ($conn->query($sqlUpdate) === TRUE) {
        $successMessage = "Cập nhật thành công!";
    } else {
        $errorMessage = "Lỗi cập nhật: " . $conn->error;
    }
}

// Xử lý trạng thái Thanh toán
if (isset($_POST['pay'])) {
    $id = $_POST['id'];
    $sqlPay = "UPDATE DonTiec SET TrangThai = 2 WHERE ID_DatTiec = '$id'";

    if ($conn->query($sqlPay) === TRUE) {
        $successMessage = "Đơn tiệc đã được chuyển sang trạng thái Đã Thanh Toán!";
    } else {
        $errorMessage = "Lỗi cập nhật trạng thái: " . $conn->error;
    }
}

// Xử lý trạng thái Hoàn thành
if (isset($_POST['complete'])) {
    $id = $_POST['id'];
    $sqlComplete = "UPDATE DonTiec SET TrangThai = 3 WHERE ID_DatTiec = '$id'";

    if ($conn->query($sqlComplete) === TRUE) {
        $successMessage = "Đơn tiệc đã được chuyển sang trạng thái Đã Hoàn Thành!";
    } else {
        $errorMessage = "Lỗi cập nhật trạng thái: " . $conn->error;
    }
}


// Xử lý hủy đơn
if (isset($_POST['cancel'])) {
    $id = $_POST['id'];
    $sqlCancel = "UPDATE DonTiec SET TrangThai = 0 WHERE ID_DatTiec = '$id'";

    if ($conn->query($sqlCancel) === TRUE) {
        $successMessage = "Hủy đơn thành công!";
    } else {
        $errorMessage = "Lỗi hủy đơn: " . $conn->error;
    }
}

// Xử lý lọc dữ liệu
$whereClauses = [];
if (isset($_POST['filter'])) {
    $filterDate = $_POST['filterDate'];
    $filterGuests = $_POST['filterGuests'];
    $searchTerm = $_POST['searchTerm'];
    $filterStatus = $_POST['filterStatus'];

    if (!empty($filterDate)) {
        $whereClauses[] = "DATE_FORMAT(dt.GioHen, '%Y-%m') = '$filterDate'";
    }
    if (!empty($filterGuests)) {
        $whereClauses[] = "dt.SoNguoi >= '$filterGuests'";
    }
    if (!empty($searchTerm)) {
        $whereClauses[] = "kh.HoTen LIKE '%$searchTerm%'";
    }
    if ($filterStatus !== "") {
        $whereClauses[] = "dt.TrangThai = '$filterStatus'";
    }
}

// Truy vấn dữ liệu đơn tiệc
$sql = "SELECT 
            dt.ID_DatTiec, 
            kh.HoTen, 
            dt.GioHen, 
            lt.TenTrangTri, 
            lt.Gia AS GiaTrangTri,
            dt.SoNguoi, 
            dt.GhiChu, 
            dt.TrangThai, 
            SUM(ctdt.Gia * ctdt.SoLuong) AS TongChiTiet
        FROM DonTiec dt
        JOIN khachhang kh ON dt.ID_KhachHang = kh.ID_KhachHang
        JOIN chitietdattiec ctdt ON dt.ID_DatTiec = ctdt.ID_DatTiec
        JOIN loaitrangtri lt ON dt.ID_LoaiTrangTri = lt.ID_LoaiTrangTri";

if (!empty($whereClauses)) {
    $sql .= " WHERE " . implode(" AND ", $whereClauses);
}
$sql .= " GROUP BY dt.ID_DatTiec";

$result = $conn->query($sql);

// Lấy danh sách loại trang trí
$sqlLoaiTrangTri = "SELECT ID_LoaiTrangTri, TenTrangTri, Gia FROM loaitrangtri";
$resultLoaiTrangTri = $conn->query($sqlLoaiTrangTri);
$loaiTrangTri = [];
while ($rowLoaiTrangTri = $resultLoaiTrangTri->fetch_assoc()) {
    $loaiTrangTri[] = $rowLoaiTrangTri;
}
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

    <!-- Form lọc dữ liệu -->
    <form method="POST" class="mb-4">
        <div class="form-row">
            <div class="form-group col-md-3">
                <label for="filterDate">Tháng</label>
                <input type="month" class="form-control" name="filterDate" id="filterDate">
            </div>
            <div class="form-group col-md-3">
                <label for="filterGuests">Số người tối thiểu</label>
                <input type="number" class="form-control" name="filterGuests" id="filterGuests">
            </div>
            <div class="form-group col-md-3">
                <label for="searchTerm">Tên khách hàng</label>
                <input type="text" class="form-control" name="searchTerm" id="searchTerm">
            </div>
            <div class="form-group col-md-3">
                <label for="filterStatus">Trạng thái</label>
                <select class="form-control" name="filterStatus" id="filterStatus">
                    <option value="">Tất cả</option>
                    <option value="0">Đơn Hủy</option>
                    <option value="1">Đặt Thành Công</option>
                    <option value="2">Đã Thanh Toán</option>
                    <option value="3">Đã Hoàn Thành</option>
                </select>
            </div>
        </div>
        <button type="submit" name="filter" class="btn btn-primary">Lọc</button>
    </form>

    <!-- Bảng danh sách đơn tiệc -->
    <table class="table table-bordered">
        <thead class="thead-light">
            <tr>
                <th>Tên Khách Hàng</th>
                <th>Giờ Hẹn</th>
                <th>Trang Trí</th>
                <th>Số Người</th>
                <th>Tổng Tiền</th>
                <th>Ghi Chú</th>
                <th>Trạng Thái</th>
                <th>Hành Động</th>
            </tr>
        </thead>
        <tbody>
        <?php if ($result->num_rows > 0): ?>
            <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?= htmlspecialchars($row["HoTen"]) ?></td>
                    <td><?= htmlspecialchars($row["GioHen"]) ?></td>
                    <td><?= htmlspecialchars($row["TenTrangTri"]) ?></td>
                    <td><?= htmlspecialchars($row["SoNguoi"]) ?></td>
                    <td><?= number_format($row["TongChiTiet"] + $row["GiaTrangTri"], 0, ',', '.') ?> VND</td>
                    <td><?= htmlspecialchars($row["GhiChu"]) ?></td>
                    <td>
                        <?php if ($row["TrangThai"] == 0): ?>
                            <span class="badge badge-danger">Đã Hủy</span>
                        <?php elseif ($row["TrangThai"] == 1): ?>
                            <form method="POST" style="display:inline;" onsubmit="confirmAction(event, 'Bạn xác nhận khách hàng đã thanh toán?');">
                                <input type="hidden" name="id" value="<?= $row['ID_DatTiec'] ?>">
                                <button type="submit" name="pay" class="btn btn-success btn-sm">Thanh Toán</button>
                            </form>

                        <?php elseif ($row["TrangThai"] == 2): ?>
                            <form method="POST" style="display:inline;" onsubmit="confirmAction(event, 'Đơn tiệc này đã hoàn thành chưa?');">
                                <input type="hidden" name="id" value="<?= $row['ID_DatTiec'] ?>">
                                <button type="submit" name="complete" class="btn btn-primary btn-sm">Hoàn Thành</button>
                            </form>

                        <?php else: ?>
                            <span class="badge badge-success">Đã Hoàn Thành</span>
                        <?php endif; ?>
                    </td>

                    <td>
                        <!-- Kiểm tra trạng thái đơn tiệc -->
                        <?php if ($row["TrangThai"] == 0 || $row["TrangThai"] == 3): ?>
                            <!-- Nếu trạng thái là Đã Hủy hoặc Đã Hoàn Thành, không cho phép thao tác -->
                            <span style="font-size: 16px;">Không thể thao tác</span>
                        <?php else: ?>
                            <!-- Hiển thị nút Sửa và Hủy khi trạng thái là khác 0 và 3 -->
                            <button class="btn btn-warning" data-toggle="modal" data-target="#editModal<?= $row['ID_DatTiec'] ?>">Sửa</button>
                            <form method="POST" action="" style="display:inline;" onsubmit="return confirm('Bạn có chắc chắn muốn hủy đơn này không?');">
                                <input type="hidden" name="id" value="<?= $row['ID_DatTiec'] ?>">
                                <button type="submit" name="cancel" class="btn btn-danger">Hủy</button>
                            </form>
                        <?php endif; ?>
                    </td>
                </tr>
                <!-- Modal chỉnh sửa -->
                <div class="modal fade" id="editModal<?= $row['ID_DatTiec'] ?>" tabindex="-1">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Chỉnh sửa Đơn Tiệc</h5>
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                            </div>
                            <div class="modal-body">
                                <form method="POST" onsubmit="return confirm('Bạn có chắc chắn muốn cập nhật?');">
                                    <input type="hidden" name="id" value="<?= $row['ID_DatTiec'] ?>">
                                    <div class="form-group">
                                        <label>Giờ Hẹn</label>
                                        <input type="datetime-local" class="form-control" name="gioHen" value="<?= date('Y-m-d\TH:i:s', strtotime($row['GioHen'])) ?>">
                                    </div>
                                    <div class="form-group">
                                        <label>Loại Trang Trí</label>
                                        <select class="form-control" name="idLoaiTrangTri">
                                            <?php if (!empty($loaiTrangTri)) : ?>
                                                <?php foreach ($loaiTrangTri as $loai) : ?>
                                                    <option 
                                                        value="<?= htmlspecialchars($loai['ID_LoaiTrangTri'], ENT_QUOTES, 'UTF-8') ?>" 
                                                        <?= isset($row['ID_LoaiTrangTri']) && $row['ID_LoaiTrangTri'] == $loai['ID_LoaiTrangTri'] ? 'selected' : '' ?>
                                                    >
                                                        <?= htmlspecialchars($loai['TenTrangTri'], ENT_QUOTES, 'UTF-8') ?> 
                                                        (<?= number_format($loai['Gia'], 0, ',', '.') ?> VND)
                                                    </option>
                                                <?php endforeach; ?>
                                            <?php else : ?>
                                                <option value="">Không có loại trang trí nào</option>
                                            <?php endif; ?>
                                        </select>

                                    </div>
                                    <div class="form-group">
                                        <label>Số Người</label>
                                        <input type="number" class="form-control" name="soNguoi" value="<?= $row['SoNguoi'] ?>">
                                    </div>
                                    <div class="form-group">
                                        <label>Ghi Chú</label>
                                        <textarea class="form-control" name="ghiChu"><?= htmlspecialchars($row['GhiChu']) ?></textarea>
                                    </div>
                                    <button type="submit" name="update" class="btn btn-primary">Cập Nhật</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <tr><td colspan="8" class="text-center">Không có dữ liệu.</td></tr>
        <?php endif; ?>
        </tbody>
    </table>
</div>

<script>
    function confirmAction(event, message) {
        if (!confirm(message)) {
            event.preventDefault(); // Ngăn chặn form submit nếu không xác nhận
        }
    }
</script>

<script src="../../asset/js/jquery.min.js"></script>
<script src="../../asset/js/bootstrap.bundle.min.js"></script>
</body>
</html>
