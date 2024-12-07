<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý nguyên liệu</title>
    <style>
        .form-select {
            background-color: #ffffff; 
            border: 1px solid #ced4da; 
            border-radius: 4px; 
            color: #495057; 
            padding: 8px 12px; 
            font-size: 14px; 
            margin-left: 540px;
        }
        .txtTimKiem{
            width: 500px;
            margin-top:10px;
        }
        form{
            display: flex;
            margin:30px 0;
        }
        form .btn {
            margin-left: 10px;
            padding: 8px 16px;
            font-size: 13px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            transition: all 0.3s ease;
        }
    </style>
</head>
<?php
include_once("../../controller/cCuaHang.php");
include_once("../../controller/cNguyenLieu.php");

$p = new controlNguyenLieu();
if (isset($_POST['delete'])) {
    $id = $_POST['id'];
    // Cập nhật trạng thái nguyên liệu thành "Hết nguyên liệu"

    // Gọi phương thức để cập nhật trạng thái
    $result = $p->updateTrangThaiNguyenLieu($id);

    if ($result) {
        // Chuyển hướng về trang quản lý nguyên liệu sau khi cập nhật thành công
        echo "<script>alert('Đã cập nhật trạng thái thành hết nguyên liệu.');</script>";
        
    } else {
        echo "<script>alert('Cập nhật trạng thái thất bại. Vui lòng thử lại.');</script>";
    }
}
?>
<body>
    <div class="container-fluid">
        <h2 style="text-align: center;">QUẢN LÝ DANH SÁCH NGUYÊN LIỆU</h2>
        <hr>
        <a href="index.php?action=them-nguyen-lieu" id="myBtn" class="btn btn-danger">Thêm nguyên liệu</a>
        <div class="search-bar">
            <form action="" method="get">
                <input type="text" name="txtname" id="txtTimKiem" class="form-control me-2 txtTimKiem" placeholder="Tìm kiếm nguyên liệu">
                <button class="btn btn-primary me-2" name="btnTimKiem">Tìm kiếm</button>
                <button type="reset" class="btn btn-secondary me-2" onclick="resetForm()">Reset</button>
                <input type="hidden" name="action" value="quan-ly-nguyen-lieu">
                    <select name="id_cuahang" class="form-select" style="width: auto; min-width: 200px;" aria-label="Select category " onchange="this.form.submit()">
                        <option value="">Tất cả các cửa hàng</option>
                            <?php
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
        <table class="table table-bordered">
            <thead style="text-align: center;">
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
                    $p = new controlNguyenLieu();
                    if(isset($_GET['id_cuahang']) && !empty($_GET['id_cuahang'])){
                        $kq = $p->getAllNguyenLieuByCuaHang($_GET['id_cuahang']);
                    }elseif(isset($_REQUEST['btnTimKiem'])){
                        $kq = $p -> getAllNguyenLieuByName($_REQUEST['txtname']);
                    }else{
                        $kq = $p->getAllNguyenLieuBySX();
                    }
                    if(!$kq)
                    {
                        echo 'Không có dữ liệu';
                    }
                    else
                    {
                        $dem = 1;
                        while($r=$kq->fetch_assoc())
                        {
                            echo '<tr>';
                            echo '<td style="text-align: center;">'.$dem.'</td>';
                            echo '<td>'.$r['TenNguyenLieu'].'</td>';
                            echo '<td>'.$r['DonViTinh'].'</td>';
                            echo '<td style="text-align: center;">'.number_format($r['GiaMua']).' VNĐ</td>';             
                            echo '<td style="text-align: center;"><img src="../../image/nguyenlieu/'.$r["HinhAnh"].'" width="70px" height="70px"></td>';
                            // Kiểm tra và hiển thị trạng thái nguyên liệu
                            if ($r["SoLuong"] == 0) {
                                $trangThai = "Hết nguyên liệu";
                                $classTrangThai = "text-danger";  // Màu đỏ cho "Hết nguyên liệu"
                            } else {
                                // Nếu số lượng khác 0, kiểm tra trạng thái từ cơ sở dữ liệu
                                if ($r["TrangThai"] == 0) {
                                    $trangThai = "Còn nguyên liệu";
                                    $classTrangThai = "text-success";  // Màu xanh cho "Còn nguyên liệu"
                                } elseif ($r["TrangThai"] == 1) {
                                    $trangThai = "Hết nguyên liệu";
                                    $classTrangThai = "text-danger";  // Màu đỏ cho "Hết nguyên liệu"
                                } else {
                                    // Nếu không có giá trị hợp lệ, cần gán giá trị mặc định cho biến classTrangThai
                                    $trangThai = "Chưa xác định";
                                    $classTrangThai = "text-warning";  // Màu vàng cho "Chưa xác định"
                                }
                            }
                            echo '<td class="'.$classTrangThai.'" style="text-align: center;">'.$trangThai.'</td>';
                            echo '<td style="text-align: center;">
                                <a class="btn btn-warning" href="?action=sua-nguyen-lieu&id_nguyenlieu='.$r["ID_NguyenLieu"].'" id="editBtn">Sửa</a>
                                <button class="btn btn-danger" onclick="confirmDelete(' . $r['ID_NguyenLieu'] . ')">Xóa</button>
                                <form id="deleteForm' . $r['ID_NguyenLieu'] . '" method="POST" action="" style="display:none;">
                                    <input type="hidden" name="id" value="' . $r['ID_NguyenLieu'] . '">
                                    <input type="hidden" name="delete">
                                </form>
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
    <script>
        function confirmDelete(id) {
            if (confirm('Bạn có chắc chắn muốn chuyển nguyên liệu này thành "Hết nguyên liệu"?')) {
                document.getElementById('deleteForm' + id).submit();
            }
        }
        function resetForm() {
            // Đặt lại giá trị của các trường nhập
            document.getElementById('txtTimKiem').value = '';
            const selectElement = document.querySelector('select[name="id_cuahang"]');
            if (selectElement) selectElement.value = '';

            // Tải lại trang để làm mới danh sách
            window.location.href = '?action=quan-ly-nguyen-lieu';
        }
    </script>
</body>
</html>


