<?php
    include_once("../../controller/c_mon_moi.php");  
    $p = new cNhanVien(); 
    $NhanVien = $p -> getNV($idTaiKhoan);

    if ($NhanVien && $NhanVien->num_rows > 0) {         
        while ($row = $NhanVien->fetch_assoc()) {             
            $idNhanVien = $row['ID_NhanVien'];             
        }     
    }
?>
<div>
    <h3>Đề xuất món mới:</h3>
    <form action="#" method="post" enctype="multipart/form-data">
        <div class="mb-3 mt-3">
            <label for="txtTenMon">Tên món:</label>
            <input type="text" class="form-control" id="txtTenMon" placeholder="Tên món" name="txtTenMon">
            <span class="text-danger" id="tbTenMon"></span>
        </div>

        <div class="mb-3">
            <label for="txtNguyenLieu">Danh sách nguyên liệu:</label>
            <textarea class="form-control" id="txtNguyenLieu" placeholder="Nguyên liệu" name="txtNguyenLieu"></textarea>
            <span class="text-danger" id="tbNguyenLieu"></span>
        </div>

        <div class="form-group">
            <label>Hình ảnh:</label>
            <input type="file" id="txtHinhAnh" name="txtHinhAnh" class="form-control-file">
            <span class="text-danger" id="tbHinhAnh"></span>
        </div>

        <div class="mb-3">
            <label for="txtMoTa">Mô tả:</label>
            <textarea class="form-control" id="txtMoTa" placeholder="Mô tả" name="txtMoTa"></textarea>
            <span class="text-danger" id="tbMoTa"></span>
        </div>

        <div class="mb-3">
            <label for="txtGia" class="form-label">Nhập giá món ăn:</label>
            <input type="text" class="form-control" id="txtGia" name="txtGia" placeholder="Nhập số tại đây!">
            <span class="text-danger" id="tbGia"></span>
        </div>

        <button type="submit" class="btn btn-primary" name="btnGui">Gửi</button>
        <button type="reset" class="btn btn-secondary">Hủy</button>
    </form>
</div>

<script>
    // Validation Form
    const txtTenMon = document.getElementById("txtTenMon");
    const tbTenMon = document.getElementById("tbTenMon");
    const txtNguyenLieu = document.getElementById("txtNguyenLieu");
    const tbNguyenLieu = document.getElementById("tbNguyenLieu");
    const txtHinhAnh = document.getElementById("txtHinhAnh");
    const tbHinhAnh = document.getElementById("tbHinhAnh");
    const txtMoTa = document.getElementById("txtMoTa");
    const tbMoTa = document.getElementById("tbMoTa");
    const txtGia = document.getElementById("txtGia");
    const tbGia = document.getElementById("tbGia");

    const validateForm = (event) => {
        let isValid = true;

        if (txtTenMon.value.trim() === "") {
            tbTenMon.textContent = "Tên món không được để trống!";
            isValid = false;
        } else {
            tbTenMon.textContent = "";
        }

        if (txtNguyenLieu.value.trim() === "") {
            tbNguyenLieu.textContent = "Danh sách nguyên liệu không được để trống!";
            isValid = false;
        } else {
            tbNguyenLieu.textContent = "";
        }

        if (!txtHinhAnh.files.length) {
            tbHinhAnh.textContent = "Vui lòng chọn một hình ảnh!";
            isValid = false;
        } else {
            const allowedExtensions = /(\.jpg|\.jpeg|\.png)$/i;
            if (!allowedExtensions.exec(txtHinhAnh.value)) {
                tbHinhAnh.textContent = "Hình ảnh phải là định dạng .jpg, .jpeg, hoặc .png!";
                isValid = false;
            } else {
                tbHinhAnh.textContent = "";
            }
        }

        if (txtMoTa.value.trim() === "") {
            tbMoTa.textContent = "Mô tả không được để trống!";
            isValid = false;
        } else {
            tbMoTa.textContent = "";
        }

        if (txtGia.value.trim() === "" || isNaN(txtGia.value) || txtGia.value <= 0) {
            tbGia.textContent = "Giá món ăn phải là số lớn hơn 0!";
            isValid = false;
        } else {
            tbGia.textContent = "";
        }

        if (!isValid) {
            event.preventDefault();
        }
    };

    document.querySelector("form").addEventListener("submit", validateForm);
</script>

<?php
include_once("../../model/ketnoi.php");

class FileUploader {
    public function uploadAnh($file, $tenMonAn, &$fileName) {
        $size = $file['size'];
        $type = $file['type'];
        $temp = $file['tmp_name'];

        if (!$this->checkSize($size) || !$this->checkType($type)) {
            return false;
        }

        $folder = "../../image/monmoi/";
        if (!file_exists($folder)) {
            mkdir($folder, 0777, true);
        }

        $extension = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
        $fileName = strtolower($this->sanitizeName($tenMonAn)) . "." . $extension;
        $destination = $folder . $fileName;

        return move_uploaded_file($temp, $destination);
    }

    private function checkSize($size) {
        return $size < 3 * 1024 * 1024; // dưới 3MB
    }

    private function checkType($type) {
        $allowedTypes = ["image/jpeg", "image/png", "image/jpg"];
        return in_array($type, $allowedTypes);
    }

    private function sanitizeName($name) {
        $name = preg_replace('/[^a-zA-Z0-9\s]/', '', $name);
        $name = preg_replace('/\s+/', '_', $name);
        return strtolower($name);
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $tenMonAn = $_POST['txtTenMon'];
    $nguyenLieu = $_POST['txtNguyenLieu'];
    $gia = $_POST['txtGia'];
    $moTa = $_POST['txtMoTa'];
    $date = date("Y-m-d");
    $fileName = null;

    $fileUploader = new FileUploader();
    if (isset($_FILES['txtHinhAnh']) && $_FILES['txtHinhAnh']['error'] === 0) {
        if (!$fileUploader->uploadAnh($_FILES['txtHinhAnh'], $tenMonAn, $fileName)) {
            die("Không thể upload hình ảnh!");
        }
    }

    $p = new clsketnoi();
    $con = $p->moKetNoi();

    $sql = "INSERT INTO danhsachdexuatmonmoi 
            (ID_NhanVien, TenMon, NguyenLieu, MoTa, Gia, TrangThai, Ngay, HinhAnh) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $con->prepare($sql);
     // Thay bằng giá trị ID nhân viên thực tế
    $trangThai = 0;

    $stmt->bind_param("isssdiss", $idNhanVien, $tenMonAn, $nguyenLieu, $moTa, $gia, $trangThai, $date, $fileName);

    if ($stmt->execute()) {
        echo "<script>alert('Thêm món mới thành công');
        window.location.href = 'index.php?action=de-xuat-mon-moi';
        </script>";
    } else {
        echo "Lỗi: " . $stmt->error;
    }

    $stmt->close();
    $con->close();
}
?>

