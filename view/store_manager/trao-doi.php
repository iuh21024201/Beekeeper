<?php
// Lấy giá trị id món ăn từ URL
$idMonAn = $_REQUEST['id'];
// $date = date("Y-m-d");
// echo '<h1>'.$date.'</h1>';
// Lấy cửa hàng
include_once("../../controller/c_xem_so_luong_ban.php");
$cuaHangController = new CCuaHang();
$CuaHang = $cuaHangController->get1CuaHang($idTaiKhoan);
if ($CuaHang && $CuaHang->num_rows > 0) {
    $row = $CuaHang->fetch_assoc();
    $idCuaHang = $row['ID_CuaHang'];
} else {
    die("Không tìm thấy cửa hàng.");
}

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
if (isset($_POST['xem']) || isset($_POST['guiyeucau'])) {
    $soluong = isset($_POST['soluong']) ? (int)$_POST['soluong'] : 0;
}

$p = new cMonAn();
$InfoNL = $p->getInfoNguyenLieu($idMonAn, $soluong);
?>

<!-- Form nhập số lượng -->
<form method="POST" action="">
    <div>
        <label for="soluong">Nhập số lượng:</label>
        <input type="number" id="soluong" name="soluong" value="<?php echo $soluong; ?>" min="0">
        <button type="submit" name="xem">Xem</button>
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
echo '<table class="table">
<td><b>Nguyên liệu:</b></td>
<td><b>Số lượng:</b></td>';
if (isset($_POST['xem'])) {
    if ($p && $InfoNL->num_rows > 0) {
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
                <input type="hidden" name="soluong" value="' . $soluong . '">
                <button type="submit" name="guiyeucau" value="guiyeucau">Gửi yêu cầu</button>
            </form>
        </td>
</table>';
}
if (isset($_POST['guiyeucau'])) {
    // Thêm yêu cầu với số lượng đã nhập
    if ($q->addYeuCauNguyenLieu($idCuaHang, $idMonAn, $soluong)) {
        echo '<script language="javascript">
        alert("Đã gửi yêu cầu thành công!");
        window.location.href = "index.php?action=gui-yeu-cau-trao-doi-nguyen-lieu";
        </script>';
    } else {
        echo "<p>Đã xảy ra lỗi khi gửi yêu cầu.</p>";
    }
}
?>
