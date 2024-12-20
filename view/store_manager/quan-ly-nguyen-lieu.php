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
        .txtTimKiem {
            width: 300px;
            margin-top:10px;
        }
        form {
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
    $cuaHangController = new CCuaHang();
    // Lấy thông tin cửa hàng của người dùng
    $CuaHang = $cuaHangController->get1CuaHang($idTaiKhoan);  
    if ($CuaHang && $CuaHang->num_rows > 0) {
        while ($row = $CuaHang->fetch_assoc()) {
            $idCuaHang = $row['ID_CuaHang'];
            $tenCuaHang = $row['TenCuaHang']; // Lấy tên cửa hàng từ kết quả truy vấn
        }
    }
?>
<body>
    <div class="container-fluid">
        <h2 style="text-align: center;">QUẢN LÝ DANH SÁCH NGUYÊN LIỆU</h2>
        <hr>
        <div class="search-bar">
            <form action="" method="get">
                <input type="text" name="txtname" id="txtTimKiem" class="form-control me-2 txtTimKiem" placeholder="Tìm kiếm nguyên liệu" 
                value="<?php echo isset($_GET['txtname']) ? htmlspecialchars($_GET['txtname']) : ''; ?>">
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
                    <!-- <th>Trạng thái</th> -->
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
                            $kq = $p->getAllNguyenLieuByNameByCuaHang($_REQUEST['txtname'], $idCuaHang);
                        } else {
                            // Lấy danh sách nguyên liệu của cửa hàng người dùng đang đăng nhập
                            $kq = $p->getAllNguyenLieuByCuaHang($idCuaHang);
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

                        // Kiểm tra và hiển thị trạng thái nguyên liệu
                        // if ($r["SoLuong"] == 0) {
                        //     $trangThai = "Hết nguyên liệu";
                        //     $classTrangThai = "text-danger";  // Màu đỏ cho "Hết nguyên liệu"
                        // } else {
                        //     $trangThai = "Còn nguyên liệu";
                        //     $classTrangThai = "text-success"; 
                        // }
                        // echo '<td class="' . $classTrangThai . '" style="text-align: center;">' . $trangThai . '</td>';
                        echo '<td style="text-align: center;">
                            <a class="btn btn-warning" href="?action=sua-nguyen-lieu&id_chitietnguyenlieu=' . $r["ID_ChiTietNguyenLieu"] . '" id="editBtn">Cập nhật</a>
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
