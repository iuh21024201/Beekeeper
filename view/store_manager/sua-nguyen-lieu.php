<?php
include("../../controller/cNguyenLieu.php");
include_once("../../controller/c_xem_so_luong_ban.php");
$p = new controlNguyenLieu();
// $idNL = $_REQUEST["id_nguyenlieu"];
$idCTNL = isset($_REQUEST["id_chitietnguyenlieu"]) ? $_REQUEST["id_chitietnguyenlieu"] : null;
if (is_null($idCTNL)) {
    echo "<script>alert('Mã nguyên liệu không hợp lệ!'); window.location.href = 'admin.php';</script>";
    exit;
}

//lấy ID cửa hàng
$cuaHangController = new CCuaHang();
$CuaHang = $cuaHangController->get1CuaHang($idTaiKhoan);
if ($CuaHang && $CuaHang->num_rows > 0) {
    while ($row = $CuaHang->fetch_assoc()) {
        $idCuaHang = $row['ID_CuaHang'];
        $tenCuaHang = $row['TenCuaHang'];

    }
}
$tbl = $p->layMotNguyenLieuByCTNL($idCTNL);
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
}
if (isset($_POST['btnCapNhat'])) {
    // Lấy giá trị từ form
    $soLuong = $_POST['soLuong'];
    
    // Kiểm tra các trường số
    if (!is_numeric($soLuong) || $soLuong < 0) {
        echo "<script>alert('Số lượng phải là số hợp lệ và không được âm!'); </script>";
        exit;
    }

    // Cập nhật số lượng và trạng thái nguyên liệu
    $kq = $p->updateCTNLByCTNL($idCTNL, $idCuaHang, $soLuong);

    if ($kq) {
        echo "<script>alert('Cập nhật số lượng thành công'); window.location.href = 'index.php?action=quan-ly-nguyen-lieu';</script>";
    } else {
        echo "<script>alert('Cập nhật số lượng thất bại');</script>";
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
                    <input type="text" name="tenNL" class="form-control" value="<?php if (isset($tennl)) echo $tennl; ?>" readonly>
                    <span class="text-danger" id="tbten">(*)</span>
                </div>
                <div class="form-group">
                    <label for="">Giá mua</label>
                    <input type="text" name="gia" class="form-control" value="<?php if (isset($gia)) echo $gia; ?>" readonly>
                    <span class="text-danger" id="tbgia">(*)</span>
                </div>
                <div class="form-group">
                    <label for="">Số lượng</label>
                    <input type="text" name="soLuong" class="form-control" value="<?php if (isset($soluong)) echo $soluong; ?>">
                    <span class="text-danger" id="tbSL">(*)</span>
                </div>
                <div class="form-group">
                    <label for="">Đơn vị tính</label>
                    <select name="donVi" class="form-control" disabled>
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
                    <select name="trangThai" class="form-control" disabled>
                        <option value="0" <?php echo (isset($trangthai) && $trangthai == 0) ? 'selected' : ''; ?>>Còn nguyên liệu</option>
                        <option value="1" <?php echo (isset($trangthai) && $trangthai == 1) ? 'selected' : ''; ?>>Hết nguyên liệu</option>
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
                    <input type="file" name="hinhanh" class="form-control" disabled>
                    <span class="text-danger" id="tbHinh">(*)</span>
                </div>

                <button name="btnCapNhat" class="btn btn-success" type="submit">Cập nhật nguyên liệu</button>
            </form>
        </div>
    </div>
</div>
<script>

    // Kiểm tra số lượng
    function checkSoLuong() {
        const soLuong = document.querySelector('[name="soLuong"]');
        const tbSL = document.getElementById('tbSL');
        if (!soLuong.value.trim() || isNaN(soLuong.value) || Number(soLuong.value) < 0) {
            tbSL.innerText = "(*) Vui lòng nhập số lượng hợp lệ.";
            return false;
        }
        tbSL.innerText = "*";
        return true;
    }

    // Hàm kiểm tra tất cả các trường khi submit
    function validateForm() {
        const validSoLuong = checkSoLuong();

        return validSoLuong;
    }

    // Gắn sự kiện kiểm tra vào nút submit
    document.querySelector('[name="btnCapNhat"]').addEventListener('click', function (event) {
        if (!validateForm()) {
            event.preventDefault(); // Ngăn không cho form submit nếu không hợp lệ
            alert("Vui lòng điền đầy đủ và chính xác thông tin trước khi gửi.");
        }
    });
</script>