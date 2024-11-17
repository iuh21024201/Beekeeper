<style>
    .form-select {
    background-color: #ffffff; 
    border: 1px solid #ced4da; 
    border-radius: 4px; 
    color: #495057; 
    padding: 8px 12px; 
    font-size: 14px; 
    margin-left: 900px;
    margin-bottom: 30px;
    }
</style>
<h2 style="text-align: center;">QUẢN LÝ DANH SÁCH NGUYÊN LIỆU</h2>
<hr>
<div class="container-fluid">
    <div class="col-md-12">
        <div class="col-md-6">
            <a href="index.php?action=them-nguyen-lieu" id="myBtn" class="btn btn-danger">Thêm nguyên liệu</a>
        </div>
        <div class="col-md-6">
        <form action="" method="get">
            <input type="hidden" name="action" value="quan-ly-nguyen-lieu">
            <select name="id_cuahang" class="form-select" style="width: auto; min-width: 200px;" aria-label="Select category " onchange="this.form.submit()">
                <option value="">Tất cả các cửa hàng</option>
                    <?php
                    include_once("../../controller/cCuaHang.php");
                    $p = new cCuaHang();
                    $listCuaHang = $p->getAllStore();
                    
                    
                    if ($listCuaHang) {
                        while ($row = mysqli_fetch_assoc($listCuaHang)) {
                            $selected = (isset($_GET['id_cuahang']) && $_GET['id_cuahang'] == $row['ID_CuaHang']) ? 'selected' : '';
                            echo "<option value='" . $row['ID_CuaHang'] . "' $selected>" . $row['TenCuaHang'] . "</option>";
                        }
                    } else {
                        echo "<option disabled>Không có dữ liệu!</option>";
                    }
                    ?>
            </select>
        </form>
        </div>
    </div>
    
    <div class="card">
        <div class="card-body">
            
            <table class="table">
                <thead class="thead-dark">
                <tr >
                    <th>STT</th>
                    <th>Tên nguyên liệu</th>
                    <th>Đơn vị tính</th>
                    <th>Giá mua</th>
                    <th>Hình ảnh</th>
                    <th>Trạng thái</th>
                    <th>Chức năng</th>
                </tr >
                </thead>
                <tbody>
                    <?php
                        include_once("../../controller/cNguyenLieu.php");
                        $p = new controlNguyenLieu();
            
                        if(isset($_GET['id_cuahang']) && !empty($_GET['id_cuahang'])){
                            $kq = $p->getAllNguyenLieuByCuaHang($_GET['id_cuahang']);
                        }else{
                            $kq = $p->getAllNguyenLieu();
                        }
                        if(!$kq)
                        {
                            echo 'Khong ket noi duoc';
                        }
                        else
                        {
                            $dem = 1;
                            
                            while($r=$kq->fetch_assoc())
                            {
                                echo '<tr>';
                                echo '<td>'.$dem.'</td>';
                                echo '<td>'.$r['TenNguyenLieu'].'</td>';
                                echo '<td>'.$r['DonViTinh'].'</td>';
                                echo '<td>'.number_format($r['GiaMua']).' VNĐ</td>';

                                
                                echo "<td><img src='../../image/nguyenlieu/".$r["HinhAnh"]."' width='70px' height='70px' alt=''></td>";
                                
                                $trangthai = $r['TrangThai'] == 0 ? "Còn hàng" : "Hết hàng";
                                echo '<td>'.$trangthai.'</td>';
                                echo '<td>
                                        <a class="btn btn-warning" href="?action=sua-nguyen-lieu&id_nguyenlieu='.$r["ID_NguyenLieu"].'" id="editBtn">Sửa</a>
                                        <a class="btn btn-primary" href="?action=sua-nguyen-lieu&id_nguyenlieu='.$r["ID_NguyenLieu"].'" onclick="return confirm("Bạn có chắc chắn muốn xóa món ăn này?");" id="deleteBtn">Xóa</a>
                                    </td>';
                                echo '</tr>';
                                $dem++;
                            }
                            echo '</tbody>';
                            echo '</table>';
                        }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
