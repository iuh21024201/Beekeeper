<?php
include_once("../../controller/cNguyenLieu.php");
include_once("../../controller/cCuaHang.php");

// Xử lý khi nhấn nút thêm
if (isset($_POST["btnThem"])) {
    $pNL = new controlNguyenLieu();
    $pCH = new cCuaHang();

    // Lấy dữ liệu từ form
    $tenNL = trim($_POST["tenNL"]);
    $gia = intval($_POST["gia"]);
    $donVi = trim($_POST["donVi"]);
    $trangthai = intval($_POST["trangThai"]);
    $cuaHangArray = $_POST["cuaHang"];  // Mảng cửa hàng đã chọn
    $soLuong = intval($_POST["soLuong"]);
    $hinhanh = $_FILES["hinhanh"]["name"];
    $uploadDir = "../../image/nguyenlieu/";

    // Kiểm tra nhập liệu
    if (empty($tenNL) || $gia <= 0 || $soLuong <= 0 || empty($donVi) || empty($hinhanh) || empty($cuaHangArray)) {
        echo "<script>alert('Vui lòng nhập đầy đủ và chính xác thông tin!');</script>";
        exit;
    }

    // Kiểm tra file ảnh hợp lệ
    $allowedTypes = ["image/png", "image/jpeg", "image/jpg"];
    if (!in_array($_FILES["hinhanh"]["type"], $allowedTypes)) {
        echo "<script>alert('Chỉ chấp nhận các file ảnh PNG, JPEG, JPG!');</script>";
        exit;
    }

    // Upload ảnh
    if (!move_uploaded_file($_FILES["hinhanh"]["tmp_name"], $uploadDir . $hinhanh)) {
        echo "<script>alert('Upload ảnh thất bại!');</script>";
        exit;
    }

    // Thêm nguyên liệu vào bảng `nguyenlieu`
    $idNL = $pNL->insertNL($tenNL, $gia, $donVi, $hinhanh, $trangthai);

    // Khởi tạo biến result để theo dõi kết quả
    $result = true;  // Initialize the result variable to true

    // Nếu chọn "Tất cả cửa hàng", lấy tất cả cửa hàng từ cơ sở dữ liệu
    if (in_array('all', $cuaHangArray)) {
        // Lấy tất cả cửa hàng
        $tblCuaHang = $pCH->getAllStore();
        while ($row = mysqli_fetch_assoc($tblCuaHang)) {
            // Thêm chi tiết nguyên liệu vào từng cửa hàng
            if (!$pNL->insertCTNL($idNL, $row['ID_CuaHang'], $soLuong)) {
                $result = false;
                break;
            }
        }
    } else {
        // Thêm chi tiết nguyên liệu cho các cửa hàng đã chọn
        foreach ($cuaHangArray as $idCuaHang) {
            if (!$pNL->insertCTNL($idNL, $idCuaHang, $soLuong)) {
                $result = false;
                break;
            }
        }
    }

    if ($result) {
        echo "<script>alert('Thêm nguyên liệu thành công!'); window.location.href = 'index.php?action=quan-ly-nguyen-lieu';</script>";
        exit;
    } else {
        echo "<script>alert('Lỗi khi thêm chi tiết nguyên liệu!');</script>";
    }
}
?>

