<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Form Đăng Ký</title>
    <script src="../asset/js/register.js"></script>
    <style>
        .error { color: red; font-size: 0.9em; float: left; }
    </style>
</head>
<body>
    <form name="frmDangKy" method="POST" action="#">
        <table> 
            <tr>
                <td>Họ và tên:</td>
                <td>
                    <input type="text" id="fullname" name="txtTen" required placeholder="Nhập họ và tên">
                    <span id="errorFullname" class="error">*</span>
                </td>
            </tr>
            <tr>
                <td>Số điện thoại:</td>
                <td>
                    <input type="text" id="phone" name="txtSDT" required placeholder="Nhập số điện thoại">
                    <span id="errorPhone" class="error">*</span>
                </td>
            </tr>
            <tr>
                <td>Email:</td>
                <td>
                    <input type="text" id="email" name="txtEmail" required placeholder="Nhập email">
                    <span id="errorEmail" class="error">*</span>
                </td>
            </tr>
            <tr>
                <td>Địa chỉ:</td>
                <td>
                    <input type="text" id="address" name="txtDiaChi" required placeholder="Nhập địa chỉ">
                    <span id="errorAddress" class="error">*</span>
                </td>
            </tr>
            <tr>
                <td>Mật khẩu:</td>
                <td>
                    <input type="password" id="password" name="txtMK" required placeholder="Nhập mật khẩu">
                    <span id="errorPassword" class="error">*</span>
                </td>
            </tr>
            <tr>
                <td>Nhập lại mật khẩu:</td>
                <td>
                    <input type="password" id="confirmPassword" name="txtKTMK" required placeholder="Nhập lại mật khẩu">
                    <span id="errorConfirmPassword" class="error">*</span>
                </td>
            </tr>
            <tr>
                <td colspan="2" align="center">
                    <input type="submit" name="btnDK" value="Đăng ký">
                </td>
            </tr>
        </table>
    </form>
</body>
</html>

<?php
if (isset($_REQUEST["btnDK"])) {
    include_once("controller/cNguoiDung.php");
    $p = new controlNguoiDung();

    // Retrieve and sanitize inputs
    $tenND = trim($_REQUEST["txtTen"]);
    $soDienThoai = trim($_REQUEST["txtSDT"]);
    $email = trim($_REQUEST["txtEmail"]);
    $matKhau = trim($_REQUEST["txtMK"]);
    $xacNhanMatKhau = trim($_REQUEST["txtKTMK"]);
    $diaChi = trim($_REQUEST["txtDiaChi"]);

    // Regular expressions for validation
    $tenNDRegex = "/^([A-ZÀÁÂÃÈÉÊÌÍÒÓÔÕÙÚĂĐĨŨƠƯẠ-ỹ]{1}[a-zàáâãèéêìíòóôõùúăđĩũơưạ-ỹ]+)(\s([A-ZÀÁÂÃÈÉÊÌÍÒÓÔÕÙÚĂĐĨŨƠƯẠ-ỹ]{1}[a-zàáâãèéêìíòóôõùúăđĩũơưạ-ỹ]+))*$/";
    $phoneRegex = "/^0\d{9}$/";
    $emailRegex = "/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/";
    $addressRegex = "/^[a-zA-Z0-9ÀÁÂÃÈÉÊÌÍÒÓÔÕÙÚĂĐĨŨƠƯàáâãèéêìíòóôõùúăđĩũơưẠ-ỹ\s,.-]{5,100}$/";

    // Validate each field
    if (!preg_match($tenNDRegex, $tenND)) {
        echo "<script>alert('Họ và tên không hợp lệ. Chữ cái đầu phải viết hoa và có ít nhất 2 ký tự mỗi từ.')</script>";
        header("refresh:0;url='?dangky'");
        exit();
    }

    if (!preg_match($phoneRegex, $soDienThoai)) {
        echo "<script>alert('Số điện thoại không hợp lệ. Phải bắt đầu bằng số 0 và có đúng 10 chữ số.')</script>";
        header("refresh:0;url='?dangky'");
        exit();
    }

    if (!preg_match($emailRegex, $email)) {
        echo "<script>alert('Email không hợp lệ. Vui lòng nhập đúng định dạng email (example@gmail.com).')</script>";
        header("refresh:0;url='?dangky'");
        exit();
    }

    if (!preg_match($addressRegex, $diaChi)) {
        echo "<script>alert('Địa chỉ không hợp lệ. Vui lòng nhập tối thiểu 5 ký tự, chỉ bao gồm chữ, số, khoảng trắng, dấu phẩy, dấu chấm, và dấu gạch ngang.')</script>";
        header("refresh:0;url='?dangky'");
        exit();
    }

    if (strlen($matKhau) < 6) {
        echo "<script>alert('Mật khẩu phải có ít nhất 6 ký tự.')</script>";
        header("refresh:0;url='?dangky'");
        exit();
    }

    // Check if passwords match
    if (strcmp($matKhau, $xacNhanMatKhau) != 0) {
        echo "<script>alert('Vui lòng nhập đúng mật khẩu!!!')</script>";
        header("refresh:0;url='?dangky'");
        exit();
    }

    // Call dangkytk with all six arguments
    $kq = $p->dangkytk($tenND, $soDienThoai, $email, md5($matKhau), $diaChi);
    
    if ($kq) {
        echo "<script>alert('Bạn đã đăng ký thành công!!!')</script>";
        header("refresh:0;url='?dangnhap'");
    } else {
        echo "<script>alert('Đăng ký thất bại, vui lòng thử lại!')</script>";
        header("refresh:0;url='?dangky'");
    }
}
?>

  
