<h2 class="text-center">THÊM MÓN ĂN</h2>
<form action="#" method="post" enctype="multipart/form-data" class="container bg-light p-4 rounded shadow">
    <div class="form-group">
        <label>Tên món ăn</label>
        <input type="text" id="txtTenSP" class="form-control" placeholder="Nhập tên món ăn">
        <span class="text-danger" id="tbTenSP">(*)</span>
    </div>
    <div class="form-group">
        <label>Loại món ăn</label>
        <select id="txtLoaiMonAn" class="form-control">
            <option value="">-- Chọn loại món ăn --</option>
            <?php
            include_once("../../controller/cLoaiMonAn.php");
            $p = new controlLoaiMon();
            $kqLoai = $p->getAllLoaiMon();

            if ($kqLoai) {
                while ($row = mysqli_fetch_assoc($kqLoai)) {
                    $selected = (isset($_GET['type']) && $_GET['type'] == $row['ID_LoaiMon']) ? 'selected' : '';
                    echo "<option value='" . $row['ID_LoaiMon'] . "' $selected>" . $row['TenLoaiMon'] . "</option>";
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
        <input type="text" id="txtGia" class="form-control" placeholder="Nhập giá món ăn">
        <span class="text-danger" id="tbGia">(*)</span>
    </div>
    <div class="form-group">
        <label>Hình ảnh</label>
        <input type="file" id="txtHinhAnh" class="form-control-file">
        <span class="text-danger" id="tbHinhAnh">(*)</span>
    </div>
    <div class="form-group">
        <label for="txtMoTa">Mô tả</label>
        <textarea name="txtMoTa" id="txtMoTa" class="form-control" rows="3" placeholder="Nhập mô tả sản phẩm" required></textarea>
    </div>
    <div class="form-group">
        <label>Trạng thái</label>
            <select id="txtTrangThaiMonAn" class="form-control">
                <option value="1">Hiển thị</option>
                <option value="0">Ẩn</option>
            </select>
    </div>
    <div class="form-group">
        <label>Nhập số lượng nguyên liệu</label>
        <input type="text" id="txtSoLuongNguyenLieu" class="form-control" placeholder="Nhập số lượng nguyên liệu" onchange="updateIngredientFields()">
        <span class="text-danger" id="tbSoLuongNguyenLieu">(*)</span>
    </div>
    <div id="ingredientFields"></div>
    <div class="text-center">
        <button type="submit" name="btnThem" class="btn btn-primary">Thêm sản phẩm</button>
        <button type="reset" class="btn btn-secondary">Hủy</button>
    </div>
</form>
<script>
// Check Tên món ăn
        var txtTenSP = $("#txtTenSP");
        var tbTenSP = $("#tbTenSP");

        var kt = /^[0-9][ ]?([A-ZÀÁẢÃẠÂẤẨẫẬĂẮẰẲẴẶ][a-zàáảãạâấẩẫậăắằẳẵặêếềểễệôốồổỗộơớờởỡợùúủũụưứừửữự]*)([ ]+[A-ZÀÁẢÃẠÂẤẨẫẬĂẮẰẲẴẶ][a-zàáảãạâấẩẫậăắằẳẵặêếềểễệôốồổỗộơớờởỡợùúủũụưứừửữự]*)*$/;  

        function checkTenSP() {
            
            var inputValue = txtTenSP.val().trim();

            if (inputValue == "") {
                tbTenSP.html("(*) Vui lòng nhập tên món ăn");
                return false;
            }
            if (!kt.test(inputValue)) {
                tbTenSP.html("(*) Tên món phải bắt đầu bằng số và chữ cái đầu tiên phải viết hoa");
                return false;
            }
            tbTenSP.html("*");
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
            tbGia.html("*");
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
            tbLoaiMonAn.html("*");
            return true;
        }
        txtLoaiMonAn.change(checkLoaiMonAn);

        function checkHinhAnh() {
            var fileInput = document.getElementById("txtHinhAnh");
            var tbHinhAnh = document.getElementById("tbHinhAnh");

            // Clear previous error message
            tbHinhAnh.textContent = "";

            // Check if a file has been selected
            if (!fileInput.files.length) {
                tbHinhAnh.textContent = "(*) Vui lòng chọn hình ảnh.";
                return false; // Validation failed
            }

            return true; // Validation succeeded
        }

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
                                <select class="form-control" id="txtIngredientName-${i}">
                                    <option value="">-- Chọn nguyên liệu ${i + 1} --</option>
                                    <option value="nguyenLieu1">Nguyên liệu 1</option>
                                    <option value="nguyenLieu2">Nguyên liệu 2</option>
                                    <option value="nguyenLieu3">Nguyên liệu 3</option>
                                </select>
                                <span class="text-danger" id="errorIngredientName-${i}">(*)</span>
                            </div>
                            <div class="col">
                                <label>Số lượng</label>
                                <input type="text" class="form-control" min="1" step="0.01" placeholder="Số lượng (gam)" id="txtSoLuong-${i}" oninput="validateQuantity(${i})">
                                <span class="text-danger" id="errorSoLuong-${i}">(*)</span>
                            </div>
                        </div>
                    `;
                }
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
            tbSoLuongNguyenLieu.html("*");
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
                        return false; // Found a duplicate
                    }
                    selectedIngredients.push(selectElement.value);
                }
            }
            return true; // No duplicates found
        }
</script>
