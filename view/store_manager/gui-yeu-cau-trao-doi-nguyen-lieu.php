<?php
include_once("../../controller/c_xem_so_luong_ban.php");

// Xử lý khi người dùng chọn một cửa hàng
$cuaHangController = new CCuaHang();
$CuaHang = $cuaHangController->get1CuaHang($idTaiKhoan);

// Kiểm tra và lấy ID_CuaHang
if ($CuaHang && $CuaHang->num_rows > 0) {
    while ($row = $CuaHang->fetch_assoc()) {
        $idCuaHang = $row['ID_CuaHang'];
        $nameCuaHang = $row['TenCuaHang'];
        echo "<h2>Thực đơn của cửa hàng: <span class='text-danger'>" .$nameCuaHang." </span></h2>";
    }
} else {
    die("Không tìm thấy cửa hàng.");
}
?>

<table class="table">
<?php
echo "<thead>
      <tr>
        <th>Tên món: </th>
        <th>Số lượng tồn: </th>
        <th></th>
      </tr>
    </thead>";
// Lấy thực đơn
include_once("../../controller/c_gui_yeu_cau.php");
$p = new cMonAn();
$listMonAn = $p->getAllMonAn($idCuaHang);
if ($listMonAn) {
    if ($listMonAn->num_rows > 0) {
        while ($monAn = $listMonAn->fetch_assoc()) {
            $idMonAn = $monAn['ID_MonAn'];
            echo "<tr>";
            echo "<td>" . $monAn['TenMonAn'] . "</td>";
            echo "<td>" . $monAn['SoLuongTon'] . "</td>";
            echo "<td>";
            echo '<button><a href="?action=trao-doi&id='.$idMonAn.'" class= "text-decoration-none text-body" >Gửi yêu cầu</a></button>';
            echo "</td>";
            echo "</tr>";
        }
    }
} elseif ($listMonAn === false) {
    echo "<p>Có lỗi xảy ra khi truy vấn dữ liệu.</p>";
}
?>



