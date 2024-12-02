<?php
// Lấy giá trị id món ăn từ URL
$idMonAn = $_REQUEST['id'];
$idCuaHang = $_REQUEST['idch'];

// Hiển thị thông tin món ăn
include_once("../../controller/c_gui_yeu_cau.php");
$q = new cMonAn();
$listMonAn = $q->get1MonAn($idMonAn);
if ($listMonAn && $listMonAn->num_rows > 0) {
    while ($monAn = $listMonAn->fetch_assoc()) {
        echo "<h2>Thông tin nguyên liệu: " . $monAn['TenMonAn'] . "</h2>";
    }
} elseif ($listMonAn === false) {
    echo "<p>Có lỗi xảy ra khi truy vấn dữ liệu.</p>";
}

// Nếu form được gửi, lấy giá trị số lượng từ input
$soluong = 0;
if (isset($_POST['xem']) || isset($_POST['nhap'])) {
    $soluong = isset($_POST['soluong']) ? (int)$_POST['soluong'] : 0;
}

$InfoNL = $q->getInfoNguyenLieu($idMonAn, $soluong);

?>

<!-- Form nhập số lượng -->
<form method="POST" action="">
    <div>
        <label for="soluong">Nhập số lượng:</label>
        <input type="number" id="soluong" name="soluong" value="<?php echo $soluong; ?>" min="0">
        <button type="submit" class ="btn btn-danger" name="xem">Xem</button>
        <button type="button" class="btn btn-secondary" onclick="window.location.href='index.php?action=quan-ly-thuc-don';">Thoát</button>
    </div>
</form>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const form = document.querySelector("form");
        const inputSoLuong = document.getElementById("soluong");

        form.addEventListener("submit", function(event) {
            // Kiểm tra số lượng
            const soLuong = parseInt(inputSoLuong.value);
            if (isNaN(soLuong) || soLuong <= 0) {
                event.preventDefault(); // Ngăn form gửi đi
                alert("Số lượng phải lớn hơn 0. Vui lòng nhập lại!");
                inputSoLuong.focus();
                return false;
            }
        });
    });
</script>

<?php

if (isset($_POST['xem'])) {
    echo '<table class="table">
    <td><b>Nguyên liệu:</b></td>
    <td><b>Số lượng:</b></td>';
    if ($q && $InfoNL->num_rows > 0) {
        while ($monAn = $InfoNL->fetch_assoc()) {
            echo '
            <tr>
                <td>' . $monAn['TenNguyenLieu'] . '</td>
                <td>' . $monAn['SoLuongCanDung'] . '</td>
            </tr>';
        }
    } else {
        echo "<p>Lỗi khi tải thông tin nguyên liệu.</p>";
    }
    echo '<td colspan="2">
            <form method="POST" action="">
                <input type="hidden" name="idMonAn" value="'.$idMonAn.'">
                <input type="hidden" name="idCuaHang" value="'.$idCuaHang.'">
                <input type="hidden" name="soluong" value="'.$soluong.'">
                <button class="btn btn-success"  type="submit" name="nhap">Nhập</button>
            </form>
        </td>
</table>';
}

if (isset($_POST['nhap'])) {
        // Lấy thông tin món ăn và số lượng
        // $soLuong = isset($_POST['soLuong']) ? (int)$_POST['soLuong'] : 0;
        // $idMonAn = isset($_POST['idMonAn']) ? $_POST['idMonAn'] : 0;
        // $idCuaHang = isset($_POST['idCuaHang']) ? $_POST['idCuaHang'] : 0;

        
        include_once("../../controller/c_thuc_don.php");
        $thucDon = new cThucDon();
        // Kiểm tra số lượng và tiếp tục xử lý
        if ($soluong > 0 && $idMonAn > 0) {
            // Thêm yêu cầu với số lượng đã nhập
            include_once("../../controller/c_yeu_cau.php");
            $xemTD = new cYeuCau();
            // Cập nhật thông tin số lượng món ăn
            if ($thucDon->setSLT_TD($idCuaHang, $idMonAn, $soluong) && $NL = $xemTD->getAllNL($idMonAn, $soluong)) {
                if ($NL && $NL->num_rows > 0) {
                    while ($ct = $NL->fetch_assoc()) {
                        $idNL = $ct['ID_NguyenLieu'];
                        $sl = $ct['SoLuongCanDung'];
                        if ($thucDon->setNL($idNL, $sl, $idCuaHang)) {
                            echo '<script language="javascript">
                                alert("Đã gửi yêu cầu thành công!");
                                window.location.href = "index.php?action=quan-ly-thuc-don"; // Tự động làm mới trang
                                </script>';
                        }
                    }
                }
            }
        }
}
?>
