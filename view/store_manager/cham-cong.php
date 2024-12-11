<?php
require_once('../../model/mQuanLyCuaHang.php');
$mCuaHang = new mQuanLyCuaHang();

$chiNhanh = $mCuaHang->getChiNhanhByID($_SESSION["ID_TaiKhoan"] ?? 74);

if (!empty($chiNhanh)) {
    $nhanvienlist = $mCuaHang->getEmployeesByStore($chiNhanh[0]['ID_CuaHang']);
}

date_default_timezone_set('Asia/Ho_Chi_Minh');

// Xử lý chọn ngày
$selectedDate = isset($_GET['date']) ? $_GET['date'] : date('Y-m-d');
if (!empty($chiNhanh)) {
    $employees = $mCuaHang->checkDate($selectedDate, $chiNhanh);
}

// Xử lý Check-in
if (isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['checkin'])) {
        $idNhanVien = $_POST['id_nhanvien'];
        $idChamCong = $_POST['id_chamcong'];

        $isCheckedIn = $mCuaHang->checkAndUpdateCheckIn($idNhanVien, $idChamCong);

        if ($isCheckedIn) {
            header("Location: index.php?action=cham-cong");
            exit();
        } else {
            echo "<script>alert('Nhân viên này đã Check-in hôm nay hoặc có lỗi khi chấm công!');</script>";
        }
    }

    if (isset($_POST['checkout'])) {
        $idNhanVien = $_POST['id_nhanvien'];
        $currentDate = date('Y-m-d');
        $checkOutTime = date('H:i:s');

        // Kiểm tra nhân viên đã check-in chưa
        $checkInResult = $mCuaHang->selectCheckIn($idNhanVien, $currentDate);
        if ($checkInResult->num_rows == 0) {
            echo "<script>alert('Lỗi: Nhân viên chưa Check-in!');</script>";
        } else {
            $checkInData = $checkInResult->fetch_assoc();
            $checkInTime = $checkInData['Checkin'];
            $checkOutDateTime = $currentDate . ' ' . $checkOutTime;

            // Tính số giờ làm việc
            $soGioLam = (strtotime($checkOutDateTime) - strtotime($checkInTime)) / 3600;

            // Lấy phần thưởng
            $bonusCount = $mCuaHang->selectBonus($idNhanVien, $currentDate);
            $bonusAmount = $bonusCount * 500000;

            // Tính tổng lương
            $tongLuong = $soGioLam * 30000 + $bonusAmount;

            if ($mCuaHang->updateCheckOut($idNhanVien, $currentDate, $checkOutDateTime, $soGioLam, $bonusAmount, $tongLuong)) {
                echo "<script>alert('Check-out và cập nhật lương thành công!'); window.location.href='index.php?action=cham-cong';</script>";
            } else {
                echo "<script>alert('Lỗi khi cập nhật lương!');</script>";
            }
        }
    }
}
?>


<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chấm Công Nhân Viên</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>

<body>
    <h2>Chấm Công Nhân Viên</h2>

    <form method="GET" action="index.php">
        <input type="hidden" name="action" value="cham-cong">
        <label for="date">Chọn ngày:</label>
        <input type="date" id="date" name="date" value="<?php echo htmlspecialchars($selectedDate); ?>" required>
        <button type="submit" class="btn btn-primary">Xem chấm công</button>
        <a href="index.php?action=cham-cong" class="btn btn-info">Danh sách chấm công hôm nay</a>
    </form>

    <table class="table table-bordered mt-3">
        <thead>
            <tr>
                <th>Tên Nhân Viên</th>
                <th>Thời Gian Check-in</th>
                <th>Thời Gian Check-out</th>
                <th>Trạng Thái</th>
                <th>Thứ</th>
                <th>Tuần</th>
                <th>Số giờ làm</th>
                <?php if (!isset($_GET['date'])): ?>
                    <th>Hành Động</th>
                <?php endif; ?>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($employees as $employee):
                $checkIn = isset($employee['CheckIn']) ? strtotime($employee['CheckIn']) : null;
                $checkOut = isset($employee['CheckOut']) ? strtotime($employee['CheckOut']) : null;

                $workTime = "Chưa làm";
                if ($checkIn && $checkOut) {
                    $workTime = round(($checkOut - $checkIn) / 3600, 2) . " giờ";
                }
            ?>
                <tr>
                    <td><?php echo htmlspecialchars($employee['HoTen']) ?? '' ?></td>
                    <td><?php echo $checkIn ? date('H:i:s', $checkIn) : ''; ?></td>
                    <td><?php echo $checkOut ? date('H:i:s', $checkOut) : ''; ?></td>
                    <td><?php echo htmlspecialchars($employee['TrangThaiCa'] ?? ''); ?></td>
                    <td><?php echo htmlspecialchars($employee['Thu'] ?? ''); ?></td>
                    <td><?php echo htmlspecialchars($employee['Tuan'] ?? ''); ?></td>
                    <td><?php echo $workTime; ?></td>
                    <?php if (!isset($_GET['date'])): ?>
                        <td>
                            <?php if (!$checkIn): ?>
                                <form method="POST">
                                    <input type="hidden" name="id_chamcong" value="<?php echo $employee['id']; ?>">
                                    <input type="hidden" name="id_nhanvien" value="<?php echo $employee['ID_NhanVien']; ?>">
                                    <button type="submit" name="checkin" class="btn btn-success">Check-in</button>
                                </form>
                            <?php elseif ($checkIn && !$checkOut): ?>
                                <form method="POST">
                                    <input type="hidden" name="id_chamcong" value="<?php echo $employee['id']; ?>">
                                    <input type="hidden" name="id_nhanvien" value="<?php echo $employee['ID_NhanVien']; ?>">
                                    <button type="submit" name="checkout" class="btn btn-danger">Check-out</button>
                                </form>
                            <?php endif; ?>
                        </td>
                    <?php endif; ?>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>

</html>