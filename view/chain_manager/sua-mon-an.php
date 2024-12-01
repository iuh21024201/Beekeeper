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
    // Check Tên món ăn
    var txtTenSP = $("#txtTenSP");
        var tbTenSP = $("#tbTenSP");
        //var kt = /^[0-9][ ]?([A-ZÀÁẢÃẠÂẤẨẫẬĂẮẰẲẴẶ][a-zàáảãạâấẩẫậăắằẳẵặêếềểễệôốồổỗộơớờởỡợùúủũụưứừửữự]*)([ ]+[A-ZÀÁẢÃẠÂẤẨẫẬĂẮẰẲẴẶ][a-zàáảãạâấẩẫậăắằẳẵặêếềểễệôốồổỗộơớờởỡợùúủũụưứừửữự]*)*$/;

        function checkTenSP() { 
            var inputValue = txtTenSP.val().trim();
            if (inputValue == "") {
                tbTenSP.html("(*) Vui lòng nhập tên món ăn");
                return false;
            }
            
            tbTenSP.html("(*)");
            return true;
        }
        txtTenSP.blur(checkTenSP);

        //check Giá
        var txtGia = $("#txtGia");
        var tbGia = $("#tbGia");

        function checkGia() {
            var kt = /^[0-9]{1,}$/;
            if (txtGia.val() == "") {
                tbGia.html("(*) Vui lòng nhập giá món ăn");
                return false;
            }
            if (!kt.test(txtGia.val())) {
                tbGia.html("(*) Giá phải được nhập số lớn hơn 0");
                return false;
            }
            if (txtGia.val() <= 0) {
                tbGia.html("(*) Giá phải được nhập số lớn hơn 0");
                return false;
            }
            tbGia.html("(*)");
            return true;
        }
        txtGia.blur(checkGia);

        // Check Loại món ăn
        var txtLoaiMonAn = $("#txtLoaiMonAn");
        var tbLoaiMonAn = $("#tbLoaiMonAn");

        function checkLoaiMonAn() {
            if (txtLoaiMonAn.val() == "") {
                tbLoaiMonAn.html("(*) Vui lòng chọn loại món ăn");
                return false;
            }
            tbLoaiMonAn.html("(*)");
            return true;
        }
        txtLoaiMonAn.change(checkLoaiMonAn);


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
                        <input type="text" class="form-control" min="1" step="0.01" placeholder="Số lượng (gam)" id="txtSoLuong-${i}" name="txtSoLuong-${i}" oninput="validateQuantity(${i})">
                        <span class="text-danger" id="errorSoLuong-${i}">(*)</span>
                    </div>
                </div>
            `;
        }
    }

    // Check for duplicate ingredients when the ingredient fields are updated
    if (!checkDuplicateIngredients()) {
        return; // If there's a duplicate, do not proceed
    }
}

// Ensure this function is triggered on change
document.getElementById('txtSoLuongNguyenLieu').addEventListener('change', updateIngredientFields);


        // Validate quantity input
        function validateQuantity(index) {
            const txtSoLuong = document.getElementById(`txtSoLuong-${index}`);
            const tbSoLuong = document.getElementById(`errorSoLuong-${index}`);

            // Clear previous error message
            tbSoLuong.innerHTML = "";

            // Get the trimmed value
            const value = txtSoLuong.value.trim();
            
            // Regex to match valid positive numbers (including decimals)
            const isValidNumber = /^\d*\.?\d+$/.test(value); // Note: changed to ensure at least one digit after decimal for a valid number
            
            // Check if the value is empty
            if (value === "") {
                tbSoLuong.innerHTML = "(*) Bắt buộc nhập";
                return false; // Return false to indicate validation failure
            }

            // Check if the value is not a valid number
            if (!isValidNumber) {
                tbSoLuong.innerHTML = "(*) Số lượng phải là số hợp lệ";
                return false; // Return false to indicate validation failure
            }

            // Check if the value is less than or equal to 0
            if (parseFloat(value) <= 0) {
                tbSoLuong.innerHTML = "(*) Số lượng phải là số dương";
                return false; // Return false to indicate validation failure
            }

            // If all checks pass, return true
            return true;
        }

        // Check ingredient fields function
        function checkIngredientFields(index) {
            const txtSoLuong = document.getElementById(`txtSoLuong-${index}`);
            const txtIngredientName = document.getElementById(`txtIngredientName-${index}`);
            const tbSoLuong = document.getElementById(`errorSoLuong-${index}`);
            const tbIngredient = document.getElementById(`errorIngredientName-${index}`);

            // Clear previous error messages
            tbSoLuong.innerHTML = "";
            tbIngredient.innerHTML = "";

            let isValid = true;

            // Check if ingredient is selected
            if (txtIngredientName.value.trim() === "") {
                tbIngredient.innerHTML = "(*) Bắt buộc chọn nguyên liệu";
                isValid = false;
            }

            // Validate the quantity field using validateQuantity
            if (!validateQuantity(index)) {
                isValid = false;
            }
            tbIngredient.innerHTML = "(*)";
            return isValid;
        }

        //check Nhập số lượng nguyên liệu
        var txtSoLuongNguyenLieu = $("#txtSoLuongNguyenLieu");
        var tbSoLuongNguyenLieu = $("#tbSoLuongNguyenLieu");
    
        function checkSoLuongNguyenLieu() {
            var kt = /^[0-9]{1,}$/;
            if (txtSoLuongNguyenLieu.val() == "") {
                tbSoLuongNguyenLieu.html("(*) Vui lòng nhập số lượng nguyên liệu");
                return false;
            }
            if (!kt.test(txtSoLuongNguyenLieu.val())) {
                tbSoLuongNguyenLieu.html("(*) Số lượng nguyên liệu phải được nhập số lớn hơn 0");
                return false;
            }
            if (txtSoLuongNguyenLieu.val() <= 0) {
                tbSoLuongNguyenLieu.html("(*) Số lượng nguyên liệu phải được nhập số lớn hơn 0");
                return false;
            }
            tbSoLuongNguyenLieu.html("(*)");
            return true;
        }
        txtSoLuongNguyenLieu.blur(checkSoLuongNguyenLieu);

        function checkDuplicateIngredients() {
            const ingredientCount = document.getElementById('txtSoLuongNguyenLieu').value;
            const selectedIngredients = [];

            // Gather selected ingredients
            for (let i = 0; i < ingredientCount; i++) {
                const selectElement = document.getElementById(`txtIngredientName-${i}`);
                if (selectElement.value) {
                    if (selectedIngredients.includes(selectElement.value)) {
                        document.getElementById(`errorIngredientName-${i}`).innerHTML = "(*) Nguyên liệu này đã được chọn.";
                        return false; // Found a duplicate
                    }
                    selectedIngredients.push(selectElement.value);
                }
            }
            document.getElementById(`errorIngredientName-${i}`).innerHTML = "(*)";
            return true; // No duplicates found
        }
$('form').submit(function(event) {
    if (!checkDuplicateIngredients()) {
        event.preventDefault(); // Prevent form submission if there are duplicates
        alert('Vui lòng kiểm tra lại nguyên liệu trùng lặp.');
    }
});

$('form').submit(function(event) {
    // Check Tên món ăn
    if (!checkTenSP()) {
        event.preventDefault(); // Ngăn form được gửi nếu tên món ăn không hợp lệ
        return;
    }

    // Check Loại món ăn
    if (!checkLoaiMonAn()) {
        event.preventDefault();
    }

    // Check Giá
    if (!checkGia()) {
        event.preventDefault();
    }

    // Check Hình ảnh
    if (!checkHinhAnh()) {
        event.preventDefault();
    }

    // Check Số lượng nguyên liệu
    if (!checkSoLuongNguyenLieu()) {
        event.preventDefault();
    }

    // Check Ingredient fields
    const ingredientCount = document.getElementById('txtSoLuongNguyenLieu').value;
    for (let i = 0; i < ingredientCount; i++) {
        if (!checkIngredientFields(i)) {
            event.preventDefault();
        }
    }

    // Check Duplicate Ingredients
    if (!checkDuplicateIngredients()) {
        event.preventDefault();
    }
});
</script>
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
class FileUploader {
    public function checkSize($size){
        return $size < 3*1024*1024;  // Kiểm tra kích thước file (dưới 3MB)
    }

    public function checkType($loai){
        $arrType = array("image/jpeg", "image/png", "image/jpg");  // Các loại file cho phép
        return in_array($loai, $arrType);
    }

    public function changeName($ten){
        $unicode = array(
            'a'=>'á|à|ả|ã|ạ|ă|ắ|ặ|ằ|ẳ|ẵ|â|ấ|ầ|ẩ|ẫ|ậ',             
            'd'=>'đ',                 
            'e'=>'é|è|ẻ|ẽ|ẹ|ê|ế|ề|ể|ễ|ệ',                 
            'i'=>'í|ì|ỉ|ĩ|ị',
            'o'=>'ó|ò|ỏ|õ|ọ|ô|ố|ồ|ổ|ỗ|ộ|ơ|ớ|ờ|ở|ỡ|ợ',
            'u'=>'ú|ù|ủ|ũ|ụ|ư|ứ|ừ|ử|ữ|ự',
            'y'=>'ý|ỳ|ỷ|ỹ|ỵ',
            'A'=>'Á|À|Ả|Ã|Ạ|Ă|Ắ|Ặ|Ằ|Ẳ|Ẵ|Â|Ấ|Ầ|Ẩ|Ẫ|Ậ',
            'D'=>'Đ',
            'E'=>'É|È|Ẻ|Ẽ|Ẹ|Ê|Ế|Ề|Ể|Ễ|Ệ',
            'I'=>'Í|Ì|Ỉ|Ĩ|Ị',
            'O'=>'Ó|Ò|Ỏ|Õ|Ọ|Ô|Ố|Ồ|Ổ|Ỗ|Ộ|Ơ|Ớ|Ờ|Ở|Ỡ|Ợ',
            'U'=>'Ú|Ù|Ủ|Ũ|Ụ|Ư|Ứ|Ừ|Ử|Ữ|Ự',
            'Y'=>'Ý|Ỳ|Ỷ|Ỹ|Ỵ',
        );

        // Thay thế kí tự Unicode, bỏ dấu và chuyển sang chữ thường
        foreach($unicode as $nonUnicode => $uni){
            $ten = preg_replace("/($uni)/i", $nonUnicode, $ten);
        }

        // Thay khoảng trắng thành dấu gạch dưới và chuyển thành chữ thường
        $ten = strtolower(str_replace(' ', '_', $ten));
        return $ten;
    }
}

if (isset($_REQUEST['btnCapNhat'])) {
    // Xử lý ảnh
    if (isset($_FILES['txtHinhAnh']['tmp_name']) && $_FILES['txtHinhAnh']['tmp_name'] != "") {
        $uploadDir = '../../image/monan/';
        $fileTmpName = $_FILES['txtHinhAnh']['tmp_name'];
        $fileName = basename($_FILES['txtHinhAnh']['name']);
        $fileExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

        // Định dạng hợp lệ
        $allowedExtensions = ['jpg', 'jpeg', 'png'];

        if (in_array($fileExtension, $allowedExtensions)) {
            // Tạo tên file duy nhất từ tên món ăn đã chuyển sang định dạng không dấu
            $fileUploader = new FileUploader(); // Tạo đối tượng của lớp FileUploader
            $tenMonAn = $_REQUEST['txtTenSP'];  // Lấy tên món ăn từ form
            $newFileName = $fileUploader->changeName($tenMonAn) . '.jpg';  // Đổi tất cả sang đuôi .jpg
            $targetFilePath = $uploadDir . $newFileName;

            // Di chuyển file từ thư mục tạm vào thư mục đích
            if (move_uploaded_file($fileTmpName, $targetFilePath)) {
                $hinhanh = $newFileName; // Cập nhật tên file ảnh mới
            } else {
                echo "<script>alert('Upload ảnh thất bại. Vui lòng thử lại!');</script>";
                exit;
            }
        } else {
            echo "<script>alert('Định dạng ảnh không hợp lệ. Chỉ chấp nhận JPG, JPEG, PNG!');</script>";
            exit;
        }
    }

    // Thu thập dữ liệu nguyên liệu
    $ingredientsNames = [];
    $ingredientsQuantities = [];
    $ingredientDetailIds = [];
    for ($i = 0; $i < $SoLuongNL; $i++) {
        $ingredientsNames[] = $_REQUEST["txtIngredientName-${i}"];
        $ingredientsQuantities[] = $_REQUEST["txtSoLuong-${i}"];
        $ingredientDetailIds[] = $_REQUEST["id_chitietmonan-${i}"];
    }

    // Gọi các hàm cập nhật
    $kq1 = $pMonAn->updatechitietMonAn($ingredientDetailIds, $maMonAn, $ingredientsNames, $ingredientsQuantities);
    $kq2 = $pMonAn->updateMonAn($maMonAn, $_REQUEST['txtLoaiMonAn'], $_REQUEST['txtTenSP'], $_REQUEST['txtMoTa'], $_REQUEST['txtSoLuongNguyenLieu'], $_REQUEST['txtGia'], $_FILES['txtHinhAnh'], $hinhanh, $_REQUEST['txtTrangThaiMonAn']); 

    if (!$kq1 && !$kq2) { 
        // Trường hợp cập nhật thất bại
        echo "<script>alert('Cập nhật thất bại'); window.location.href = 'index.php?action=quan-ly-mon-an';</script>";
    } else { 
        // Trường hợp cập nhật thành công
        echo "<script>alert('Cập nhật thành công'); window.location.href = 'index.php?action=quan-ly-mon-an';</script>";
    }
}
?> 

