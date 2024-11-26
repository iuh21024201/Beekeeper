<?php
include_once("../../controller/c_xem_so_luong_ban.php");

// Khởi tạo đối tượng CCuaHang để lấy danh sách cửa hàng
$cuaHangController = new CCuaHang();
$listCuaHang = $cuaHangController->getAllCuaHang();

// Xử lý khi người dùng chọn một cửa hàng
$selectedCuaHang = isset($_POST['id_cuahang']) ? $_POST['id_cuahang'] : null;
$listBan = null;
if ($selectedCuaHang) {
    $banController = new CBan();
    $listBan = $banController->getAllBan($selectedCuaHang);
}
?>
<table class="table">
<thead>
    <tr>
    <th>Chọn cửa hàng:</th>
    <th colspan = 2 style="padding: 12px;">
        <!-- Form để chọn cửa hàng -->
        <form action="" method="post">
            <select id="id_cuahang" name="id_cuahang" class="form-xslb">
                <option value="">-- Chọn cửa hàng --</option>
                <?php
                // Kiểm tra nếu có dữ liệu cửa hàng
                if ($listCuaHang && $listCuaHang->num_rows > 0) {
                    while ($row = $listCuaHang->fetch_assoc()) {
                        echo "<option value='" . $row['ID_CuaHang'] . "'";
                        if ($selectedCuaHang == $row['ID_CuaHang']) echo " selected";
                        echo ">" . $row['TenCuaHang'] . "</option>";
                    }
                } else {
                    echo "<option value=''>Không có cửa hàng</option>";
                }
                ?>
            </select>
            <button class="btn btn-danger" type="submit">Xem Bàn</button>
        </form>
        </th>
    </tr>
</thead>
<!-- Hiển thị danh sách bàn nếu đã chọn cửa hàng -->
<tbody>
<tr>
<?php
echo "<h2>Danh sách bàn của cửa hàng: </h2>";
echo "<thead>
        <tr>
            <th>STT:</th>
            <th>Mã bàn:</th>
            <th colspan = 2>Tình Trạng</th>
        </tr>
        </thead>
        <tbody>
        <tr>";
$i = 1;
if ($selectedCuaHang && $listBan) {
    if ($listBan->num_rows > 0) {
        while ($ban = $listBan->fetch_assoc()) {
            if ($ban['TinhTrang'] == 0) {
                $color = 'text-danger';
                $tinh_trang = 'Trống';
            } else {
                $color = 'text-success';
                $tinh_trang = 'Có khách';
            }
        
        echo "<td>". $i ."</td>", "<td>". $ban['TenBan'] ."</td>" , "<td class='".$color."'>" . $tinh_trang . "</td>";
        echo        "</tr>";
        echo        "<tr>";
        $i++;
        }
        echo "</tr>";
    } else {
        echo "<p>Không có bàn nào trong cửa hàng này.</p>";
    }
} elseif ($selectedCuaHang && $listBan === false) {
    echo "<p>Có lỗi xảy ra khi truy vấn dữ liệu.</p>";
}
?>
</tbody>
</table>






