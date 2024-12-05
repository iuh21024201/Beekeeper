<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include_once('../../model/ketnoi.php');
$p = new clsketnoi();
$conn = $p->moKetNoi();

// Kiểm tra quyền truy cập
if (!isset($_SESSION["dn"]) || $_SESSION["dn"] != 4) {
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
$stmtNhanVien->close(); // Close the first statement

if (!$idNhanVien) {
    echo "<script>alert('Không tìm thấy nhân viên với ID_TaiKhoan này.'); window.location.href='index.php?action=dang-ky-ca';</script>";
    exit();
}

// Lấy số tuần hiện tại
$currentWeek = date('W') + 1;

// Truy vấn các ca làm việc đã đăng ký cho tuần hiện tại
$ca_dang_ky = [];
$sqlChamCong = "SELECT * FROM chamcong WHERE Tuan = ? AND ID_NhanVien = ?";
$stmtChamCong = $conn->prepare($sqlChamCong);
$stmtChamCong->bind_param("ii", $currentWeek, $idNhanVien);
$stmtChamCong->execute();
$resultChamCong = $stmtChamCong->get_result();

while ($row = $resultChamCong->fetch_assoc()) {
    $ca_dang_ky[] = $row['TenCa'] . " - " . date('d/m/Y', strtotime($row['ThoiGian']));
}

$resultChamCong->free(); // Free the result set
$stmtChamCong->close();  // Close the second statement

// Định nghĩa các ngày trong tuần
$daysOfWeek = ['Thứ Hai', 'Thứ Ba', 'Thứ Tư', 'Thứ Năm', 'Thứ Sáu', 'Thứ Bảy', 'Chủ Nhật'];
$nextMonday = date('Y-m-d', strtotime('next Monday'));
$daysNextWeek = [];
for ($i = 0; $i < 7; $i++) {
    $daysNextWeek[] = date('d/m/Y', strtotime("+$i days", strtotime($nextMonday)));
}

// Tính toán ngày Chủ Nhật của tuần hiện tại
$currentSunday = date('Y-m-d', strtotime('sunday this week'));
$isExpired = (new DateTime()) > (new DateTime($currentSunday));

// Đặt thông báo hạn đăng ký
$expiryMessage = $isExpired ? "Thời gian đăng ký đã hết hạn!" : "Thời gian hết hạn đăng ký trước Chủ Nhật tuần này: " . date('d/m/Y', strtotime($currentSunday));
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
        .expiry-message {
            text-align: center;
            color: red;
            font-weight: bold;
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
        .form-container {
            text-align: center;
            margin-top: 30px;
        }
        .btnx {
            padding: 10px 20px;
            margin: 10px;
            font-size: 16px;
            border: none;
            background-color: #28a745;
            color: white;
            border-radius: 4px;
            cursor: pointer;
        }
        .btn-reset {
            background-color: #dc3545;
        }
       
    </style>
</head>
<body>

<form action="xuly_dangky.php" method="POST" <?php echo $isExpired ? 'disabled' : ''; ?>>
    <h1>Đăng ký ca làm việc - Tuần <?php echo $currentWeek; ?></h1>
    <div class="expiry-message"><?php echo $expiryMessage; ?></div>
    <table>
        <thead>
            <tr>
                <th width="120">&nbsp;</th>
                <?php
                    foreach ($daysOfWeek as $index => $day) {
                        echo "<th>" . $day . " (" . $daysNextWeek[$index] . ")</th>";
                    }
                ?>
            </tr>
        </thead>

        <tbody>
            <tr>
                <th scope="row">Ca A <br>(8h - 14h)</th>
                <?php
                    foreach ($daysOfWeek as $index => $day) {
                        $value = "Ca A - " . $daysNextWeek[$index];
                        $checked = in_array($value, $ca_dang_ky) ? 'checked' : '';
                        echo "<td><input type='checkbox' name='ca_lam_viec[]' value='$value' $checked></td>";
                    }
                ?>
            </tr>

            <tr>
                <th scope="row">Ca B <br>(14h - 20h)</th>
                <?php
                    foreach ($daysOfWeek as $index => $day) {
                        $value = "Ca B - " . $daysNextWeek[$index];
                        $checked = in_array($value, $ca_dang_ky) ? 'checked' : '';
                        echo "<td><input type='checkbox' name='ca_lam_viec[]' value='$value' $checked></td>";
                    }
                ?>
            </tr>
        </tbody>
    </table>

    <div class="form-container">
        <button type="submit" name="xacnhan" class="btnx" <?php echo $isExpired ? 'disabled' : ''; ?>>Xác nhận đăng ký</button>
        <button type="reset" class="btn btn-reset">Hủy</button>
    </div>
</form>

</body>
</html>
