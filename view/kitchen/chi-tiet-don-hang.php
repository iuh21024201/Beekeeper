<?php
include_once("../../controller/cChiTietDonHang.php");
include_once("../../controller/cDonHang.php");
include_once("../../controller/cNguyenLieu.php");

$donHangController = new controlDonHang();
$nguyenLieuController = new controlNguyenLieu();
$chiTietController = new controlCTDonHang();

// Kiểm tra và lấy giá trị ID cửa hàng và ID đơn hàng từ URL
if (isset($_GET['id']) && isset($_GET['idCuaHang'])) {
    $idDonHang = $_GET['id'];
    $idCuaHang = $_GET['idCuaHang'];
} else {
    die("Lỗi: Thiếu ID đơn hàng hoặc ID cửa hàng.");
}

// Lấy chi tiết đơn hàng từ controller
$chiTietDonHang = $chiTietController->getCTDHForKitchen($idDonHang);

$statusUpdated = false;
$ingredientsUpdated = false;

// Kiểm tra phương thức POST để xử lý khi nhấn nút "Đang chế biến"
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_status'])) {
    $statusUpdated = $donHangController->updateOrderStatusToPrepare($idDonHang); // Cập nhật trạng thái đơn hàng
    $ingredientsUpdated = $nguyenLieuController->updateIngredientsStock($idDonHang, $idCuaHang); // Trừ nguyên liệu

    if ($statusUpdated && $ingredientsUpdated) {
        echo "<script>alert('Cập nhật trạng thái và trừ nguyên liệu thành công!');</script>";
    } elseif ($statusUpdated) {
        echo "<script>alert('Cập nhật trạng thái thành công, nhưng không có nguyên liệu nào được trừ.');</script>";
    } else {
        echo "<script>alert('Lỗi: Không thể cập nhật trạng thái hoặc trừ nguyên liệu.');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chi Tiết Đơn Hàng</title>
    <link rel="stylesheet" href="../../asset/css/bootstrap.min.css">
</head>
<body>
<div class="container mt-4">
    <h2>Chi Tiết Đơn Hàng</h2>

    <!-- Thông báo trạng thái -->
    <?php if ($statusUpdated && $ingredientsUpdated): ?>
        <div class="alert alert-success">Trạng thái đã được cập nhật thành "Đang chế biến". Số lượng nguyên liệu đã được trừ.</div>
    <?php elseif ($statusUpdated): ?>
        <div class="alert alert-warning">Trạng thái đã được cập nhật thành "Đang chế biến", nhưng không có nguyên liệu nào được trừ.</div>
    <?php elseif ($_SERVER['REQUEST_METHOD'] === 'POST'): ?>
        <div class="alert alert-danger">Lỗi: Không thể cập nhật trạng thái hoặc trừ nguyên liệu.</div>
    <?php endif; ?>

    <!-- Hiển thị chi tiết đơn hàng -->
    <table class="table table-bordered table-hover">
        <thead class="thead-dark">
            <tr>
                <th>Tên Món Ăn</th>
                <th>Hình Ảnh</th>
                <th>Số Lượng</th>
                <th>Ghi Chú</th>
                <th>Công thức</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($chiTietDonHang): ?>
                <?php while ($row = $chiTietDonHang->fetch_assoc()): ?>
                    <tr>
                        <td><?= htmlspecialchars($row['TenMonAn']) ?></td>
                        <td><img src="../../image/monan/<?= htmlspecialchars($row['HinhAnh']) ?>" width="100px"></td>
                        <td><?= intval($row['SoLuong']) ?></td>
                        <td><?= htmlspecialchars($row['Ghichu']) ?></td>
                        <td><?= htmlspecialchars($row['CongThuc']) ?></td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr><td colspan="5">Không có chi tiết đơn hàng.</td></tr>
            <?php endif; ?>
        </tbody>
    </table>

    <!-- Nút hành động -->
    <div class="mt-4">
        <a href="index.php?action=xem-don-hang" class="btn btn-secondary">Quay lại</a>

        <form method="POST" style="display:inline;">
            <button type="submit" name="update_status" class="btn btn-primary">Đang chế biến</button>
        </form>
    </div>
</div>
</body>
</html>