<div class="container-fluid">
    <div class="card">
        <div class="card-header">
            <h4>Thêm nguyên liệu</h4>
        </div>
        <div class="card-body">
            <form action="#" method="post" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="">Tên nguyên liệu</label>
                    <input type="text" name="tenNL" class="form-control" required>
                    <span class="text-danger" id="tbTenNL">(*)</span>
                </div>
                <div class="form-group">
                    <label for="">Giá mua</label>
                    <input type="text" name="gia" class="form-control" required>
                    <span class="text-danger" id="tbgia">(*)</span>
                </div>
                <div class="form-group">
                    <label for="">Số lượng</label>
                    <input type="text" name="soLuong" class="form-control" required>
                    <span class="text-danger" id="tbSL">(*)</span>
                </div>
                <div class="form-group">
                    <label for="">Đơn vị tính</label>
                    <select name="donVi" class="form-control" required>
                        <option value="">--Chọn đơn vị tính--</option>
                        <option value="gam">100 gam</option>
                        <option value="Gói">Gói</option>
                        <option value="Hộp">Hộp</option>
                        <option value="Cánh">Cánh</option>
                        <option value="Đùi">Đùi</option>
                        <option value="Trứng">Trứng</option>
                        <option value="Ức">Ức</option>
                    </select>
                    <span class="text-danger" id="tbDonVi">(*)</span>
                </div>
                <div class="form-group">
                    <label for="">Trạng thái</label><br>
                    <select name="trangThai" class="form-control" required>
                        <option value="0">Còn hàng</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="cuaHang">Chọn cửa hàng:</label>
                    <div>
                        <label>
                            <input type="checkbox" name="cuaHang[]" value="all" id="selectAll"> Tất cả cửa hàng
                        </label>
                    </div>
                    <?php
                    include_once("../../controller/cCuaHang.php");
                    $p = new cCuaHang();
                    $tbl = $p->getAllStore();
                    
                    if ($tbl && mysqli_num_rows($tbl) > 0) {
                        foreach ($tbl as $row) {
                            echo sprintf(
                                '<div>
                                    <label>
                                        <input type="checkbox" name="cuaHang[]" value="%s" class="storeCheckbox"> %s
                                    </label>
                                </div>',
                                htmlspecialchars($row['ID_CuaHang'], ENT_QUOTES),
                                htmlspecialchars($row['TenCuaHang'], ENT_QUOTES)
                            );
                        }
                    } else {
                        echo '<div>Không có cửa hàng nào để chọn</div>';
                    }
                    ?>
                    <span class="text-danger" id="tbCuaHang">(*)</span>
                </div>
                <div class="form-group">
                    <label for="">Hình ảnh</label>
                    <input type="file" name="hinhanh" class="form-control" required>
                    <span class="text-danger" id="tbHinh">(*)</span>
                </div>
                <button name="btnThem" class="btn btn-success" type="submit">Thêm nguyên liệu</button>
            </form>
        </div>
    </div>
