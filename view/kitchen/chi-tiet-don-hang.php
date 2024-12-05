<?php
include_once("../../controller/cChiTietDonHang.php");
include_once("../../controller/cDonHang.php");
include_once("../../controller/cNguyenLieu.php");

$donHangController = new controlDonHang();
$nguyenLieuController = new controlNguyenLieu();
$chiTietController = new controlCTDonHang();

$idCuaHang = $_GET['idCuaHang'] ?? null; // Lấy ID cửa hàng
$idDonHang = $_GET['id'] ?? null; // Lấy ID đơn hàng từ URL
if (!$idDonHang) {
    die("ID đơn hàng không hợp lệ.");
}

$chiTietDonHang = $chiTietController->getCTDHForKitchen($idDonHang);


$statusUpdated = false;
$ingredientsUpdated = false;
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_status'])) {
    // Cập nhật trạng thái đơn hàng
    $statusUpdated = $donHangController->updateOrderStatusToPrepare($idDonHang);

    // Trừ nguyên liệu trong kho
    $ingredientsUpdated = $nguyenLieuController->updateIngredientsStock($idDonHang, $idCuaHang);
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

    <?php if ($statusUpdated && $ingredientsUpdated): ?>
        <div class="alert alert-success">Trạng thái đã được cập nhật thành "Đang chế biến". Số lượng nguyên liệu đã được trừ.</div>
    <?php elseif ($statusUpdated): ?>
        <div class="alert alert-warning">Trạng thái đã được cập nhật thành "Đang chế biến", nhưng không có nguyên liệu nào được trừ.</div>
    <?php endif; ?>

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
                        <td><?= $row['TenMonAn'] ?></td>
                        <td><img src="../../image/monan/<?= $row['HinhAnh'] ?>" width="100px"></td>
                        <td><?= $row['SoLuong'] ?></td>
                        <td><?= $row['Ghichu'] ?></td>
                        <td><?= $row['CongThuc'] ?></td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr><td colspan="5">Không có chi tiết đơn hàng.</td></tr>
            <?php endif; ?>
        </tbody>
    </table>

    <div class="mt-4">
        <a href="index.php?action=xem-don-hang" class="btn btn-secondary">Quay lại</a>

        <form method="POST" style="display:inline;">
            <button type="submit" name="update_status" class="btn btn-primary">Đang chế biến</button>
        </form>
    </div>
</div>
</body>
</html>
