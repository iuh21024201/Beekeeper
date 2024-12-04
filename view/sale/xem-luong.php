<?php
// Kết nối đến database
$servername = "localhost";
$username = "root";
$password = "";
$database = "db_beekeeper"; // Thay bằng tên cơ sở dữ liệu thực tế của bạn

$conn = new mysqli($servername, $username, $password, $database);
if ($conn->connect_error) {
    die("Kết nối thất bại: " . $conn->connect_error);
}

// Lọc theo tháng và năm
$month = isset($_POST['month']) ? $_POST['month'] : '';
$year = isset($_POST['year']) ? $_POST['year'] : '';
$employee_id = !empty($_SESSION['dn']) ? $_SESSION['dn'] : 72;
// Truy vấn cơ bản để lấy thông tin lương nhân viên, thêm điều kiện lọc theo tháng và năm
$query = "
    SELECT 
        nv.ID_NhanVien, 
        nv.HoTen, 
        ch.TenCuaHang AS CuaHang, 
        l.TongGioLam, 
        l.ID_NhanVien, 
        l.LuongTheoGio, 
        l.Thuong, 
        l.TongLuong,
        l.start_date,
        l.end_date
    FROM 
        luong l
    JOIN 
        nhanvien nv ON l.ID_NhanVien = nv.ID_NhanVien
    JOIN 
        cuahang ch ON nv.ID_CuaHang = ch.ID_CuaHang
    WHERE l.ID_NhanVien = " . $employee_id;

// Điều kiện lọc theo tháng và năm
if ($month && $year) {
    $query .= " AND MONTH(l.start_date) = '$month' AND YEAR(l.start_date) = '$year'";
}

$result = $conn->query($query);

// Tính tổng lương
$total_salary_query = "
    SELECT 
        SUM(l.TongLuong) AS TotalSalary
    FROM 
        luong l
    JOIN 
        nhanvien nv ON l.ID_NhanVien = nv.ID_NhanVien
    JOIN 
        cuahang ch ON nv.ID_CuaHang = ch.ID_CuaHang
    WHERE 1=1";

if ($month && $year) {
    $total_salary_query .= " AND MONTH(l.start_date) = '$month' AND YEAR(l.start_date) = '$year'";
}

$total_salary_result = $conn->query($total_salary_query);
$total_salary = 0;
if ($total_salary_result->num_rows > 0) {
    $total_salary_row = $total_salary_result->fetch_assoc();
    $total_salary = $total_salary_row['TotalSalary'];
}

// Insert bản ghi vào bảng luong
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['insert'])) {
    $id_nhanvien = $_POST['id_nhanvien'];
    $tonggio_lam = $_POST['tonggio_lam'];
    $luongtheogio = $_POST['luongtheogio'];
    $thuong = $_POST['thuong'];
    $tongluong = $_POST['tongluong'];
    $start_date = $_POST['start_date'];
    $end_date = $_POST['end_date'];

    $insert_query = "
        INSERT INTO `luong` (`ID_NhanVien`, `TongGioLam`, `LuongTheoGio`, `Thuong`, `TongLuong`, `start_date`, `end_date`)
        VALUES ('$id_nhanvien', '$tonggio_lam', '$luongtheogio', '$thuong', '$tongluong', '$start_date', '$end_date')";

    if ($conn->query($insert_query) === TRUE) {
        echo "Bản ghi đã được thêm thành công!";
    } else {
        echo "Lỗi khi thêm bản ghi: " . $conn->error;
    }
}
?>

<body class="bg-gray-200">
    <div class="flex justify-between items-center">
        <h1>Thông Tin Lương Nhân Viên</h1>
        <div class="d-flex justify-between items-center">
            <form method="POST" action="">
                <label for="month">Chọn Tháng: </label>
                <select name="month" id="month" required>
                    <option value="">-- Chọn Tháng --</option>
                    <option value="1" <?php if ($month == '1') echo 'selected'; ?>>Tháng 1</option>
                    <option value="2" <?php if ($month == '2') echo 'selected'; ?>>Tháng 2</option>
                    <option value="3" <?php if ($month == '3') echo 'selected'; ?>>Tháng 3</option>
                    <option value="4" <?php if ($month == '4') echo 'selected'; ?>>Tháng 4</option>
                    <option value="5" <?php if ($month == '5') echo 'selected'; ?>>Tháng 5</option>
                    <option value="6" <?php if ($month == '6') echo 'selected'; ?>>Tháng 6</option>
                    <option value="7" <?php if ($month == '7') echo 'selected'; ?>>Tháng 7</option>
                    <option value="8" <?php if ($month == '8') echo 'selected'; ?>>Tháng 8</option>
                    <option value="9" <?php if ($month == '9') echo 'selected'; ?>>Tháng 9</option>
                    <option value="10" <?php if ($month == '10') echo 'selected'; ?>>Tháng 10</option>
                    <option value="11" <?php if ($month == '11') echo 'selected'; ?>>Tháng 11</option>
                    <option value="12" <?php if ($month == '12') echo 'selected'; ?>>Tháng 12</option>
                </select>

                <label for="year">Chọn Năm: </label>
                <select name="year" id="year" required>
                    <option value="">-- Chọn Năm --</option>
                    <option value="2024" <?php if ($year == '2024') echo 'selected'; ?>>2024</option>
                    <option value="2023" <?php if ($year == '2023') echo 'selected'; ?>>2023</option>
                    <option value="2022" <?php if ($year == '2022') echo 'selected'; ?>>2022</option>
                    <!-- Thêm các năm khác nếu cần -->
                </select>

                <button type="submit" name="filter" class="btn btn-success">Lọc</button>
            </form>
        </div>

        <h2>Tổng Lương: <?php
        if (!empty($total_salary)) {
            echo number_format($total_salary, 0) . " VND";
        } else {
            echo 0 . 'đ';
        }
        ?></h2>

        <table border="1" cellpadding="10" cellspacing="0" class="table-auto">
            <thead>
                <tr>
                    <th>Mã Nhân Viên</th>
                    <th>Họ Tên</th>
                    <th>Cửa Hàng</th>
                    <th>Tổng Giờ Làm</th>
                    <th>Lương Theo Giờ</th>
                    <th>Thưởng</th>
                    <th>Tổng Lương</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Hiển thị dữ liệu lương nhân viên
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $row['ID_NhanVien'] . "</td>";
                        echo "<td>" . $row['HoTen'] . "</td>";
                        echo "<td>" . $row['CuaHang'] . "</td>";
                        echo "<td>" . number_format($row['TongGioLam'], 0) . " giờ</td>";
                        echo "<td>" . number_format($row['LuongTheoGio'], 0) . " VND</td>";
                        echo "<td>" . number_format($row['Thuong'], 0) . " VND</td>";
                        echo "<td>" . number_format($row['TongLuong'], 0) . " VND</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='9'>Không có dữ liệu</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>

</body>
