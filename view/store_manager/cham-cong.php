<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "beekeeper";

// Kết nối đến database
$conn = new mysqli($servername, $username, $password, $database);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

date_default_timezone_set('Asia/Ho_Chi_Minh');

// Xử lý chọn ngày
$selectedDate = isset($_GET['date']) ? $_GET['date'] : date('Y-m-d');

// Kiểm tra định dạng ngày hợp lệ
if (DateTime::createFromFormat('Y-m-d', $selectedDate)) {
    $query = "SELECT nv.ID_NhanVien, nv.HoTen, c.CheckIn, c.CheckOut, c.TrangThai AS TrangThaiCa, c.Thu, c.Tuan, c.TenCa
              FROM nhanvien nv
              LEFT JOIN ca c ON nv.ID_NhanVien = c.ID_NhanVien AND c.NgayChamCong = '$selectedDate'";
} else {
    // Nếu ngày không hợp lệ, mặc định là hôm nay
    $selectedDate = date('Y-m-d');
    $query = "SELECT nv.ID_NhanVien, nv.HoTen, c.CheckIn, c.CheckOut, c.TrangThai AS TrangThaiCa, c.Thu, c.Tuan, c.TenCa
              FROM nhanvien nv
              LEFT JOIN ca c ON nv.ID_NhanVien = c.ID_NhanVien AND c.NgayChamCong = '$selectedDate'";
}

$result = $conn->query($query);

// Dữ liệu nhân viên và chấm công
$employees = [];
if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $employees[] = $row;
    }
}

// Xử lý Check-in
if (isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['checkin'])) {
        $idNhanVien = $_POST['id_nhanvien'];
        $currentDate = date('Y-m-d');
        $checkInTime = date('H:i:s');
        $tenCa = 'Ca ngày: ' . $currentDate;
        $currentDayOfWeek = date('N');
        $currentWeekOfYear = date('W');
        $thu = ['Thứ 2', 'Thứ 3', 'Thứ 4', 'Thứ 5', 'Thứ 6', 'Thứ 7', 'Chủ nhật'][$currentDayOfWeek - 1];

        $checkExisting = "SELECT * FROM ca WHERE ID_NhanVien = '$idNhanVien' AND NgayChamCong = '$currentDate'";
        $result = $conn->query($checkExisting);
        if ($result->num_rows > 0) {
            echo "<script>alert('Nhân viên này đã Check-in hôm nay!');</script>";
        } else {
            $insertQuery = "INSERT INTO ca (ID_NhanVien, NgayChamCong, CheckIn, Thu, Tuan, TenCa, TrangThai) 
                            VALUES ('$idNhanVien', '$currentDate', '$checkInTime', '$thu', '$currentWeekOfYear', '$tenCa', 'Đang làm')";
            if ($conn->query($insertQuery)) {
                header("Location: index.php?action=cham-cong");
                exit();
            } else {
                echo "<script>alert('Lỗi khi Check-in!');</script>";
            }
        }
    }

    if (isset($_POST['checkout'])) {
        $idNhanVien = $_POST['id_nhanvien'];
        $currentDate = date('Y-m-d');
        $checkOutTime = date('H:i:s');
    
        $checkInQuery = "SELECT * FROM ca WHERE ID_NhanVien = '$idNhanVien' AND NgayChamCong = '$currentDate' AND CheckIn IS NOT NULL";
        $checkInResult = $conn->query($checkInQuery);
        
        if ($checkInResult->num_rows == 0) {
            echo "<script>alert('Lỗi: Nhân viên chưa Check-in!');</script>";
        } else {
            $checkInData = $checkInResult->fetch_assoc();
            $checkInTime = $checkInData['CheckIn'];
            $checkOutDateTime = $currentDate . ' ' . $checkOutTime;
    
            $soGioLam = (strtotime($checkOutDateTime) - strtotime($checkInTime)) / 3600;
    
            $luongTheoGio = 30000;
    
            $tongLuong = $soGioLam * $luongTheoGio;
    
            $updateQuery = "UPDATE ca SET CheckOut = '$checkOutDateTime', TrangThai = 'Đã làm', 
                            SoGioLam = '$soGioLam'
                            WHERE ID_NhanVien = '$idNhanVien' AND NgayChamCong = '$currentDate'";
    
            if ($conn->query($updateQuery)) {
                $insertLuongQuery = "INSERT INTO luong (ID_NhanVien, TongGioLam, LuongTheoGio, Thuong, TongLuong, start_date, end_date)
                                    VALUES ('$idNhanVien', '$soGioLam', '$luongTheoGio', 0, '$tongLuong', '$currentDate', '$currentDate')";
    
                if ($conn->query($insertLuongQuery)) {
                    echo "<script>alert('Check-out và cập nhật lương thành công!'); window.location.href='index.php?action=cham-cong';</script>";
                } else {
                    echo "<script>alert('Lỗi khi cập nhật lương!');</script>";
                }
            } else {
                echo "<script>alert('Lỗi khi Check-out!');</script>";
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
                    $workDuration = $checkOut - $checkIn;
                    $workHours = floor($workDuration / 3600);
                    $workMinutes = floor(($workDuration % 3600) / 60);
                    $workTime = $workHours > 0 ? "{$workHours} giờ {$workMinutes} phút" : "{$workMinutes} phút";
                } elseif ($checkIn) {
                    $workTime = "Đang làm";
                } else {
                    $workTime = "Không đi làm";
                }
                ?>
                <tr>
                    <td><?php echo htmlspecialchars($employee['HoTen']); ?></td>
                    <td><?php echo $checkIn ? date('H:i:s', $checkIn) : ''; ?></td>
                    <td><?php echo $checkOut ? date('H:i:s', $checkOut) : ''; ?></td>
                    <td><?php echo htmlspecialchars($employee['TrangThaiCa'] ?? ''); ?></td>
                    <td><?php echo htmlspecialchars($employee['Thu'] ?? ''); ?></td>
                    <td><?php echo htmlspecialchars($employee['Tuan'] ?? ''); ?></td>
                    <td><?php echo $workTime; ?></td>
                    <?php if (!isset($_GET['date'])): ?>
                        <td>
                            <?php if ($checkIn && !$checkOut): ?>
                                <form action="index.php?action=cham-cong" method="POST">
                                    <input type="hidden" name="id_nhanvien" value="<?php echo $employee['ID_NhanVien']; ?>">
                                    <input type="hidden" name="action" value="check_in">
                                    <button class="btn btn-danger" type="submit" name="checkout">Check-out</button>
                                </form>
                            <?php elseif (!$checkIn): ?>
                                <form action="index.php?action=cham-cong" method="POST">
                                    <input type="hidden" name="id_nhanvien" value="<?php echo $employee['ID_NhanVien']; ?>">
                                    <input type="hidden" name="action" value="check_out">
                                    <button class="btn btn-primary" type="submit" name="checkin">Check-in</button>
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
