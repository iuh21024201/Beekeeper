<?php
include("../../controller/cNguyenLieu.php");
include_once("../../controller/c_xem_so_luong_ban.php");
$p = new controlNguyenLieu();
$idNL = $_REQUEST["id_nguyenlieu"];
$tbl = $p->layMotNguyenLieu($idNL);
//lấy ID cửa hàng
$cuaHangController = new CCuaHang();
$CuaHang = $cuaHangController->get1CuaHang($idTaiKhoan);
if ($CuaHang && $CuaHang->num_rows > 0) {
    while ($row = $CuaHang->fetch_assoc()) {
        $idCuaHang = $row['ID_CuaHang'];
        $tenCuaHang = $row['TenCuaHang'];

    }
}

if ($tbl) {
    while ($r = mysqli_fetch_assoc($tbl)) {
        $tennl = $r['TenNguyenLieu'];
        $gia = $r['GiaMua'];
        $soluong = $r['SoLuong'];
        $donvi = $r['DonViTinh'];
        $trangthai = $r['TrangThai'];
        $cuahang = $r['ID_CuaHang'];
        $hinhanh = $r['HinhAnh'];
    }
} else {
    echo "<script>alert('Mã Nguyên Liệu Không Tồn Tại!');</script>";
    header("refresh:0; url='admin.php'");
    exit;
}
if (isset($_POST['btnCapNhat'])) {
    // Lấy giá trị từ form
    $tenNL = $_POST['tenNL'];
    $gia = $_POST['gia'];
    $soluong = $_POST['soLuong'];
    $donVi = $_POST['donVi'];
    $trangThai = $_POST['trangThai'];
    
    // Kiểm tra các trường số
    if (!is_numeric($gia) || !is_numeric($soluong)) {
        echo "<script>alert('Giá và số lượng phải là số hợp lệ!');</script>";
        exit;
    }

    // Xử lý tải ảnh lên
    if ($_FILES['hinhanh']['name']) {
        $hinhanh = $_FILES['hinhanh']['name'];
        $uploadDir = "../../image/nguyenlieu/";
        $allowedTypes = ["image/png", "image/jpeg", "image/jpg"];
        $maxSize = 2 * 1024 * 1024; // Giới hạn 2MB
        
        if ($_FILES["hinhanh"]["size"] > $maxSize) {
            echo "<script>alert('File ảnh quá lớn, vui lòng chọn ảnh dưới 2MB!');</script>";
            exit;
        }
        
        if (in_array($_FILES["hinhanh"]["type"], $allowedTypes)) {
            move_uploaded_file($_FILES["hinhanh"]["tmp_name"], $uploadDir . $hinhanh);
        } else {
            echo "<script>alert('Chỉ chấp nhận file ảnh PNG, JPEG, JPG!');</script>";
            exit;
        }
    } else {
        $hinhanh = $hinhanh; // Giữ nguyên ảnh cũ nếu không có ảnh mới
    }

    // Cập nhật nguyên liệu
    $kq = $p->updateCTNL($idNL, $idCuaHang, $soluong);
    $kq = $p->updateNL($idNL, $_POST['tenNL'], $_POST['gia'], $_POST['donVi'], $hinhanh, $_POST['trangThai']);
    
    if ($kq) {
        echo "<script>alert('Cập nhật thành công'); window.location.href = 'index.php?action=quan-ly-nguyen-lieu';</script>";
    } else {
        echo "<script>alert('Cập nhật nguyên liệu thất bại');</script>";
    }
}
?>
<div class="container-fluid">
    <div class="card">
        <div class="card-header">
            <h4>Cập nhật nguyên liệu</h4>
        </div>
        <div class="card-body">
            <form action="#" method="post" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="">Tên nguyên liệu</label>
                    <input type="text" name="tenNL" class="form-control" value="<?php if (isset($tennl)) echo $tennl; ?>">
                    <span class="text-danger" id="tbten">(*)</span>
                </div>
                <div class="form-group">
                    <label for="">Giá mua</label>
                    <input type="text" name="gia" class="form-control" value="<?php if (isset($gia)) echo $gia; ?>">
                    <span class="text-danger" id="tbgia">(*)</span>
                </div>
                <div class="form-group">
                    <label for="">Số lượng</label>
                    <input type="text" name="soLuong" class="form-control" value="<?php if (isset($soluong)) echo $soluong; ?>">
                    <span class="text-danger" id="tbSL">(*)</span>
                </div>
                <div class="form-group">
                    <label for="">Đơn vị tính</label>
                    <select name="donVi" class="form-control">
                        <option value="gam" <?php if ($donvi == "gam") echo 'selected'; ?>>100 gam</option>
                        <option value="Gói" <?php if ($donvi == "Gói") echo 'selected'; ?>>Gói</option>
                        <option value="Hộp" <?php if ($donvi == "Hộp") echo 'selected'; ?>>Hộp</option>
                        <option value="Cánh" <?php if ($donvi == "Cánh") echo 'selected'; ?>>Cánh</option>
                        <option value="Đùi" <?php if ($donvi == "Đùi") echo 'selected'; ?>>Đùi</option>
                        <option value="Trứng" <?php if ($donvi == "Trứng") echo 'selected'; ?>>Trứng</option>
                        <option value="Ức" <?php if ($donvi == "Ức") echo 'selected'; ?>>Ức</option>
                    </select>
                    <span class="text-danger" id="tbDonVi">(*)</span>
                </div>
                <div class="form-group">
                    <label for="">Trạng thái</label><br>
                    <select name="trangThai" class="form-control">
                        <option value="0" <?php echo (isset($trangthai) && $trangthai == 0) ? 'selected' : ''; ?>>Còn hàng</option>
                        <option value="1" <?php echo (isset($trangthai) && $trangthai == 1) ? 'selected' : ''; ?>>Hết hàng</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="">Cửa hàng</label>
                    <!-- Hiển thị tên cửa hàng và ẩn giá trị ID -->
                    <input type="text" class="form-control" value="<?php echo $tenCuaHang; ?>" disabled>
                    <input type="hidden" name="idCuaHang" value="<?php echo $idCuaHang; ?>">
                    <span class="text-danger" id="tbDonCuaHang">(*)</span>
                </div>
                <div class="form-group">
                    <label for="">Hình ảnh</label>
                    <?php if (isset($hinhanh) && !empty($hinhanh)): ?>
                        <div>
                            <img src="../../image/nguyenlieu/<?php echo $hinhanh; ?>" alt="Chưa có hình ảnh" style="max-width: 200px; max-height: 200px; margin-bottom: 10px;">
                        </div>
                    <?php endif; ?>
                    <input type="file" name="hinhanh" class="form-control">
                    <span class="text-danger" id="tbHinh">(*)</span>
                </div>

                <button name="btnCapNhat" class="btn btn-success" type="submit">Cập nhật nguyên liệu</button>
            </form>
        </div>
    </div>
</div>
