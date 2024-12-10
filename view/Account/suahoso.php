<?php
include_once('../../Controller/cNguoiDung.php');
$p = new controlNguoiDung(); 

// Lấy ID tài khoản từ session
$maKH = $_SESSION['ID_TaiKhoan'] ?? null;

// Kiểm tra ID tài khoản
if ($maKH === null) {
    echo "<script>alert('Bạn chưa đăng nhập! Vui lòng đăng nhập để tiếp tục.')</script>";
    header("refresh:0; url='login.php'");
    exit;
}

$kh = $p->getOneNguoiDung($maKH);

// Kiểm tra dữ liệu khách hàng
if ($kh && mysqli_num_rows($kh) > 0) {
    $r = mysqli_fetch_assoc($kh);
    $idKH = $r["ID_KhachHang"];
    $hoTen = $r["HoTen"];
    $soDienThoai = $r["SoDienThoai"];
    $email = $r["Email"];
    $diaChi = $r["DiaChi"];
} else {
    echo "<script>alert('Không tìm thấy thông tin khách hàng!')</script>";
    header("refresh:0; url='?action=hoso'");
    exit;
}
?>

<h2 style="text-align: center; margin-top: 20px;">Cập nhật hồ sơ khách hàng</h2>

<!-- Form để cập nhật thông tin khách hàng -->
<form action="#" method="post" enctype="multipart/form-data" class="tblCate" style="width: 50%; margin: auto; border: 1px solid #ccc; padding: 20px; border-radius: 8px; box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);">
    <div style="margin-bottom: 15px;">
        <label for="hoTen" style="display: block; font-weight: bold;">Họ và tên:</label>
        <input type="text" name="hoTen" id="hoTen" required value="<?php echo $hoTen; ?>" style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 4px;">
    </div>
    <div style="margin-bottom: 15px;">
        <label for="soDienThoai" style="display: block; font-weight: bold;">Số điện thoại:</label>
        <input type="text" name="soDienThoai" id="soDienThoai" required value="<?php echo $soDienThoai; ?>" style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 4px;">
    </div>
    <div style="margin-bottom: 15px;">
        <label for="email" style="display: block; font-weight: bold;">Email:</label>
        <input type="email" name="email" id="email" required value="<?php echo $email; ?>" style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 4px;">
    </div>
    <div style="margin-bottom: 15px;">
        <label for="diaChi" style="display: block; font-weight: bold;">Địa chỉ:</label>
        <input type="text" name="diaChi" id="diaChi" required value="<?php echo $diaChi; ?>" style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 4px;">
    </div>
    <div style="text-align: center;">
        <input type="submit" name="btnCapNhat" value="Cập nhật" style="padding: 10px 20px; background-color: #28a745; color: #fff; border: none; border-radius: 4px; cursor: pointer;">
        <input type="reset" value="Hủy" style="padding: 10px 20px; background-color: #dc3545; color: #fff; border: none; border-radius: 4px; cursor: pointer;">
    </div>
</form>

<?php
if (isset($_POST['btnCapNhat'])) {
    // Nhận giá trị từ form
    $hoTenMoi = $_POST['hoTen'];
    $soDienThoaiMoi = $_POST['soDienThoai'];
    $emailMoi = $_POST['email'];
    $diaChiMoi = $_POST['diaChi'];

    // Gọi hàm cập nhật thông tin khách hàng
    $kq = $p->updateNguoiDung($idKH, $hoTenMoi, $soDienThoaiMoi, $emailMoi, $diaChiMoi);
    if ($kq) {
        echo "<script>alert('Cập nhật thành công!')</script>";
        header("refresh:0.5; url=?action=hoso");
    } else {
        echo "<script>alert('Cập nhật thất bại! Vui lòng thử lại.')</script>";
    }
}
?>
