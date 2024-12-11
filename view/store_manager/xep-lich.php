<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Database connection (replace with your actual database credentials)
$servername = "localhost";
$username = "root";
$password = "";
$database = "db_beekeeper_10";

// Connect to the database
$conn = new mysqli($servername, $username, $password, $database);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Ensure user is logged in and has the 'ID_TaiKhoan' session
if (!isset($_SESSION['ID_TaiKhoan'])) {
    echo "Bạn cần đăng nhập để xem thống kê.";
    exit;
}

$idTaiKhoan = $_SESSION['ID_TaiKhoan'];

// Fetch the store ID of the current user from the session
$sqlStore = "SELECT ID_CuaHang FROM quanlycuahang WHERE ID_TaiKhoan = ?";
$stmtStore = $conn->prepare($sqlStore);
if ($stmtStore === false) {
    die("Error preparing SQL statement for store: " . $conn->error);
}
$stmtStore->bind_param("i", $idTaiKhoan);
$stmtStore->execute();
$resultStore = $stmtStore->get_result();

// If no store is found for the user, show an error
if ($resultStore->num_rows == 0) {
    echo "Bạn không có quyền truy cập cửa hàng nào.";
    exit;
}

$rowStore = $resultStore->fetch_assoc();
$idCuaHang = $rowStore['ID_CuaHang']; // Store ID for current user (manager)
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Xếp lịch làm việc</title>
    <link rel="stylesheet" href="../../asset/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        .table th, .table td {
            vertical-align: middle;
            padding: 0.5rem;
        }
    </style>
</head>
<body>
<div class="container mt-4">
    <h2>Xếp lịch làm việc cho nhân viên cửa hàng</h2>

    <!-- Form chọn tuần -->
    <form id="filter-form" class="mb-4">
        <label for="week">Chọn tuần:</label>
        <input type="number" id="week" name="week" value="<?php echo date('W'); ?>" class="form-control w-25 d-inline-block">
        <button type="button" id="filter-button" class="btn btn-primary">Xem lịch</button>
    </form>

    <!-- Bảng xếp lịch -->
    <table class="table table-bordered">
        <thead>
            <tr>
                <th rowspan="2" class="align-middle">Ngày</th>
                <th colspan="2" class="text-center">Ca sáng</th>
                <th colspan="2" class="text-center">Ca chiều</th>
            </tr>
            <tr>
                <th class="text-center">Lịch làm việc</th>
                <th class="text-center">Đăng ký ca</th>
                <th class="text-center">Lịch làm việc</th>
                <th class="text-center">Đăng ký ca</th>
            </tr>
        </thead>
        <tbody id="schedule-table">
            <!-- This will be populated by JavaScript -->
        </tbody>
    </table>
</div>

<div id="error-message" class="alert alert-danger mt-3" style="display: none;"></div>

<script src="../../asset/js/duyetca.js"></script>
<script>
    // Pass the store ID to JavaScript
    var storeId = <?php echo $idCuaHang; ?>;
    console.log("Store ID:", storeId);
</script>
</body>
</html>

