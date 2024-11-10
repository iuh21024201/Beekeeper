<?php
// xep-lich.php

// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$database = "beekeeper"; // Replace with your actual database name

$conn = new mysqli(hostname: $servername, username: $username, password: $password, database: $database);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch employees who have registered shifts for the current week
$sql = "SELECT d.ID_NhanVien, n.TenNhanVien, d.TenCa, d.ThoiGian, d.Tuan 
        FROM dangkyca d
        JOIN NhanVien n ON d.ID_NhanVien = n.ID_NhanVien
        WHERE d.Tuan = WEEK(CURDATE())";  // Filter for the current week
$employeesResult = $conn->query(query: $sql);
$employeeSchedules = [];

if ($employeesResult->num_rows > 0) {
    while ($row = $employeesResult->fetch_assoc()) {
        $employeeSchedules[$row['Tuan']][$row['TenCa']][$row['ID_NhanVien']] = $row; // Store by Week, Shift, and Employee ID
    }
}

// Handle form submission to save the schedule
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Process each day's selected shifts
    foreach ($_POST['schedule'] as $day => $shifts) {
        foreach ($shifts as $shift => $employeeId) {
            if ($employeeId) {
                // Insert or update the shift registration in the dangkyca table
                $sql = "INSERT INTO dangkyca (ID_NhanVien, TenCa, ThoiGian, Tuan) 
                        VALUES ('$employeeId', '$shift', NOW(), WEEK(CURDATE())) 
                        ON DUPLICATE KEY UPDATE ID_NhanVien = '$employeeId'";
                if ($conn->query(query: $sql) === TRUE) {
                    // Success message
                } else {
                    echo "<script>alert('Lỗi khi lưu lịch làm việc: " . $conn->error . "');</script>";
                }
            }
        }
    }
    echo "<script>alert('Lịch làm việc đã được lưu thành công!');</script>";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Xếp lịch làm việc</title>
    <link rel="stylesheet" href="../../asset/css/bootstrap.min.css">
</head>
<body>
<div class="container mt-4">
    <h2>Xếp lịch làm việc cho nhân viên</h2>
    <form method="POST">
        <table class="table table-bordered">
            <thead class="thead-dark">
                <tr>
                    <th>Ngày</th>
                    <th>Ca Sáng</th>
                    <th>Ca Chiều</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Define days of the week
                $daysOfWeek = [
                    "Monday" => "Thứ Hai", "Tuesday" => "Thứ Ba", "Wednesday" => "Thứ Tư", 
                    "Thursday" => "Thứ Năm", "Friday" => "Thứ Sáu", "Saturday" => "Thứ Bảy", "Sunday" => "Chủ Nhật"
                ];

                // Loop through each day of the week
                foreach ($daysOfWeek as $day => $dayName) {
                    echo "<tr>";
                    echo "<td>$dayName</td>";

                    // Loop through each shift (Morning & Afternoon)
                    foreach (['Ca Sáng', 'Ca Chiều'] as $shiftName) {
                        echo "<td>";
                        echo "<select name='schedule[$day][$shiftName]' class='form-control'>";

                        // Get employees who have registered for this shift
                        echo "<option value=''>Chọn nhân viên</option>";
                        foreach ($employeesResult as $employee) {
                            $selected = "";
                            if (isset($employeeSchedules[$employee['Tuan']][$shiftName][$employee['ID_NhanVien']])) {
                                $selected = "selected";
                            }
                            echo "<option value='" . $employee['ID_NhanVien'] . "' $selected>" . $employee['TenNhanVien'] . "</option>";
                        }

                        echo "</select>";
                        echo "</td>";
                    }

                    echo "</tr>";
                }
                ?>
            </tbody>
        </table>
        <button type="submit" class="btn btn-primary">Lưu lịch làm việc</button>
    </form>
</div>
</body>
</html>

<?php
// Close the database connection
$conn->close();
?>