</div>
<script>
    document.addEventListener("DOMContentLoaded", function () {
    const selectAllCheckbox = document.getElementById("selectAll");
    const storeCheckboxes = document.querySelectorAll(".storeCheckbox");

    // Khi nhấp vào "Tất cả cửa hàng", chọn/bỏ chọn tất cả
    selectAllCheckbox.addEventListener("change", function () {
        storeCheckboxes.forEach(checkbox => {
            checkbox.checked = this.checked;
        });
    });

    // Khi nhấp vào từng cửa hàng, bỏ chọn "Tất cả cửa hàng" nếu có thay đổi
    storeCheckboxes.forEach(checkbox => {
        checkbox.addEventListener("change", function () {
            if (!this.checked) {
                selectAllCheckbox.checked = false; // Bỏ chọn "Tất cả cửa hàng" nếu 1 checkbox bị bỏ chọn
            } else if (Array.from(storeCheckboxes).every(cb => cb.checked)) {
                selectAllCheckbox.checked = true; // Chọn "Tất cả cửa hàng" nếu tất cả checkbox được chọn
            }
        });
    });
});

    // Kiểm tra tên nguyên liệu
    function checkTenNL() {
    const tenNL = document.querySelector('[name="tenNL"]');
    const tbTenNL = document.getElementById('tbTenNL');
    const regex = /^[a-zA-ZÀÁÂÃÈÉÊÌÍÒÓÔÕÙÚĂĐĨŨƠàáâãèéêìíòóôõùúăđĩũơƯưẠ-ỹ\s]+$/u;

    if (!tenNL.value.trim()) {
        tbTenNL.innerText = "(*) Vui lòng nhập tên nguyên liệu.";
        return false;
    }

    if (!regex.test(tenNL.value.trim())) {
        tbTenNL.innerText = "(*) Tên nguyên liệu chỉ chứa ký tự chữ cái và khoảng trắng.";
        return false;
    }

    tbTenNL.innerText = "*";
    return true;
}


    // Kiểm tra giá
    function checkGia() {
        const gia = document.querySelector('[name="gia"]');
        const tbgia = document.getElementById('tbgia');
        if (!gia.value.trim() || isNaN(gia.value) || Number(gia.value) <= 0) {
            tbgia.innerText = "(*) Vui lòng nhập giá hợp lệ.";
            return false;
        }
        tbgia.innerText = "*";
        return true;
    }

    // Kiểm tra số lượng
    function checkSoLuong() {
        const soLuong = document.querySelector('[name="soLuong"]');
        const tbSL = document.getElementById('tbSL');
        if (!soLuong.value.trim() || isNaN(soLuong.value) || Number(soLuong.value) <= 0) {
            tbSL.innerText = "(*) Vui lòng nhập số lượng hợp lệ.";
            return false;
        }
        tbSL.innerText = "*";
        return true;
    }

    // Kiểm tra đơn vị tính
    function checkDonVi() {
        const donVi = document.querySelector('[name="donVi"]');
        const tbDonVi = document.getElementById('tbDonVi');
        if (!donVi.value) {
            tbDonVi.innerText = "(*) Vui lòng chọn đơn vị tính.";
            return false;
        }
        tbDonVi.innerText = "*";
        return true;
    }

    // Kiểm tra cửa hàng
    function checkCuaHang() {
        const checkedStores = document.querySelectorAll('input[name="cuaHang[]"]:checked');
        const tbCuaHang = document.getElementById('tbCuaHang');
        if (checkedStores.length === 0) { 
            tbCuaHang.innerText = "(*) Vui lòng chọn cửa hàng.";
            return false;
        }
        tbCuaHang.innerText = "*";
        return true;
    }

    // Kiểm tra hình ảnh
    function checkHinhAnh() {
        const hinhAnh = document.querySelector('[name="hinhanh"]');
        const tbHinh = document.getElementById('tbHinh');
        const allowedExtensions = /(\.jpg|\.jpeg|\.png)$/i;
        
        if (!hinhAnh.value.trim()) {
            tbHinh.innerText = "(*) Vui lòng chọn ảnh.";
            return false;
        }

        if (!allowedExtensions.test(hinhAnh.value)) {
            tbHinh.innerText = "(*) Vui lòng chọn file ảnh hợp lệ (PNG, JPEG, JPG).";
            return false;
        }

        // Optional: Check file size (example: max 2MB)
        if (hinhAnh.files[0].size > 2 * 1024 * 1024) {
            tbHinh.innerText = "(*) Kích thước ảnh vượt quá 2MB.";
            return false;
        }

        tbHinh.innerText = "*";
        return true;
    }

    // Hàm kiểm tra tất cả các trường khi submit
    function validateForm() {
        const validTenNL = checkTenNL();
        const validGia = checkGia();
        const validSoLuong = checkSoLuong();
        const validDonVi = checkDonVi();
        const validCuaHang = checkCuaHang();
        const validHinhAnh = checkHinhAnh();

        return validTenNL && validGia && validSoLuong && validDonVi && validCuaHang && validHinhAnh;
    }

    // Gắn sự kiện kiểm tra vào nút submit
    document.querySelector('[name="btnThem"]').addEventListener('click', function (event) {
        if (!validateForm()) {
            event.preventDefault(); // Ngăn không cho form submit nếu không hợp lệ
            alert("Vui lòng điền đầy đủ và chính xác thông tin trước khi gửi.");
        }
    });
</script>
