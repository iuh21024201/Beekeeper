<?php
include_once("../../controller/c_xem_so_luong_ban.php");
// Xử lý khi người dùng chọn một cửa hàng
if ($idTaiKhoan) {
    $banController = new CBan();
    $listBan = $banController->getBan1CH($idTaiKhoan);
}

$cuaHangController = new CCuaHang();
$tenCuaHang = $cuaHangController->get1CuaHang($idTaiKhoan);
?>
<!-- <h1>

</h1> -->
    <table class="table">
    <!-- Hiển thị danh sách bàn nếu đã chọn cửa hàng -->
    <?php
    if ($tenCuaHang && $tenCuaHang->num_rows > 0) {
        while ($row = $tenCuaHang->fetch_assoc()) {
            echo "<h2>Danh sách bàn của cửa hàng: <span class='text-danger'>" . $row['TenCuaHang'] . "</span></h2>";
        }
    }
    // echo "<h2>Danh sách bàn của cửa hàng:" .$row['TenCuaHang']. " </h2>";
    echo "<thead>
            <tr>
                <th>Mã bàn:</th>
                <th colspan = 2>Tình Trạng</th>
            </tr>
          </thead>
          <tbody>
            <tr>";
    if ($listBan) {
        if ($listBan->num_rows > 0) {
            while ($ban = $listBan->fetch_assoc()) {
                if ($ban['TinhTrang'] == 0) {
                    $color = 'text-danger';
                    $tinh_trang = 'Trống';
                } else {
                    $color = 'text-success';
                    $tinh_trang = 'Có khách';
                }
            echo "<td>". $ban['TenBan'] ."</td>" , "<td class='".$color."'>" . $tinh_trang . "</td>";
            echo        "</tr>";
            echo        "<tr>";
            }
            echo "</tr>";
        } else {
            echo "<p>Không có bàn nào trong cửa hàng này.</p>";
        }
    } elseif ($listBan === false) {
        echo "<p>Có lỗi xảy ra khi truy vấn dữ liệu.</p>";
    }
    ?>
    </tbody>
    </table>
    





