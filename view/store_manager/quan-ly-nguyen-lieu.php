<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
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
            width: 300px;
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
    include_once("../../controller/c_xem_so_luong_ban.php");
    include_once("../../controller/cNguyenLieu.php");
    $p = new controlNguyenLieu();
    // Xử lý khi người dùng chọn một cửa hàng
    $cuaHangController = new CCuaHang();
    $CuaHang = $cuaHangController->get1CuaHang($idTaiKhoan);  
    if ($CuaHang && $CuaHang->num_rows > 0) {
        while ($row = $CuaHang->fetch_assoc()) {
            $idCuaHang = $row['ID_CuaHang'];
            $tenCuaHang = $row['TenCuaHang']; // Lấy tên cửa hàng từ kết quả truy vấn
        }
    } else {
        die("Không tìm thấy cửa hàng.");
    }     
    if (isset($_POST['delete'])) {
        $id = $_POST['id'];
    
        // Cập nhật trạng thái nguyên liệu thành "không sử dụng"
        $result = $p->updateTrangThaiNguyenLieu($id); // 1 là trạng thái "không sử dụng"
    
        if ($result) {
            // Chuyển hướng về trang quản lý nguyên liệu sau khi cập nhật thành công
            echo "<script>alert('Đã cập nhật trạng thái thành không sử dụng.');</script>";
            
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
            </form>
        </div>
        <p>Tên cửa hàng: <strong><?php echo $tenCuaHang; ?></strong> </p>
        <table class="table table-bordered">
            <thead style="text-align: center;">
                <tr>
                    <th>STT</th>
                    <th>Tên nguyên liệu</th>
                    <th>Đơn vị tính</th>
                    <th>Giá mua</th>
                    <th>Số lượng</th>
                    <th>Hình ảnh</th>
                    <th>Trạng thái</th>
                    <th>Chức năng</th>
                </tr>
            </thead>            
            <tbody>
                <?php
                // Kiểm tra và lấy ID_CuaHang
                $cuaHangController = new CCuaHang();
                $CuaHang = $cuaHangController->get1CuaHang($idTaiKhoan);  
                if ($CuaHang && $CuaHang->num_rows > 0) {
                    while ($row = $CuaHang->fetch_assoc()) {
                        $idCuaHang = $row['ID_CuaHang'];
                        if (isset($_REQUEST['btnTimKiem']) && !empty($_REQUEST['txtname'])) {
                            $kq = $p->getAllNguyenLieuByName($_REQUEST['txtname']);
                        } else {
                            // Lấy danh sách nguyên liệu của cửa hàng người dùng đang đăng nhập
                            $kq = $p->getAllNguyenLieuByCuaHangSX($idCuaHang);
                        }
                    }
                } else {
                    die("Không tìm thấy cửa hàng.");
                }
                if (!$kq) {
                    echo 'Không có dữ liệu';
                } else {
                    $dem = 1;
                    while ($r = $kq->fetch_assoc()) {
                        echo '<tr>';
                        echo '<td style="text-align: center;">' . $dem . '</td>';
                        echo '<td>' . $r['TenNguyenLieu'] . '</td>';
                        echo '<td>' . $r['DonViTinh'] . '</td>';
                        echo '<td style="text-align: center;">' . number_format($r['GiaMua']) . ' VNĐ</td>';
                        echo '<td style="text-align: center;">' . $r['SoLuong'] . '</td>';
                        echo '<td style="text-align: center;"><img src="../../image/nguyenlieu/' . $r["HinhAnh"] . '" width="70px" height="70px"></td>';
                        // Hiển thị trạng thái nguyên liệu
                        if ($r["TrangThai"] == 0) {
                            $trangThai = "Còn nguyên liệu";
                            $classTrangThai = "text-success";
                        } elseif ($r["TrangThai"] == 1) {
                            $trangThai = "Hết nguyên liệu";
                            $classTrangThai = "text-danger";
                        }else{
                            $trangThai = "Không sử dụng";
                            $classTrangThai = "text-dark"; 
                        }
                        echo '<td class="' . $classTrangThai . '" style="text-align: center;">' . $trangThai . '</td>';
                        echo '<td style="text-align: center;">
                            <a class="btn btn-warning" href="?action=sua-nguyen-lieu&id_nguyenlieu=' . $r["ID_NguyenLieu"] . '" id="editBtn">Sửa</a>
                            <button class="btn btn-danger" onclick="confirmDelete(' . $r['ID_NguyenLieu'] . ')">Xóa</button>
                            <form id="deleteForm' . $r['ID_NguyenLieu'] . '" method="POST" action="" style="display:none;">
                                <input type="hidden" name="id" value="' . $r['ID_NguyenLieu'] . '">
                                <input type="hidden" name="delete">
                            </form>
                        </td>';
                        echo '</tr>';
                        $dem++;
                    }
                }
                ?>
            </tbody>
        </table>
    </div>
    <script>
        function confirmDelete(id) {
            if (confirm('Bạn có chắc chắn muốn chuyển trạng thái nguyên liệu này thành "Không sử dụng"?')) {
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