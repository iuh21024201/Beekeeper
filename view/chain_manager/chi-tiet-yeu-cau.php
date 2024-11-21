<h3>Món ăn được yêu cầu:</h3>
<?php
// Lấy idCuaHang từ request nếu có
$idCuaHang = $_REQUEST['id'] ?? null;
$idMonAn = $_REQUEST['idyc'] ?? null;
include_once("../../controller/c_yeu_cau.php");
$p = new cYeuCau();
$listYC = $p->getAllYeuCau($idCuaHang, $idMonAn);
?>

<div class="table-responsive">
    <table class="table table-bordered table-hover">
        <thead class="thead-dark">
            <tr>
                <th>Món ăn</th>
                <th>Số lượng cần</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if ($p) {
                if ($listYC->num_rows > 0) {
                    while ($YC = $listYC->fetch_assoc()) {
                        if($YC['TrangThai'] == 0){
                            echo '<tr>';
                            echo '<td><strong>' . $YC['TenMonAn'] . '</strong></td>';
                            echo '<td><strong>' . $YC['SoLuong'] . '</strong></td>';
                            echo '</tr>';

                            // Lấy tất cả các cửa hàng liên quan đến món ăn này
                            $listCH = $p->getAllCHConMonAn($YC['ID_MonAn'], $idCuaHang);
                            echo '<tr>';
                            echo '<td colspan="2">
                                    <table class="table table-sm table-secondary mb-3">
                                        <thead>
                                            <tr>
                                                <th>Cửa hàng:</th>
                                                <th>Số lượng</th>
                                                <th>Chọn</th>
                                            </tr>
                                        </thead>
                                        <tbody>';

                            if ($listCH->num_rows > 0) {
                                while ($CH = $listCH->fetch_assoc()) {
                                    echo '<tr>
                                            <td>' . $CH['TenCuaHang'] . '</td>
                                            <td>' . $CH['SoLuongTon'] . '</td>';
                                    if($CH['SoLuongTon'] > $YC['SoLuong'])    {   
                                            echo '<td>
                                                <form method="POST" action="">
                                                    <input type="hidden" name="ID_CuaHang" value="' . $CH['ID_CuaHang'] . '">
                                                    <button type="submit" class="btn btn-primary btn-sm">Chọn</button>
                                                </form>
                                            </td>
                                        </tr>';
                                    }else {
                                        echo '<td>Không đủ số lượng cần.</td>';
                                    }  
                                }
                            }
                            echo '        </tbody>
                                    </table>
                                </td>';
                            echo '<tr>
                                <td colspan = 2>
                                    <form method="POST" action="">
                                        <input type="submit" name="btn" class="btn btn-danger" value="Xóa">
                                        <input type="submit" name="btn" class="btn btn-secondary" value="Thoát">
                                    </form>
                                </td>
                            </tr>';
                            echo '</tr>';

                            // Xử lý nếu có dữ liệu POST
                            if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['ID_CuaHang'])) {
                                $cuaHangGuiNL = $_POST['ID_CuaHang'];

                                // Gọi phương thức để xử lý khi chọn cửa hàng
                                if ($p->setCH_Gui($cuaHangGuiNL, $idCuaHang, $YC['ID_MonAn'], $YC['SoLuong']) == 1) {
                                    $listNL = $p->getAllNL($YC['ID_MonAn'], $YC['SoLuong']);

                                    // Kiểm tra nếu có nguyên liệu liên quan
                                    if ($listNL->num_rows > 0) {
                                        while ($NL = $listNL->fetch_assoc()) {
                                            // Cập nhật số lượng tồn nguyên liệu
                                            if ($p->setSLT_CTNL($NL['ID_NguyenLieu'], $NL['SoLuongCanDung'], $idCuaHang, $cuaHangGuiNL) == 1) {
                                                // Nếu thành công, có thể thêm thông báo hoặc xử lý khác
                                                echo '<script language="javascript">
                                                    alert("Đã duyệt món mới!");
                                                    window.location.href = "index.php?action=duyet-yeu-cau-bo-sung-nguyen-lieu";
                                                    </script>';
                                            }
                                        }
                                    }
                                }
                            }else if(isset($_POST['btn'])){
                                switch ($_POST['btn']) {
                                    case 'Xóa':
                                        if ($p->setXoaYC($YC['ID_YeuCau']) == 1) {
                                            echo '<script language="javascript">
                                                alert("Xóa thành công");
                                                window.location.href = "index.php?action=duyet-yeu-cau-bo-sung-nguyen-lieu";
                                            </script>';
                                        } else {
                                            echo '<script language="javascript">
                                                alert("Xóa thất bại!");
                                                window.history.go(-2);
                                            </script>';
                                        }
                                        break;
                                        case 'Thoát':
                                            echo '<script language="javascript"> window.location.href = "index.php?action=duyet-yeu-cau-bo-sung-nguyen-lieu";
                                            </script>';
                                        break;
                                }
                            }
                        }
                    }
                } else {
                    echo '<tr><td colspan="2">Không có món mới nào được đề xuất.</td></tr>';
                }
            } else {
                echo '<tr><td colspan="2">Có lỗi xảy ra khi truy vấn dữ liệu.</td></tr>';
            }
            ?>
        </tbody>
    </table>
</div>
