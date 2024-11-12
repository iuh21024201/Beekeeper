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
                    <input type="text" id="fullname" name="txtTDN" required placeholder="Nhập họ và tên">
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
    if(isset($_REQUEST["btnDK"])){
        include_once("controller/cNguoiDung.php");
        $p = new controlNguoiDung();

        // Corrected field name for re-entered password
        if(strcmp($_REQUEST["txtMK"], $_REQUEST["txtKTMK"]) == 0){
            $kq = $p->dangkytk($_REQUEST["txtTDN"], md5($_REQUEST["txtMK"]));  
            echo "<script>alert('Bạn đã đăng ký thành công!!!')</script>";
            header("refresh:0;url='?dangnhap'");
        } else {
            echo "<script>alert('Vui lòng nhập đúng mật khẩu!!!')</script>";
            header("refresh:0;url='?dangky'");
        }
    }
?>  
