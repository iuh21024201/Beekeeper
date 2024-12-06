<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include_once('../../model/ketnoi.php');
$p = new clsketnoi();
$conn = $p->moKetNoi();

// Kiểm tra quyền truy cập
if (!isset($_SESSION["dn"]) || $_SESSION["dn"] != 3) {
    echo "<script>alert('Bạn không có quyền truy cập')</script>";
    header("refresh:0;url='../../index.php'");
    exit();
}

// Lấy ID_TaiKhoan từ session
$idTaiKhoan = isset($_SESSION["ID_TaiKhoan"]) ? intval($_SESSION["ID_TaiKhoan"]) : 0;

// Truy vấn ID_NhanVien theo ID_TaiKhoan
$sqlNhanVien = "SELECT ID_NhanVien FROM nhanvien WHERE ID_TaiKhoan = ?";
$stmtNhanVien = $conn->prepare($sqlNhanVien);
$stmtNhanVien->bind_param("i", $idTaiKhoan);
$stmtNhanVien->execute();
$stmtNhanVien->bind_result($idNhanVien);
$stmtNhanVien->fetch();
$stmtNhanVien->close();

if (!$idNhanVien) {
    echo "<script>alert('Không tìm thấy nhân viên với ID_TaiKhoan này.'); window.location.href='index.php?action=dang-ky-ca';</script>";
    exit();
}

// Xác định tuần hiện tại hoặc tuần sau
$action = isset($_GET['action']) ? $_GET['action'] : 'current_week';
if ($action === 'next_week') {
    $week = date('W') + 1; // Tuần sau
    $startOfWeek = strtotime('monday next week');
} else {
    $week = date('W'); // Tuần hiện tại
    $startOfWeek = strtotime('monday this week');
}

// Định nghĩa các ngày trong tuần
$daysOfWeek = ['Thứ Hai', 'Thứ Ba', 'Thứ Tư', 'Thứ Năm', 'Thứ Sáu', 'Thứ Bảy', 'Chủ Nhật'];
$daysThisWeek = [];
for ($i = 0; $i < 7; $i++) {
    $daysThisWeek[] = date('d/m/Y', strtotime("+$i days", $startOfWeek));
}

// Truy vấn các ca làm việc đã đăng ký
$ca_dang_ky = [];
$sqlChamCong = "SELECT * FROM chamcong WHERE Tuan = ? AND ID_NhanVien = ? AND TrangThai IN ('Duyệt', 'Chấm công')";
$stmtChamCong = $conn->prepare($sqlChamCong);
$stmtChamCong->bind_param("ii", $week, $idNhanVien);
$stmtChamCong->execute();
$resultChamCong = $stmtChamCong->get_result();

while ($row = $resultChamCong->fetch_assoc()) {
    $ca_dang_ky[] = $row['TenCa'] . " - " . date('d/m/Y', strtotime($row['ThoiGian']));
}

$resultChamCong->free();
$stmtChamCong->close();
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng ký ca làm việc</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f9f9f9;
            margin: 0;
            padding: 0;
        }
        h1 {
            color: #333;
            text-align: center;
            padding: 20px 0;
            font-size: 24px;
        }
        table {
            width: 90%;
            margin: 20px auto;
            border-collapse: collapse;
            background-color: #fff;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        th, td {
            padding: 15px;
            text-align: center;
            border: 1px solid #ddd;
        }
        th {
            background-color: #f2f2f2;
            color: #333;
            font-weight: bold;
        }
        td {
            background-color: #fafafa;
        }
        input[type="checkbox"] {
            transform: scale(1.2);
        }
<<<<<<< HEAD
        .btn-1 {
=======
        .btnx {
>>>>>>> 9a75916eb8e797e2752e09cb33d3e313f15a8283
            display: block;
            width: fit-content;
            margin: 20px auto;
            padding: 10px 20px;
            font-size: 16px;
            background-color: #dc3545;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            text-decoration: none;
            text-align: center;
        }
<<<<<<< HEAD
        .btn-1:hover {
            background-color: #218838;
        }
=======
        
>>>>>>> 9a75916eb8e797e2752e09cb33d3e313f15a8283
    </style>
</head>
<body>
    <h1>Lịch làm việc - Tuần <?php echo $week; ?></h1>
    <table>
        <thead>
            <tr>
                <th width="120">&nbsp;</th>
                <?php foreach ($daysOfWeek as $index => $day): ?>
                    <th><?php echo $day . " (" . $daysThisWeek[$index] . ")"; ?></th>
                <?php endforeach; ?>
            </tr>
        </thead>
        <tbody>
            <tr>
                <th scope="row">Ca A<br>(8h - 14h)</th>
                <?php foreach ($daysThisWeek as $date): ?>
                    <?php 
                        $value = "Ca A - " . $date;
                        $checked = in_array($value, $ca_dang_ky) ? 'checked' : '';
                    ?>
                    <td><input type="checkbox" <?php echo $checked; ?> disabled></td>
                <?php endforeach; ?>
            </tr>
            <tr>
                <th scope="row">Ca B <br>(14h - 20h)</th>
                <?php foreach ($daysThisWeek as $date): ?>
                    <?php 
                        $value = "Ca B - " . $date;
                        $checked = in_array($value, $ca_dang_ky) ? 'checked' : '';
                    ?>
                    <td><input type="checkbox" <?php echo $checked; ?> disabled></td>
                <?php endforeach; ?>
            </tr>
        </tbody>
    </table>

    <form method="GET">
        <?php if ($action === 'next_week'): ?>
            <input type="hidden" name="action" value="current_week">
<<<<<<< HEAD
            <button type="submit" class="btn-1">Xem tuần này</button>
        <?php else: ?>
            <input type="hidden" name="action" value="next_week">
            <button type="submit" class="btn-1">Xem tuần sau</button>
=======
            <button type="submit" class="btnx">Xem tuần này</button>
        <?php else: ?>
            <input type="hidden" name="action" value="next_week">
            <button type="submit" class="btnx">Xem tuần sau</button>
>>>>>>> 9a75916eb8e797e2752e09cb33d3e313f15a8283
        <?php endif; ?>
    </form>
</body>
</html>
