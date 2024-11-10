<?php
// Kết nối cơ sở dữ liệu
$servername = "localhost";
$username = "root";
$password = "";
$database = "beekeeper"; // Replace with your actual database name

$conn = new mysqli(hostname: $servername, username: $username, password: $password, database: $database);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
// Lấy ngày hiện tại
$ngayChamCong = date('Y-m-d');

// Lấy thông tin nhân viên và lịch làm việc cho ngày hôm nay
$query = "
    SELECT nv.ID_NhanVien, nv.TenNhanVien, ll.TenCa, ll.ThoiGian 
    FROM nhanvien nv
    INNER JOIN lichlamviec ll ON nv.ID_NhanVien = ll.ID_NhanVien
    WHERE ll.Tuan = WEEK(CURDATE()) AND ll.ThoiGian <= CURTIME()
";
$result = mysqli_query($conn, $query);
$nhanVienList = mysqli_fetch_all($result, MYSQLI_ASSOC);

// Hàm xử lý Check-in/Check-out
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $idNhanVien = $_POST['ID_NhanVien'];
    $action = $_POST['action'];  // 'checkin' hoặc 'checkout'
    
    // Lấy giờ hiện tại
    $currentTime = date('H:i:s');
    
    if ($action == 'checkin') {
        // Insert thời gian check-in vào bảng chamcong
        $insertQuery = "
            INSERT INTO chamcong (ID_NhanVien, NgayChamCong, Checkin, TrangThai)
            VALUES ('$idNhanVien', '$ngayChamCong', '$currentTime', 'Đang làm')
        ";
        mysqli_query($conn, $insertQuery);
    } elseif ($action == 'checkout') {
        // Kiểm tra xem nhân viên có đã check-in chưa
        $checkQuery = "
            SELECT * FROM chamcong 
            WHERE ID_NhanVien = '$idNhanVien' 
            AND NgayChamCong = '$ngayChamCong' 
            AND Checkin IS NOT NULL
        ";
        $checkResult = mysqli_query($conn, $checkQuery);
        
        if (mysqli_num_rows($checkResult) > 0) {
            // Nếu đã check-in, insert thời gian check-out
            $updateQuery = "
                UPDATE chamcong 
                SET Checkout = '$currentTime', TrangThai = 'Đã làm'
                WHERE ID_NhanVien = '$idNhanVien' 
                AND NgayChamCong = '$ngayChamCong'
            ";
            mysqli_query($conn, $updateQuery);
        } else {
            echo "Bạn phải check-in trước khi checkout!";
        }
    }
}

// Đóng kết nối
mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chấm công</title>
</head>
<body>
    <h1>Chấm công ngày <?php echo $ngayChamCong; ?></h1>
    <table border="1">
        <thead>
            <tr>
                <th>Tên Nhân Viên</th>
                <th>Ca Làm Việc</th>
                <th>Thời Gian</th>
                <th>Check-in</th>
                <th>Check-out</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($nhanVienList as $nv): ?>
            <tr>
                <td><?php echo $nv['TenNhanVien']; ?></td>
                <td><?php echo $nv['TenCa']; ?></td>
                <td><?php echo $nv['ThoiGian']; ?></td>
                <td>
                    <form method="POST">
                        <input type="hidden" name="ID_NhanVien" value="<?php echo $nv['ID_NhanVien']; ?>">
                        <input type="hidden" name="action" value="checkin">
                        <button type="submit">Check-in</button>
                    </form>
                </td>
                <td>
                    <form method="POST">
                        <input type="hidden" name="ID_NhanVien" value="<?php echo $nv['ID_NhanVien']; ?>">
                        <input type="hidden" name="action" value="checkout">
                        <button type="submit">Check-out</button>
                    </form>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>
