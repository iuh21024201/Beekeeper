<?php
if(session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Kết nối cơ sở dữ liệu
$servername = "localhost";
$username = "root";
$password = "";
$database = "db_beekeeper_8"; 

$conn = new mysqli($servername, $username, $password, $database);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error); 
}

// Xử lý giảm giá đồng loạt
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['bulk_discount'])) {
        $discount = $_POST['bulk_discount'];

        // Cập nhật giảm giá cho tất cả món ăn
        $sql = "UPDATE monan SET GiamGia = ? WHERE TinhTrang = 'Còn bán'";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $discount);
        if ($stmt->execute()) {
            echo "<script>alert('Cập nhật giảm giá đồng loạt thành công');</script>";
        } else {
            echo "<script>alert('Có lỗi xảy ra khi cập nhật giảm giá đồng loạt');</script>";
        }
    }

    // Cập nhật giảm giá về 0% sau khi hết ngày
    $currentDate = date("Y-m-d");
    $sql = "UPDATE monan SET GiamGia = 0 WHERE TinhTrang = 'Còn bán' AND GiamGia > 0 AND CURDATE() > DATE_ADD(Now(), INTERVAL 1 DAY)";
    $conn->query($sql);
}

// Lấy danh sách món ăn
$sql = "SELECT ID_MonAn, TenMonAn, MoTa, Gia, GiamGia FROM monan WHERE TinhTrang = 'Còn bán'";
$result = $conn->query($sql);
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
    
    <!-- Form giảm giá đồng loạt -->
    <form method="POST" action="">
      <div class="form-group">
        <label for="bulk_discount">Chọn mức giảm giá (%) cho tất cả món ăn:</label>
        <select name="bulk_discount" id="bulk_discount" class="form-control" style="width: 120px;">
          <?php for ($i = 0; $i <= 50; $i+=5): ?>
            <option value="<?php echo $i; ?>"><?php echo $i; ?>%</option>
          <?php endfor; ?>
        </select>
      </div>
      <button type="submit" class="btn btn-success">Áp dụng giảm giá đồng loạt</button>
    </form>

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
                <input type="hidden" name="id_monan" value="<?php echo $row['ID_MonAn']; ?>">
                <select name="discount" class="form-control" style="width: 120px;">
                  <?php for ($i = 0; $i <= 50; $i+=10): ?>
                    <option value="<?php echo $i; ?>" <?php echo ($i == $row['GiamGia']) ? 'selected' : ''; ?>>
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

</html>
