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
$search = isset($_GET['search']) ? $_GET['search'] : '';

// Tạo truy vấn SQL để tìm kiếm món ăn theo tên
$sql = "SELECT ID_MonAn, TenMonAn, MoTa, Gia, GiamGia 
        FROM monan 
        WHERE TinhTrang = '0'";
if (!empty($search)) {
    $sql .= " AND TenMonAn LIKE ?";
}

$stmt = $conn->prepare($sql);
if (!empty($search)) {
    $likeSearch = '%' . $search . '%';
    $stmt->bind_param("s", $likeSearch);
}
$stmt->execute();
$result = $stmt->get_result();

// Xử lý giảm giá đồng loạt
$isUpdated = false; // Biến kiểm tra xem có cập nhật không
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
    <form id="searchForm" class="form-inline mb-4" onsubmit="return submitSearch();">
    <div class="form-group mr-2">
        <label for="search" class="mr-2">Tìm kiếm món ăn:</label>
        <input type="text" id="search" class="form-control" placeholder="Nhập tên món ăn" value="<?php echo htmlspecialchars($search); ?>">
    </div>
    <button type="submit" class="btn btn-primary">Tìm kiếm</button>
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
    
    // Thêm tham số tìm kiếm vào URL
    if (searchTerm) {
        url.searchParams.set('search', searchTerm);
    } else {
        url.searchParams.delete('search');  // Xóa tham số nếu không có giá trị tìm kiếm
    }

    // Cập nhật URL mà không tải lại trang
    window.history.pushState({}, '', url);
    
    // Gửi yêu cầu AJAX hoặc tải lại kết quả tìm kiếm
    loadSearchResults(searchTerm);
}
function loadSearchResults(searchTerm) {
    $.ajax({
        url: 'index.php?action=quan-ly-giam-gia',  // Trang xử lý
        type: 'GET',
        data: { search: searchTerm },  // Truyền tham số tìm kiếm
        success: function(response) {
            // Cập nhật phần nội dung bảng kết quả mà không tải lại trang
            document.getElementById('searchResults').innerHTML = response;
        }
    });
}

</Script>

</html>
