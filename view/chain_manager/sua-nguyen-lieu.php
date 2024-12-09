<?php
include("../../controller/cNguyenLieu.php");
include_once("../../controller/cCuaHang.php");

$p = new controlNguyenLieu();
$idNL = $_REQUEST["id_nguyenlieu"];

// Lấy thông tin nguyên liệu
$tbl = $p->layMotNguyenLieuByNL($idNL);
$cuaHangArray = []; // Khởi tạo danh sách cửa hàng liên quan

if ($tbl) {
    while ($r = mysqli_fetch_assoc($tbl)) {
        $tennl = $r['TenNguyenLieu'];
        $gia = $r['GiaMua'];
        $soluong = $r['SoLuong'];
        $donvi = $r['DonViTinh'];
        $trangthai = $r['TrangThai'];
        $hinhanh = $r['HinhAnh'];
        $cuaHangArray[] = $r['ID_CuaHang']; // Lưu các ID cửa hàng liên quan
    }
}

if (isset($_POST['btnCapNhat'])) {
    // Lấy giá trị từ form
    $tenNL = $_POST['tenNL'];
    $gia = $_POST['gia'];
    $soluong = $_POST['soLuong'];
    $donVi = $_POST['donVi'];
    $trangThai = $_POST['trangThai'];
    $cuaHangArray = isset($_POST['cuaHang']) ? $_POST['cuaHang'] : []; // Cửa hàng được chọn

    // Kiểm tra giá trị số
    if (!is_numeric($gia) || !is_numeric($soluong)) {
        echo "<script>alert('Giá và số lượng phải là số hợp lệ!');</script>";
        exit;
    }

    // Xử lý tải ảnh lên
    if ($_FILES['hinhanh']['name']) {
        $hinhanh = $_FILES['hinhanh']['name'];
        $uploadDir = "../../image/nguyenlieu/";
        $allowedTypes = ["image/png", "image/jpeg", "image/jpg"];
        $maxSize = 2 * 1024 * 1024; // 2MB

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
        $hinhanh = $hinhanh; // Giữ nguyên ảnh cũ
    }

    // Cập nhật thông tin nguyên liệu
    $kq = $p->updateNL($idNL, $tenNL, $gia, $donVi, $hinhanh, $trangThai);

    // Cập nhật cửa hàng
    if (in_array('all', $cuaHangArray)) {
        // Cập nhật cho tất cả cửa hàng
        $tblCuaHang = (new cCuaHang())->getAllStore();
        while ($row = mysqli_fetch_assoc($tblCuaHang)) {
            $p->updateCTNL($idNL, $row['ID_CuaHang'], $soluong);
        }
    } else {
        // Cập nhật cho các cửa hàng đã chọn
        foreach ($cuaHangArray as $idCuaHang) {
            $p->updateCTNL($idNL, $idCuaHang, $soluong);
        }
    }

    // Kết quả cập nhật
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
                <!-- Tên nguyên liệu -->
                <div class="form-group">
                    <label for="">Tên nguyên liệu</label>
                    <input type="text" name="tenNL" class="form-control" value="<?php echo isset($tennl) ? $tennl : ''; ?>" required>
                </div>

                <!-- Giá mua -->
                <div class="form-group">
                    <label for="">Giá mua</label>
                    <input type="text" name="gia" class="form-control" value="<?php echo isset($gia) ? $gia : ''; ?>" required>
                </div>

                <!-- Số lượng -->
                <div class="form-group">
                    <label for="">Số lượng</label>
                    <input type="text" name="soLuong" class="form-control" value="<?php echo isset($soluong) ? $soluong : ''; ?>" required>
                </div>

                <!-- Đơn vị tính -->
                <div class="form-group">
                    <label for="">Đơn vị tính</label>
                    <select name="donVi" class="form-control" required>
                        <option value="gam" <?php echo ($donvi == "gam") ? 'selected' : ''; ?>>100 gam</option>
                        <option value="Gói" <?php echo ($donvi == "Gói") ? 'selected' : ''; ?>>Gói</option>
                        <option value="Hộp" <?php echo ($donvi == "Hộp") ? 'selected' : ''; ?>>Hộp</option>
                        <option value="Cánh" <?php echo ($donvi == "Cánh") ? 'selected' : ''; ?>>Cánh</option>
                        <option value="Đùi" <?php echo ($donvi == "Đùi") ? 'selected' : ''; ?>>Đùi</option>
                        <option value="Trứng" <?php echo ($donvi == "Trứng") ? 'selected' : ''; ?>>Trứng</option>
                        <option value="Ức" <?php echo ($donvi == "Ức") ? 'selected' : ''; ?>>Ức</option>
                    </select>
                </div>

                <!-- Trạng thái -->
                <div class="form-group">
                    <label for="">Trạng thái</label>
                    <select name="trangThai" class="form-control" required>
                        <option value="0" <?php echo ($trangthai == 0) ? 'selected' : ''; ?>>Còn hàng</option>
                        <option value="1" <?php echo ($trangthai == 1) ? 'selected' : ''; ?>>Hết hàng</option>
                    </select>
                </div>

                <!-- Cửa hàng -->
                <div class="form-group">
                    <label for="">Chọn cửa hàng</label>
                    <div>
                        <label>
                            <input type="checkbox" id="selectAll"> Tất cả cửa hàng
                        </label>
                    </div>
                    <?php
                    $pl = new cCuaHang();
                    $tbl = $pl->getAllStore();
                    if ($tbl) {
                        while ($row = mysqli_fetch_assoc($tbl)) {
                            $isChecked = in_array($row['ID_CuaHang'], $cuaHangArray) ? 'checked' : '';
                            echo "<div>
                                <label>
                                    <input type='checkbox' name='cuaHang[]' value='" . $row['ID_CuaHang'] . "' class='storeCheckbox' $isChecked> " . htmlspecialchars($row['TenCuaHang'], ENT_QUOTES) . "
                                </label>
                            </div>";
                        }
                    } else {
                        echo "<div>Không có cửa hàng nào để chọn</div>";
                    }
                    ?>
                </div>

                <!-- Hình ảnh -->
                <div class="form-group">
                    <label for="">Hình ảnh</label>
                    <?php if (isset($hinhanh) && !empty($hinhanh)): ?>
                        <div>
                            <img src="../../image/nguyenlieu/<?php echo $hinhanh; ?>" alt="Chưa có hình ảnh" style="max-width: 200px; max-height: 200px; margin-bottom: 10px;">
                        </div>
                    <?php endif; ?>
                    <input type="file" name="hinhanh" class="form-control">
                </div>

                <!-- Nút submit -->
                <button name="btnCapNhat" class="btn btn-success" type="submit">Cập nhật nguyên liệu</button>
            </form>
        </div>
    </div>
</div>

<script>
document.addEventListener("DOMContentLoaded", function () {
    const selectAllCheckbox = document.getElementById("selectAll");
    const storeCheckboxes = document.querySelectorAll(".storeCheckbox");

    // Chọn tất cả checkbox
    selectAllCheckbox.addEventListener("change", function () {
        const isChecked = this.checked;
        storeCheckboxes.forEach(cb => cb.checked = isChecked);
    });

    // Bỏ chọn "Tất cả" nếu một checkbox bị bỏ chọn
    storeCheckboxes.forEach(cb => {
        cb.addEventListener("change", function () {
            if (!this.checked) {
                selectAllCheckbox.checked = false;
            } else if (Array.from(storeCheckboxes).every(cb => cb.checked)) {
                selectAllCheckbox.checked = true;
            }
        });
    });
});
</script>
