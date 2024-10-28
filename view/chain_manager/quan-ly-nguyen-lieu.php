<?php
error_reporting(1);
if(isset($_GET['ThemNguyenLieu']))
{
include('them-nguyen-lieu.php');
}

?>
<h2 style="text-align: center;">Quản lý nguyên liệu</h2>
<hr>
<div class="container-fluid">
<p ><a href="index.php?action=ThemNguyenLieu" class="btn btn-primary">Thêm nguyên liệu</a></p>
    <div class="card">
        <div class="card-header">
            <h4>Danh sách sản phẩm</h4>
        </div>
        <div class="card-body">
            <table class="table">
                <thead class="thead-dark">
                <tr >
                    <th>STT</th>
                    <th>Tên nguyên liệu</th>
                    <th>Đơn vị tính</th>
                    <th>Số lượng</th>
                    <th>Giá mua</th>
                    <th>Hình ảnh</th>
                    <th>Trạng thái</th>
                    <th>Chức năng</th>
                </tr >
                </thead>
                <tbody>
                    <?php
                        if(isset($_REQUEST['action']) && $_REQUEST['action'] === 'quan-ly-nguyen-lieu')
                        {
                            include('../../controller/cNguyenLieu.php');
                    
                            // include("controller/cNguyenLieu.php");
                            
                            $p = new CNguyenLieu();
                            $tbl = $p->getAllNL();
                            if(!$tbl)
                            {
                                echo 'Khong ket noi duoc';
                            }
                            elseif($tbl==-1)
                            {
                                echo 'chua co du lieu';
                            }
                            else
                            {
                                $dem = 1;
                                
                                while($r=$tbl->fetch_assoc())
                                {
                                    echo '<tr>';
                                    echo '<td>'.$dem.'</td>';
                                    echo '<td>'.$r['TenNguyenLieu'].'</td>';
                                    echo '<td>'.$r['DonViTinh'].'</td>';
                                    echo '<td>'.$r['DonViTinh'].'</td>';
                                    echo '<td>'.number_format($r['GiaMua']).' VNĐ</td>';
                                    echo "<td><img src='../../image/nguyenlieu/".$r["HinhAnh"]."' width='70px' height='70px' alt=''></td>";
                                    
                                    echo '<td>'.$r['TrangThai'].'</td>';
                                    echo '<td><a href="">Xoá</a>/<a href="index.php?action=sua">Sửa</a></td>';
                                    echo '</tr>';
                                    $dem++;
                                }
                                echo '</tbody>';
                                echo '</table>';
                            }
                        }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
