<?php
include_once("../../controller/c_xem_so_luong_ban.php");
// Xử lý khi người dùng chọn một cửa hàng
$cuaHangController = new CCuaHang();
$CuaHang = $cuaHangController->get1CuaHang($idTaiKhoan);

// lấy thực đơn
include_once("../../controller/c_gui_yeu_cau.php");
$p = new cMonAn();
$listMonAn = $p->getAllMonAn($idCuaHang);
?>

<?php
if ($CuaHang && $CuaHang->num_rows > 0) {
    while ($row = $CuaHang->fetch_assoc()) {
      $idCuaHang = $row['ID_CuaHang'];  
    }
}


?>