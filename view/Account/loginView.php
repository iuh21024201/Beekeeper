<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Form Đăng Ký</title>
    <script src="../asset/js/login.js"></script>
    <style>
        .error { color: red; font-size: 0.9em; float: left; }
    </style>
</head>
<body>
<form name="frmDangNhap" method="POST" action="#"> 
    <table style="margin-top: 20px;"> 
        <tr>
            <td>Tài Khoản:</td>
            <td>
                <input type="text" id="email" name="txtTDN" required placeholder="Nhập email của bạn" style="width: 100%;">
                <span id="errorEmail" class="error">*</span>
            </td>
        </tr>
        <tr>
            <td>Mật khẩu:</td>
            <td>
                <input type="password" id="password" name="txtMK" required placeholder="Nhập mật khẩu của bạn" style="width: 100%;">
                <span id="errorPassword" class="error">*</span>
            </td>
        </tr>
        <tr>
            <td colspan="2" style="text-align: right;">
                <a href="?quenmk" class="forgot-password">Quên mật khẩu</a>
            </td>
        </tr>
        <tr>
            <td colspan="2" style="text-align: center;">
                <input type="submit" name="btnDN" value="Đăng nhập" class="btn">
            </td>
        </tr>
    </table>
</form>

</body>
<?php
    if(isset($_REQUEST["btnDN"])){
        include_once("controller/cNguoiDung.php");
        $p = new controlNguoiDung();
        $kq=$p -> get01NguoiDung($_REQUEST["txtTDN"],$_REQUEST["txtMK"]);
    }
?>
