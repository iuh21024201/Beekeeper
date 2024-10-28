//<?php
// Kết nối cơ sở dữ liệu
//$conn = new mysqli("localhost", "root", "", "test");

// Đặt charset UTF-8 để hỗ trợ tiếng Việt
//$conn->set_charset("utf8mb4");

//if ($conn->connect_error) {
//    die("Kết nối thất bại: " . $conn->connect_error);
//}

// Lấy số tuần hiện tại
//$currentWeek = date('W') + 1;

// Truy vấn các ca làm việc đã đăng ký cho tuần hiện tại
//$ca_dang_ky = [];
//$sql = "SELECT * FROM dangky_ca WHERE SoTuan = ?";
//$stmt = $conn->prepare($sql);
//$stmt->bind_param("i", $currentWeek);
//$stmt->execute();
//$result = $stmt->get_result();

//while ($row = $result->fetch_assoc()) {
 //   $ca_dang_ky[] = $row['TenCa'] . " - " . date('d/m/Y', strtotime($row['NgayLamViec']));
//}

//$stmt->close();

$ca_dang_ky = [];

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
        .btn {
            padding: 10px 20px;
            margin: 10px;
            font-size: 16px;
            border: none;
            background-color: #28a745;
            color: white;
            border-radius: 4px;
            cursor: pointer;
        }
        .btn:hover {
            background-color: #218838;
        }
        .btn-reset {
            background-color: #dc3545;
        }
        .btn-reset:hover {
            background-color: #c82333;
        }
    </style>
</head>
<body>

<form action="xuly_dangky.php" method="POST" <?php echo $isExpired ? 'disabled' : ''; ?>>
    <h1>Đăng ký ca làm việc - Tuần <?php echo date('W') + 1; ?></h1>
    <div class="expiry-message"><?php echo $expiryMessage; ?></div>
    <table>
        <thead>
            <tr>
                <th width="85">&nbsp;</th>
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
        <button type="submit" name="xacnhan" class="btn" <?php echo $isExpired ? 'disabled' : ''; ?>>Xác nhận đăng ký</button>
        <button type="reset" class="btn btn-reset">Hủy</button>
    </div>
</form>

</body>
</html>