<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Kết nối cơ sở dữ liệu
$servername = "localhost";
$username = "root";
$password = "";
$database = "db_beekeeper"; 

$conn = new mysqli($servername, $username, $password, $database);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error); 
}

// Lấy từ khóa tìm kiếm từ GET (nếu có)
$tenmonan = isset($_GET['tenmonan']) ? trim($_GET['tenmonan']) : '';

// Khởi tạo biến kiểu dữ liệu và tham số
$types = ""; 
$params = []; 

// Chuẩn bị câu truy vấn
$sql = "SELECT ID_MonAn, TenMonAn, MoTa, Gia, GiamGia 
        FROM monan 
        WHERE TinhTrang = '0'";

if (!empty($tenmonan)) {
    $sql .= " AND TenMonAn LIKE ?";
    $params[] = "%" . $tenmonan . "%";
    $types .= "s";
}

// Chuẩn bị và thực thi truy vấn
$stmt = $conn->prepare($sql);
if ($stmt === false) {
    die("Lỗi truy vấn: " . $conn->error);
}

if (!empty($params)) {
    $stmt->bind_param($types, ...$params);
}

$stmt->execute();
$result = $stmt->get_result();

// Xử lý giảm giá đồng loạt
$isUpdated = false; 
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['bulk_discount'])) {
        $discount = $_POST['bulk_discount'];
        $sql = "UPDATE monan SET GiamGia = ? WHERE TinhTrang = '0'";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $discount);
        if ($stmt->execute()) {
            $isUpdated = true;
        }
    }
    if (isset($_POST['id_monan'], $_POST['discount'])) {
        $idMonAn = $_POST['id_monan'];
        $discount = $_POST['discount'];
        $sql = "UPDATE monan SET GiamGia = ? WHERE ID_MonAn = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ii", $discount, $idMonAn);
        if ($stmt->execute()) {
            $isUpdated = true;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Quản lý giảm giá đồng loạt</title>
  <link rel="stylesheet" href="../../asset/css/bootstrap.min.css">
  <script src="../../asset/js/jquery-3.4.1.min.js"></script>
  <script src="../../asset/js/bootstrap.min.js"></script>
</head>

<body>
<div class="container">
    <h2 class="mt-4">Quản lý giảm giá đồng loạt</h2>

    <!-- Form tìm kiếm -->
    <form method="get" action="index.php" class="form-inline mb-4">
        <input type="hidden" name="action" value="quan-ly-giam-gia">
        <label for="tenmonan" class="mr-2">Nhập tên cần tìm: </label>
        <input type="text" name="tenmonan" id="tenmonan" class="form-control mr-2" value="<?= htmlspecialchars($tenmonan) ?>">
        <button type="submit" class="btn btn-primary">Lọc</button>
    </form>
    <!-- Form giảm giá đồng loạt -->
    <form method="POST" action="">
        <div class="form-group">
            <label for="bulk_discount">Chọn mức giảm giá (%) cho tất cả món ăn:</label>
            <select name="bulk_discount" id="bulk_discount" class="form-control" style="width: 120px;">
                <?php for ($i = 0; $i <= 50; $i += 10): ?>
                    <option value="<?php echo $i; ?>" <?php echo (isset($_POST['bulk_discount']) && $_POST['bulk_discount'] == $i) ? 'selected' : ''; ?>>
                        <?php echo $i; ?>%
                    </option>
                <?php endfor; ?>
            </select>
        </div>
        <button type="submit" class="btn btn-success">Áp dụng giảm giá đồng loạt</button>
    </form>

    <!-- Hiển thị thông báo thành công chỉ khi cập nhật thành công -->
    <?php if ($isUpdated): ?>
        <script>
            alert("Áp dụng giảm giá thành công!");
            window.location.href = window.location.href;  // Tải lại trang hiện tại
        </script>
    <?php endif; ?>

    <table class="table table-striped mt-4">
        <thead>
            <tr>
                <th>Tên Món Ăn</th>
                <th>Mô Tả</th>
                <th>Giá</th>
                <th>Giảm Giá (%)</th>
                <th>Giá Sau Giảm</th>
                <th>Thao Tác</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $result->fetch_assoc()): ?>
                <?php
                // Tính giá sau giảm
                $giaSauGiam = $row['Gia'] - ($row['Gia'] * $row['GiamGia'] / 100);
                ?>
                <tr>
                    <td><?php echo htmlspecialchars($row['TenMonAn']); ?></td>
                    <td><?php echo htmlspecialchars($row['MoTa']); ?></td>
                    <td><?php echo number_format($row['Gia'], 0, ',', '.'); ?> VND</td>
                    <td>
                        <form method="POST" action="">
                            <input type="hidden" name="id_monan" value="<?php echo $row['ID_MonAn']; ?>"> <!-- ID món ăn -->
                            <select name="discount" class="form-control" style="width: 120px;">
                                <?php for ($i = 0; $i <= 50; $i += 10): ?>
                                    <option value="<?php echo $i; ?>" <?php echo ($i == $row['GiamGia']) ? 'selected' : ''; ?> >
                                        <?php echo $i; ?>%
                                    </option>
                                <?php endfor; ?>
                            </select>
                    </td>
                    <td>
                        <?php echo number_format($giaSauGiam, 0, ',', '.'); ?> VND
                    </td>
                    <td>
                        <button type="submit" class="btn btn-primary mt-2">Cập nhật</button>
                        </form>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>
</body>
<Script>
    function submitSearch() {
    var searchTerm = document.getElementById('search').value;
    var url = new URL(window.location.href);
    if (searchTerm) {
        url.searchParams.set('search', searchTerm);
    } else {
        url.searchParams.delete('search'); 
    }
    window.history.pushState({}, '', url);
    
    loadSearchResults(searchTerm);
}
function loadSearchResults(searchTerm) {
    $.ajax({
        url: 'index.php?action=quan-ly-giam-gia', 
        type: 'GET',
        data: { search: searchTerm }, 
        success: function(response) {
            document.getElementById('searchResults').innerHTML = response;
        }
    });
}

</Script>

</html>
