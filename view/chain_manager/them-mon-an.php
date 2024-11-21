<h2 class="text-center">THÊM MÓN ĂN</h2>
<form action="#" method="post" enctype="multipart/form-data" class="container bg-light p-4 rounded shadow">
    <div class="form-group">
        <label>Tên món ăn</label>
        <input type="text" id="txtTenSP" name= 'txtTenSP' class="form-control" placeholder="Nhập tên món ăn">
        <span class="text-danger" id="tbTenSP">(*)</span>
    </div>
    <div class="form-group">
        <label>Loại món ăn</label>
        <select id="txtLoaiMonAn" name="txtLoaiMonAn" class="form-control">
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
        <input type="text" id="txtGia" name="txtGia" class="form-control" placeholder="Nhập giá món ăn">
        <span class="text-danger" id="tbGia">(*)</span>
    </div>
    <div class="form-group">
        <label>Hình ảnh</label>
        <input type="file" id="txtHinhAnh" name="txtHinhAnh" class="form-control-file">
        <span class="text-danger" id="tbHinhAnh">(*)</span>
    </div>
    <div class="form-group">
        <label for="txtMoTa">Mô tả</label>
        <textarea name="txtMoTa" id="txtMoTa" name="txtMoTa" class="form-control" rows="3" placeholder="Nhập mô tả sản phẩm"></textarea>
    </div>
    <div class="form-group">
        <label>Trạng thái</label>
            <select id="txtTrangThaiMonAn" name="txtTrangThaiMonAn" class="form-control">
                <option value="0">Hiển thị</option>
                <option value="1">Ẩn</option>
            </select>
    </div>
    <div class="form-group">
        <label>Nhập số lượng nguyên liệu</label>
        <input type="text" id="txtSoLuongNguyenLieu" name="txtSoLuongNguyenLieu" class="form-control" placeholder="Nhập số lượng nguyên liệu" onchange="updateIngredientFields()">
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
        //var kt = /^[0-9][ ]?([A-ZÀÁẢÃẠÂẤẨẫẬĂẮẰẲẴẶ][a-zàáảãạâấẩẫậăắằẳẵặêếềểễệôốồổỗộơớờởỡợùúủũụưứừửữự]*)([ ]+[A-ZÀÁẢÃẠÂẤẨẫẬĂẮẰẲẴẶ][a-zàáảãạâấẩẫậăắằẳẵặêếềểễệôốồổỗộơớờởỡợùúủũụưứừửữự]*)*$/;

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

        document.getElementById("txtHinhAnh").addEventListener("change", checkHinhAnh);

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

            // Get the file extension
            var filePath = fileInput.value;
            var allowedExtensions = /(\.jpg|\.jpeg|\.png)$/i;

            // Check the file extension
            if (!allowedExtensions.exec(filePath)) {
                tbHinhAnh.textContent = "(*) Chỉ hỗ trợ hình ảnh .jpg, .jpeg, .png";
                return false; // Validation failed
            }

            // Nếu hợp lệ, có thể thông báo thành công hoặc không cần làm gì thêm
            tbHinhAnh.textContent = "(*) Hình ảnh hợp lệ.";
            tbHinhAnh.style.color = "green"; // Đổi màu thông báo thành xanh (nếu hợp lệ)
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
                        document.getElementById(`errorIngredientName-${i}`).innerHTML = "(*) Nguyên liệu này đã được chọn.";
                        return false; // Found a duplicate
                    }
                    selectedIngredients.push(selectElement.value);
                }
            }
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
        event.preventDefault();
    }

    // Check Giá
    if (!checkGia()) {
        event.preventDefault();
    }

    // Check Loại món ăn
    if (!checkLoaiMonAn()) {
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
<?php
include_once("../../model/ketnoi.php");
$p = new clsketnoi();
$con = $p->moKetNoi();

class FileUploader {
    public function uploadAnh($file, $tenMonAn, &$hinh) {
        $size = $file['size'];
        $loai = $file['type'];
        $temp = $file['tmp_name'];
        
        // Kiểm tra kích thước và định dạng file
        if (!$this->checkSize($size) || !$this->checkType($loai)) {
            return false;
        }

        // Thư mục lưu trữ ảnh
        $folder = "../../image/monan/";
        if (!file_exists($folder)) {
            mkdir($folder, 0777, true);
        }
    
        // Lấy phần mở rộng của file và chuyển đổi sang chữ thường
        $extension = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
        
        // Đổi tên file sang chữ thường, không dấu và thêm phần mở rộng
        $hinh = strtolower($this->changeName($tenMonAn)) . "." . $extension;
    
        // Đường dẫn lưu file
        $des = $folder . $hinh;
    
        // Di chuyển file từ thư mục tạm thời đến thư mục đích
        return move_uploaded_file($temp, $des);
    }

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
            'a'=>'Á|À|Ả|Ã|Ạ|Ă|Ắ|Ặ|Ằ|Ẳ|Ẵ|Â|Ấ|Ầ|Ẩ|Ẫ|Ậ',
            'd'=>'Đ',
            'e'=>'É|È|Ẻ|Ẽ|Ẹ|Ê|Ế|Ề|Ể|Ễ|Ệ',
            'i'=>'Í|Ì|Ỉ|Ĩ|Ị',
            'o'=>'Ó|Ò|Ỏ|Õ|Ọ|Ô|Ố|Ồ|Ổ|Ỗ|Ộ|Ơ|Ớ|Ờ|Ở|Ỡ|Ợ',
            'u'=>'Ú|Ù|Ủ|Ũ|Ụ|Ư|Ứ|Ừ|Ử|Ữ|Ự',
            'y'=>'Ý|Ỳ|Ỷ|Ỹ|Ỵ',
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

$fileUploader = new FileUploader();

if (isset($_POST['btnThem'])) {
    // Lấy dữ liệu từ form
    $tenMonAn = $_POST['txtTenSP'];
    $loaiMonAn = $_POST['txtLoaiMonAn'];
    $gia = $_POST['txtGia'];
    $moTa = $_POST['txtMoTa'];
    $trangThai = $_POST['txtTrangThaiMonAn'];
    $soLuongNguyenLieu = $_POST['txtSoLuongNguyenLieu'];  

    // Kiểm tra và xử lý upload hình ảnh
    $hinhAnh = $_FILES['txtHinhAnh'];
    if (isset($_FILES['txtHinhAnh']) && $_FILES['txtHinhAnh']['error'] == 0) {
        if ($fileUploader->uploadAnh($_FILES['txtHinhAnh'], $tenMonAn, $hinhAnh)) {
        } else {
            echo "<script>alert('Không thể upload hình ảnh!');</script>"; 
            $hinhAnh = NULL;  
        }
    } else {
        $hinhAnh = NULL;  
    }

    // Thêm món ăn vào bảng MonAn
    $sqlInsertMonAn = "INSERT INTO monan (TenMonAn, ID_LoaiMon, Gia, MoTa, HinhAnh, TinhTrang, TongNguyenLieu) 
                   VALUES (?, ?, ?, ?, ?, ?, ?)";
    $stmt = $con->prepare($sqlInsertMonAn);

    // Kiểm tra và xử lý giá trị của $hinhAnh trước khi insert
    if (!$hinhAnh) {
        $hinhAnh = NULL;  // Nếu không có hình ảnh, set giá trị là NULL
    }

    $stmt->bind_param("sisdsii", $tenMonAn, $loaiMonAn, $gia, $moTa, $hinhAnh, $trangThai, $soLuongNguyenLieu);

    if ($stmt->execute()) {
        $monAnID = $stmt->insert_id; // Lấy ID_MonAn vừa thêm
    
        // Thêm nguyên liệu vào bảng ChiTietMonAn
        for ($i = 0; $i < $soLuongNguyenLieu; $i++) {
            if (!isset($_POST["txtIngredientName-$i"], $_POST["txtSoLuong-$i"])) {
                continue;
            }
            $nguyenLieuID = $_POST["txtIngredientName-$i"];
            $soLuong = $_POST["txtSoLuong-$i"];
            
            if ($nguyenLieuID && $soLuong) {
                $sqlInsertChiTiet = "INSERT INTO chitietmonan (ID_MonAn, ID_NguyenLieu, SoLuongNguyenLieu) VALUES (?, ?, ?)";
                $stmtChiTiet = $con->prepare($sqlInsertChiTiet);
                $stmtChiTiet->bind_param("iii", $monAnID, $nguyenLieuID, $soLuong);
    
                if (!$stmtChiTiet->execute()) {
                    echo "<script>alert('Lỗi khi thêm nguyên liệu!');</script>"; 
                    exit;
                }
            }
        }
    
        // Thêm món ăn vào bảng ThucDon cho tất cả cửa hàng
        $sqlInsertThucDon = "INSERT INTO thucdon (ID_CuaHang, ID_MonAn, SoLuongTon) VALUES (?, ?, ?)";
        $stmtThucDon = $con->prepare($sqlInsertThucDon);

        $soLuongTon = 0; // Số lượng tồn mặc định là 0

        // Lấy danh sách cửa hàng từ bảng CuaHang
        $sqlSelectCuaHang = "SELECT ID_CuaHang, TenCuaHang, DiaChi FROM cuahang";
        $resultCuaHang = $con->query($sqlSelectCuaHang);

        if ($resultCuaHang && $resultCuaHang->num_rows > 0) {
            while ($row = $resultCuaHang->fetch_assoc()) {
                $idCuaHang = $row['ID_CuaHang'];
                $tenCuaHang = $row['TenCuaHang'];
                $diaChi = $row['DiaChi'];

                // Chèn vào bảng ThucDon
                $stmtThucDon->bind_param("iii", $idCuaHang, $monAnID, $soLuongTon);

                if (!$stmtThucDon->execute()) {
                    echo "<script>alert('Lỗi khi thêm món ăn vào cửa hàng: $tenCuaHang ($diaChi)!');</script>";
                    exit;
                }
            }

            echo "<script>alert('Thêm món ăn thành công!');
            window.location.href = 'index.php?action=quan-ly-mon-an';
            </script>";
        } else {
            echo "<script>alert('Không tìm thấy danh sách cửa hàng!');
            window.location.href = 'index.php?action=quan-ly-mon-an';    
            </script>";
        }

        $stmt->close();
        $stmtThucDon->close();
        $con->close();
    }
}
?>
