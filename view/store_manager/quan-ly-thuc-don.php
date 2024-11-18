<?php
include_once("../../controller/c_xem_so_luong_ban.php");
// lấy cửa hàng 
$cuaHangController = new CCuaHang();
$tenCuaHang = $cuaHangController->get1CuaHang($idTaiKhoan);

    if ($tenCuaHang && $tenCuaHang->num_rows > 0) {
        while ($row = $tenCuaHang->fetch_assoc()) {
            echo "<h2>Danh sách thực đơn của cửa hàng: <span class='text-danger'>" . $row['TenCuaHang'] . "</span></h2>";
            $idCuaHang = $row['ID_CuaHang'];
        }
    }
include_once("../../controller/c_quan_ly_thuc_don.php");
$p = new cThucDon();
$listThucDon = $p ->getThucDon($idCuaHang);
?>

<table class="table">
    <thead>
      <tr>
        <th>Tên món ăn:</th>
        <th>Số suất còn lại:</th>
        <th>Nhập số suất:</th>
      </tr>
    </thead>
    <tbody>
<?php
if($listThucDon) {
    if ($listThucDon->num_rows > 0) {
        while ($thucDon = $listThucDon->fetch_assoc()) {
        echo "<th>". $thucDon['TenMonAn'] ."</th>", "<th>".$thucDon['SoLuongTon']."</th>";
        echo "<th>""</th>"
        echo "</tr>";
        echo "<tr>";
        }
        echo "</tr>";
    } else {
        echo "<p>Không có bàn nào trong cửa hàng này.</p>";
    }
} elseif ($selectedCuaHang && $listBan === false) {
    echo "<p>Có lỗi xảy ra khi truy vấn dữ liệu.</p>";
}
?>
      <!-- <tr>
        <td>July</td>
        <td>Dooley</td>
        <td>july@example.com</td>
      </tr> -->
    </tbody>
  </table>
