<div>
<h2 class="text-center">Thông tin món mới</h2>
<?php
$idMonMoi = $_REQUEST['id'];
include_once("../../controller/c_info_monmoi.php");
$p = new cInfoMonMoi();
$infoMonMoi = $p->getInfoMonMoi($idMonMoi);

if ($p) {
    if ($infoMonMoi->num_rows > 0) {
        echo '<table class="table">';
        while ($monMoi = $infoMonMoi->fetch_assoc()) {       
            echo '
            <tr>
                <td><b>Tên món:</b></td>
                <td>'.htmlspecialchars($monMoi['TenMon']).'</td>
            </tr>
            <tr>
                <td><b>Danh sách nguyên liệu:</b></td>
                <td>'.htmlspecialchars($monMoi['NguyenLieu']).'</td>
            </tr>
            <tr>
                <td><b>Mô tả:</b></td>
                <td>'.htmlspecialchars($monMoi['MoTa']).'</td>
            </tr>
            <tr>
                <td><b>Giá:</b></td>
                <td>' . number_format($monMoi['Gia'], 0, ',', '.') . ' VNĐ</td>
            </tr>
            <tr>
                <td><b>Nhân viên đề xuất:</b></td>
                <td>'.htmlspecialchars($monMoi['HoTen']).'</td>
            </tr>
            <tr>
                <td><b>Hình ảnh:</b></td>
                <td><img src="../../image/monmoi/'.htmlspecialchars($monMoi['HinhAnh']).'" style="max-width: 300px; max-height: 300px;" /></td>
            </tr>
            <tr>
                <td><b>Ngày đề xuất:</b></td>
                <td>'.htmlspecialchars($monMoi['Ngay']).'</td>
            </tr>';
            if($monMoi['TrangThai'] == 0){
                echo '
                <tr>
                    <td>
                        <form method="post">
                            <input type="submit" name="btn" class="btn btn-success" value="Duyệt">
                            <input type="submit" name="btn" class="btn btn-danger" value="Xóa">
                        </form>
                    </td>
                    <td>';
            }else {
                echo '<tr>
                        <td colspan="2">';
            }
        }
        echo '        
                
                    <button onclick="window.history.back()" class="btn btn-secondary">Thoát</button>
                </td>
            </tr>
        </table>';
    } else {
        echo "<p>Không có món mới nào được đề xuất.</p>";
    }
} else {
    echo "<p>Có lỗi xảy ra khi truy vấn dữ liệu.</p>";
}
?>

<?php
if (isset($_POST['btn'])) {
    switch ($_POST['btn']) {
        case 'Duyệt':
            if ($p->statusChange($idMonMoi) == 1) {
                echo '<script language="javascript">
                    alert("Đã duyệt món mới!");
                    window.history.go(-2);
                </script>';
            } else {
                echo '<script language="javascript">
                    alert("Duyệt thất bại!");
                    window.history.go(-2);
                </script>';
            }
            break;
        case 'Xóa':
            if ($p->statusChange_1($idMonMoi) == 1) {
                echo '<script language="javascript">
                    alert("Xóa thành công");
                    window.history.go(-2);
                </script>';
            } else {
                echo '<script language="javascript">
                    alert("Xóa thất bại!");
                    window.history.go(-2);
                </script>';
            }
            break;
    }
}
?>
</div>
