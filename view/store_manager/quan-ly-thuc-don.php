<?php
include_once("../../controller/c_thuc_don.php");
// Xử lý khi người dùng chọn một cửa hàng
if ($idTaiKhoan) {
    $p = new cThucDon();
    $cuaHang = $p->getCuaHang($idTaiKhoan);
}



if ($cuaHang && $cuaHang ->num_rows > 0) {
    while ($row = $cuaHang->fetch_assoc()) {
        $idCuaHang = $row['ID_CuaHang'];
        echo '<h3>Thực đơn tại cửa hàng '.$row['TenCuaHang'].'</h3>';
    }
}

$thucDon = $p->getAllThucDon($idCuaHang);

echo "<table class='table'>
    <thead>
    <tr>
        <th>STT:</th>
        <th>Món ăn</th>
        <th>Số lượng tồn</th>
        <th>Số lượng cần</th>
    </tr>
    </thead>
    <tbody>";

$soLuong = 0;
$i = 1;
if ($thucDon && $thucDon->num_rows > 0) {
    while ($monAn = $thucDon->fetch_assoc()) {
        if ($monAn['TinhTrang'] == 0) {
            echo "<tr><td>". $i ."</td><td>". $monAn['TenMonAn'] ."</td><td>" . $monAn['SoLuongTon'] . "</td>";
            $idMonAn = $monAn['ID_MonAn'];
            echo '<form method="post" id="form_'.$idMonAn.'">
                <td>
                    <input type="number" id="soluong_'.$idMonAn.'" name="soLuong" style="width: 20%;" value="'.$soLuong.'" min="0">
                    <input type="hidden" name="idMonAn" value="'.$idMonAn.'">
                    <input type="submit" name="nhap" class="btn btn-secondary" value="Nhập">
                </td>
                </form>';
            echo "</tr>";
            $i++;
        }   
    }
    echo "</tbody></table>";
} elseif ($thucDon === false) {
    echo "<p>Có lỗi xảy ra khi truy vấn dữ liệu.</p>";
}

// Xử lý khi người dùng nhấn nút "Nhập"
if (isset($_POST['nhap'])) {
    // Lấy thông tin món ăn và số lượng
    $soLuong = isset($_POST['soLuong']) ? (int)$_POST['soLuong'] : 0;
    $idMonAn = isset($_POST['idMonAn']) ? $_POST['idMonAn'] : 0;

    // Kiểm tra số lượng và tiếp tục xử lý
    if ($soLuong > 0 && $idMonAn > 0) {
        // Thêm yêu cầu với số lượng đã nhập
        include_once("../../controller/c_yeu_cau.php");
        $q = new cYeuCau();

        // Cập nhật thông tin số lượng món ăn
        if ($p->setSLT_TD($idCuaHang, $idMonAn, $soLuong) && $NL = $q->getAllNL($idMonAn, $soLuong)) {
            if ($NL && $NL->num_rows > 0) {
                while ($ct = $NL->fetch_assoc()) {
                    if ($p->setNL($ct['ID_NguyenLieu'], $ct['SoLuongCanDung'], $idCuaHang)) {
                        echo '<script language="javascript">
                            alert("Đã gửi yêu cầu thành công!");
                            window.location.href = window.location.href; // Tự động làm mới trang
                            </script>';
                    }
                }
            }
        } else {
            echo "<p>Đã xảy ra lỗi khi gửi yêu cầu.</p>";
        }
    } else {
        echo "<p>Số lượng phải lớn hơn 0. Vui lòng nhập lại.</p>";
    }
}
?>
