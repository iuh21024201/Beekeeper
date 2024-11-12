<?php
    include_once("../../controller/cMonAn.php");
    $p = new controlMonAn();
    $maMonAn = $_REQUEST["id_monan"];
    $sp = $p->getOneMonAn($maMonAn);
    if($sp){
        while($r = mysqli_fetch_assoc($sp)){
            $tenmonan = $r['TenMonAn'];
            $mamonan = $r['ID_LoaiMon'];
            $mota = $r['MoTa'];
            $gia = $r['Gia'];
            $hinhanh = $r['HinhAnh'];
            $tinhtrang = $r['TinhTrang'];
            $SoLuongNL = $r['SoLuongNL'];
        }
    } else {
        echo "<script>alert('Mã Sản Phẩm Không Tồn Tại !!!')</script>";
        header("refresh:0; url='admin.php'");
    }
?>
<h2 class="text-center">CẬP NHẬT MÓN ĂN</h2>
<form action="#" method="post" enctype="multipart/form-data" class="container bg-light p-4 rounded shadow">
    <div class="form-group">
        <label>Tên món ăn</label>
        <input type="text" id="txtTenSP" name="txtTenSP" class="form-control" value="<?php if(isset($tenmonan)) echo $tenmonan; ?>">
        <span class="text-danger" id="tbTenSP">(*)</span>
    </div>
    <div class="form-group">
        <label>Loại món ăn</label>
        <select id="txtLoaiMonAn" name="txtLoaiMonAn" class="form-control">
            <option value="">-- Chọn loại món ăn --</option>
            <?php
            include_once("../../controller/cLoaiMonAn.php");
            $p = new controlLoaiMon();
            $kqLoai = $p->getAllLoaiMon();  // Get all food types from the database

            if ($kqLoai) {
                while ($row = mysqli_fetch_assoc($kqLoai)) {
                    if ($row['ID_LoaiMon'] == $mamonan) {
                        echo "<option value='" . $row['ID_LoaiMon'] . "' selected>" . $row['TenLoaiMon'] . "</option>";
                    } else {
                        echo "<option value='" . $row['ID_LoaiMon'] . "'>" . $row['TenLoaiMon'] . "</option>";
                    }
                }
            } else {
                echo "<option disabled>No data!</option>";
            }
            ?>
        </select>
        <span class="text-danger" id="tbLoaiMonAn">(*)</span>
    </div>

    <div class="form-group">
        <label>Giá</label>
        <input type="text" id="txtGia" name="txtGia" class="form-control" value="<?php if(isset($gia)) echo $gia; ?>">
        <span class="text-danger" id="tbGia">(*)</span>
    </div>
    <div class="form-group">
        <label>Hình ảnh</label>
        <?php if (isset($hinhanh) && !empty($hinhanh)): ?>
            <div>
                <img src="../../image/monan/<?php echo $hinhanh; ?>" alt="Hình ảnh món ăn" style="max-width: 200px; max-height: 200px; margin-bottom: 10px;">
            </div>
        <?php endif; ?>
        <input type="file" id="txtHinhAnh" name="txtHinhAnh" class="form-control-file">
        <span class="text-danger" id="tbHinhAnh">(*)</span>
    </div>
    <div class="form-group">
        <label for="txtMoTa">Mô tả</label>
        <textarea name="txtMoTa" id="txtMoTa" name="txtMoTa" class="form-control" rows="3"><?php if(isset($mota)) echo $mota; ?></textarea>
    </div>
    <div class="form-group">
        <label>Trạng thái</label>
        <select id="txtTrangThaiMonAn" name="txtTrangThaiMonAn" class="form-control">
            <option value="0" <?php echo (isset($tinhtrang) && $tinhtrang == 0) ? 'selected' : ''; ?>>Hiển thị</option>
            <option value="1" <?php echo (isset($tinhtrang) && $tinhtrang == 1) ? 'selected' : ''; ?>>Ẩn</option>
        </select>
    </div>
    <div class="form-group">
        <label>Nhập số lượng nguyên liệu</label>
        <input type="number" id="txtSoLuongNguyenLieu" name="txtSoLuongNguyenLieu" class="form-control" value="<?php if(isset($SoLuongNL)) echo $SoLuongNL; ?>" onchange="updateIngredientFields()">
        <span class="text-danger" id="tbSoLuongNguyenLieu">(*)</span>
    </div>
    <div id="ingredientFields"></div>
    <div class="text-center">
        <button type="submit" name="btnThem" class="btn btn-primary">Cập nhật sản phẩm</button>
        <button type="reset" class="btn btn-secondary">Hủy</button>
    </div>
</form>

<script>
    function updateIngredientFields() {
        const ingredientCount = document.getElementById('txtSoLuongNguyenLieu').value;
        const ingredientFieldsContainer = document.getElementById('ingredientFields');

        // Clear all previous ingredient fields
        ingredientFieldsContainer.innerHTML = '';

        // Validate the count of ingredients entered
        if (ingredientCount > 0) {
            // Create input fields for ingredients
            for (let i = 0; i < ingredientCount; i++) {
                ingredientFieldsContainer.innerHTML += `
                    <div class="form-row align-items-center mb-3" id="ingredient-${i}">
                        <div class="col">
                            <label>Nguyên liệu ${i + 1}</label>
                            <select class="form-control" id="txtIngredientName-${i}" name="txtIngredientName-${i}">
                                <option value="">-- Chọn nguyên liệu ${i + 1} --</option>
                                <?php
                                    include_once("../../controller/cNguyenLieu.php");
                                    $p = new modelNguyenLieu();
                                    $kq = $p->selectAllNguyenLieu();
                                    if ($kq) {
                                        while ($row = mysqli_fetch_assoc($kq)) {
                                            echo "<option value='" . $row['ID_NguyenLieu'] . "'>" . $row['TenNguyenLieu'] . "</option>";
                                        }
                                    } else {
                                        echo "<option disabled>No ingredients found!</option>";
                                    }
                                ?>
                            </select>
                            <span class="text-danger" id="errorIngredientName-${i}">(*)</span>
                        </div>
                        <div class="col">
                            <label>Số lượng</label>
                            <input type="number" class="form-control" min="1" placeholder="Số lượng (gam)" id="txtSoLuong-${i}" name="txtSoLuong-${i}">
                            <span class="text-danger" id="errorSoLuong-${i}">(*)</span>
                        </div>
                    </div>
                `;
            }
        }
    }

    // Trigger ingredient fields update on change of ingredient count
    document.getElementById('txtSoLuongNguyenLieu').addEventListener('change', updateIngredientFields);
</script>
