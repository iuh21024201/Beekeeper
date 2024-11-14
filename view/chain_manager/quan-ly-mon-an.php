
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../../asset/css/bootstrap.min.css">
    <script src="../../asset/js/jquery-3.4.1.min.js"></script>
    <script src="../../asset/js/bootstrap.min.js"></script>
</head>
<style>
    .container {
    margin-top: 30px;
    }

    .navbar li {
        display: inline-block; 
    }

    .navbar a {
        background-color: #dc3545; 
        color: white; 
        padding: 8px 12px;
        border-radius: 4px;
        border: none;
        text-decoration: none;
        transition: background-color 0.3s ease;
    }

    .navbar a:hover {
        background-color: #c82333; 
        color: #ffffff; 
    }

    #myBtn {
        margin-left: -30px;
    }

    .edit {
        display: flex; 
        justify-content: center; 
        align-items: center; 
        list-style: none; 
        padding: 0; 
        margin: 0;
    }

    .edit li {
        margin: 0 10px; 
    }

    .edit a {
        text-decoration: none; 
        padding: 8px 20px; 
        display: inline-block;
        color: #ffffff; 
        font-size: 14px; 
        text-align: center; 
        background-color: #007bff; 
        border-radius: 5px; 
        transition: background-color 0.3s ease; 
    }

    .edit a:hover {
        background-color: #0056b3; 
    }

    #editBtn {
        background-color: #ffc107; 
        color: #000; 
    }

    #editBtn:hover {
        background-color: #e0a800; 
    }
</style>
<body>
    <div class="container">
        
        <div class="col-md-12">
            <nav>
                <div class="col-md-3">
                    <ul class="navbar nav">
                        <li><a href="#" id="myBtn">Thêm sản phẩm</a></li>
                    </ul>
                </div>
            </nav>


        </div>
        <div class="col-md-12" height="200px">
            <caption>
                <h3 class="text-center">DANH SÁCH MÓN ĂN</h3>
            </caption>
            <table class="table table-bordered">
                <thead style="text-align: center;">
                    <th>STT</th>
                    <th>Tên món ăn</th>
                    <th>Loại món ăn</th>
                    <th>Giá</th>
                    <th>Hình ảnh</th>
                    <th>Trạng thái</th>
                    <th>Thao tác</th>
                </thead>
                <tbody>
                    <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td style="text-align: center; vertical-align: middle;">
                            <ul class="edit">
                                <li><a href="#" id="editBtn">Cập nhật</a></li>
                                <li><a href="delete-item.php?id=<?php echo $item['id']; ?>" onclick="return confirm('Bạn có chắc chắn muốn xóa món ăn này?');" id="deleteBtn">Xóa</a></li>
                            </ul>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

    </div> 
</body>
<div class="modal" id="myModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header text-center">
                    <h4 class="btn-block">THÊM MÓN ĂN</h4>
                    <button class="close" data-dismiss="modal">x</button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>Tên món ăn</label>
                        <input type="text" id="txtTenSP" class="form-control" placeholder="Nhập tên món ăn">
                        <span class="text-danger" id="tbTenSP">(*)</span>
                    </div>
                    <div class="form-group">
                        <label>Loại món ăn</label>
                        <select id="txtLoaiMonAn" class="form-control">
                            <option value="">-- Chọn loại món ăn --</option>
                            <option value="1">Món khai vị</option>
                            <option value="2">Món chính</option>
                            <option value="3">Món tráng miệng</option>
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
                        <input type="file" id="txtHinhAnh" class="form-control">
                        <span class="text-danger" id="tbHinhAnh">(*)</span>
                    </div>
                    <div class="form-group">
                        <label>Mô tả</label>
                        <textarea id="txtMoTa" class="form-control" rows="4" placeholder="Nhập mô tả món ăn"></textarea>
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
                    
                    
                </div>
                <div class="modal-footer">
                    <button class="btn btn-danger btn-block" id="btnSave">Thêm món ăn</button>
                </div>
            </div>
        </div>
    </div>
    
    <script>
        $(document).ready(function() {
        $("#myBtn").on("click", function() {
            $("#myModal").modal("show");
        })
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

$("#btnSave").on("click", function() {
    var isTenSPValid = checkTenSP();
    var isLoaiMonAnValid = checkLoaiMonAn();
    var isGiaValid = checkGia();
    var isHinhAnhValid = checkHinhAnh(); 
    var isSoLuongNguyenLieuValid = checkSoLuongNguyenLieu();

    let allIngredientsValid = true;
    const ingredientCount = parseInt(document.getElementById('txtSoLuongNguyenLieu').value);
    for (let i = 0; i < ingredientCount; i++) {
        allIngredientsValid = checkIngredientFields(i) && allIngredientsValid;
    }

    // Check for duplicate ingredients
    const isIngredientsValid = checkDuplicateIngredients();
    if (!isIngredientsValid) {
        alert("(*) Có nguyên liệu trùng lặp! Vui lòng chọn lại.");
        return; // Stop the submission
    }

    if (isTenSPValid && isLoaiMonAnValid && isGiaValid && isSoLuongNguyenLieuValid && isHinhAnhValid && allIngredientsValid) {
        alert("Món ăn đã được thêm thành công!");
        $("#myModal").modal("hide");
    }
    });

    }) 
    </script>

<div class="modal" id="updateModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header text-center">
                <h4 class="btn-block">CẬP NHẬT MÓN ĂN</h4>
                <button class="close" data-dismiss="modal">x</button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label>Tên món ăn</label>
                    <input type="text" id="updateTenSP" class="form-control" placeholder="Nhập tên món ăn">
                    <span class="text-danger" id="errTenSP">(*)</span>
                </div>
                <div class="form-group">
                    <label>Loại món ăn</label>
                    <select id="updateLoaiMonAn" class="form-control">
                        <option value="">-- Chọn loại món ăn --</option>
                        <option value="1">Món khai vị</option>
                        <option value="2">Món chính</option>
                        <option value="3">Món tráng miệng</option>
                    </select>
                    <span class="text-danger" id="errLoaiMonAn">(*)</span>
                </div>
                <div class="form-group">
                    <label>Giá</label>
                    <input type="text" id="updateGia" class="form-control" placeholder="Nhập giá món ăn">
                    <span class="text-danger" id="errGia">(*)</span>
                </div>
                <div class="form-group">
                    <label>Hình ảnh</label>
                    <input type="file" id="updateHinhAnh" class="form-control">
                    <span class="text-danger" id="errHinhAnh">(*)</span>
                </div>
                <div class="form-group">
                    <label>Mô tả</label>
                    <textarea id="updateMoTa" class="form-control" rows="4" placeholder="Nhập mô tả món ăn"></textarea>
                </div>
                <div class="form-group">
                    <label>Trạng thái</label>
                    <select id="updateTrangThaiMonAn" class="form-control">
                        <option value="1">Hiển thị</option>
                        <option value="0">Ẩn</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Nhập số lượng nguyên liệu</label>
                    <input type="text" id="updateSoLuongNguyenLieu" class="form-control" placeholder="Nhập số lượng nguyên liệu" onchange="updateIngredientFields()">
                    <span class="text-danger" id="errSoLuongNguyenLieu">(*)</span>
                </div>
                <div id="ingredientFields"></div> 
            </div>
            <div class="modal-footer">
                <button class="btn btn-danger btn-block" id="btnUpdate">Cập nhật món ăn</button>
            </div>
        </div>
    </div>
</div>
<script>
$(document).ready(function() {
        $("#editBtn").on("click", function() {
            $("#updateModal").modal("show");
        })
})
</script>
</html>