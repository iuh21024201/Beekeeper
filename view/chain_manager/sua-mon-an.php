<?php 
    // Fetch ingredient data
    // Nếu class controlNguyenLieu nằm trong thư mục controller
include_once("../../controller/cNguyenLieu.php");

    $pNguyenLieu = new controlNguyenLieu();
    $ingredients = []; // Array to store ingredients
    $kq = $pNguyenLieu->getAllNguyenLieu();
    if ($kq) {
        while ($row = mysqli_fetch_assoc($kq)) {
            $ingredients[] = $row; // Store each ingredient's data
        }
    }

    // Fetch product data
    include_once("../../controller/cMonAn.php");
    $pMonAn = new controlMonAn();
    $maMonAn = $_REQUEST["id_monan"];
    $sp = $pMonAn->getOneMonAn($maMonAn);
    $ctma = $pMonAn->getOneChiTietMonAn($maMonAn);

    // Initialize variables
    $tenmonan = $mamonan = $mota = $gia = $hinhanh = $tinhtrang = $SoLuongNL = "";
    $mactmonan = $manguyenlieu = $SoLuong = 0;

    if ($ctma) {
        // Create ingredient fields dynamically from the result
        $ingredientFields = [];
        foreach ($ctma as $r) {
            $ingredientFields[] = [
                'id_chitietmonan' => $r['id_chitietmonan'],
                'manguyenlieu' => $r['ID_NguyenLieu'],
                'SoLuong' => $r['SoLuongNguyenLieu']
            ];
        }
    } else {
        echo "<script>alert('Mã Sản Phẩm Không Tồn Tại !!!')</script>";
        header("refresh:0; url='admin.php'");
    }

    if ($sp) {
        while ($r = mysqli_fetch_assoc($sp)) {
            $tenmonan = $r['TenMonAn'];
            $mamonan = $r['ID_LoaiMon'];
            $mota = $r['MoTa'];
            $gia = $r['Gia'];
            $hinhanh = $r['HinhAnh'];
            $tinhtrang = $r['TinhTrang'];
            $SoLuongNL = $r['TongNguyenLieu'];
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
                <img src="../../image/monan/<?php echo $hinhanh; ?>" alt="Chưa có hình ảnh" style="max-width: 200px; max-height: 200px; margin-bottom: 10px;">
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
        <input type="number" id="txtSoLuongNguyenLieu" name="txtSoLuongNguyenLieu" class="form-control" value="<?php echo isset($SoLuongNL) ? $SoLuongNL : 0; ?>" onchange="updateIngredientFields()">
        <span class="text-danger" id="tbSoLuongNguyenLieu">(*)</span>
    </div>

    <!-- Ingredient fields -->
    <div id="ingredientFields">
        <?php
        // Generate ingredient fields based on the number of ingredients
        if (isset($SoLuongNL) && $SoLuongNL > 0) {
            for ($i = 0; $i < $SoLuongNL; $i++) {
                $ingredient = isset($ingredientFields[$i]) ? $ingredientFields[$i] : null;
                echo '<div class="form-row align-items-center mb-3" id="ingredient-' . $i . '">
                    <div class="col">
                        <label>Nguyên liệu ' . ($i + 1) . '</label>
                        <select class="form-control" id="txtIngredientName-' . $i . '" name="txtIngredientName-' . $i . '">';
                
                // Option values from PHP
                foreach ($ingredients as $ingredientOption) {
                    $selected = ($ingredient && $ingredient['manguyenlieu'] == $ingredientOption['ID_NguyenLieu']) ? 'selected' : '';
                    echo "<option value='" . $ingredientOption['ID_NguyenLieu'] . "' $selected>" . $ingredientOption['TenNguyenLieu'] . "</option>";
                }

                echo '</select><span class="text-danger" id="errorIngredientName-' . $i . '">(*)</span></div>
                      <div class="col">
                          <label>Số lượng</label>
                          <input type="number" class="form-control" min="1" placeholder="Số lượng (gam)" id="txtSoLuong-' . $i . '" name="txtSoLuong-' . $i . '" value="' . (isset($ingredient) ? $ingredient['SoLuong'] : '') . '">
                          <span class="text-danger" id="errorSoLuong-' . $i . '">(*)</span>
                      </div>
                  </div>';
                echo '<input type="hidden" name="id_chitietmonan-' . $i . '" value="' . (isset($ingredient) ? $ingredient['id_chitietmonan'] : '') . '">';

            }
        }
        ?>
    </div>

    <div class="text-center">
        <button type="submit" name="btnCapNhat" class="btn btn-primary">Cập nhật sản phẩm</button>
        <button type="reset" class="btn btn-secondary">Hủy</button>
    </div>
</form>

<script>
// Handle dynamic ingredient fields
const ingredients = <?php echo json_encode($ingredients); ?>;

function updateIngredientFields() {
    const ingredientCount = document.getElementById('txtSoLuongNguyenLieu').value;
    const ingredientFieldsContainer = document.getElementById('ingredientFields');
    ingredientFieldsContainer.innerHTML = '';

    if (ingredientCount > 0) {
        for (let i = 0; i < ingredientCount; i++) {
            let ingredientOptions = '';
            ingredients.forEach(ingredient => {
                ingredientOptions += `<option value="${ingredient.ID_NguyenLieu}">${ingredient.TenNguyenLieu}</option>`;
            });

            ingredientFieldsContainer.innerHTML += `
                <div class="form-row align-items-center mb-3" id="ingredient-${i}">
                    <div class="col">
                        <label>Nguyên liệu ${i + 1}</label>
                        <select class="form-control" id="txtIngredientName-${i}" name="txtIngredientName-${i}">
                            <option value="">-- Chọn nguyên liệu ${i + 1} --</option>
                            ${ingredientOptions}
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

document.getElementById('txtSoLuongNguyenLieu').addEventListener('change', updateIngredientFields);
</script>
<?php
        if(isset($_REQUEST['btnCapNhat'])){
        $ingredientsNames = [];
        $ingredientsQuantities = [];
        $ingredientDetailIds = [];
        // Collect all ingredient names and quantities
        for ($i = 0; $i < $SoLuongNL; $i++) {
            $ingredientsNames[] = $_REQUEST["txtIngredientName-${i}"];
            $ingredientsQuantities[] = $_REQUEST["txtSoLuong-${i}"];
            $ingredientDetailIds[] = $_REQUEST["id_chitietmonan-${i}"];
        }

        // Call the update function with the arrays
        $kq = $pMonAn->updatechitietMonAn($ingredientDetailIds,$maMonAn, $ingredientsNames, $ingredientsQuantities);
        
        $kq = $pMonAn->updateMonAn($maMonAn, $_REQUEST['txtLoaiMonAn'], $_REQUEST['txtTenSP'], $_REQUEST['txtMoTa'], $_REQUEST['txtSoLuongNguyenLieu'], $_REQUEST['txtGia'], $_FILES['txtHinhAnh'],
         $hinhanh, $_REQUEST['txtTrangThaiMonAn']); 
        
        if($kq){
            echo "<script>alert('Cập nhập thành công');
            window.location.href = 'index.php?action=quan-ly-mon-an';
            </script>";
            exit;
        }else{
            echo "<script>alert('Cập nhập thất bại');
            window.location.href = 'index.php?action=quan-ly-mon-an';
            </script>";
        }
    }
?>