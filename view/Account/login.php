<<<<<<< HEAD:view/Account/login.php
=======
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Form Đăng Nhập</title>
    <script src="../asset/js/login.js"></script>
    <style>
        .error { color: red; font-size: 0.9em; float: left; }
    </style>
</head>
<body>
>>>>>>> 8f5f874bd7c43da9ee203083fcb2e92a789f6eb6:view/Account/loginView.php
<form name="frmDangNhap" method="POST" action="#"> 
    <!-- Navigation links with active style -->
    <table style="margin-top: 20px;"> 
        <tr>
            <td>Tài Khoản:</td>
            <td><input type="text" name="txtTDN" required placeholder="Nhập email của bạn" style="width: 100%;"></td>
        </tr>
        <tr>
            <td>Mật khẩu:</td>
            <td><input type="password" name="txtMK" required placeholder="Nhập mật khẩu của bạn" style="width: 100%;"></td>
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

<?php
    if(isset($_REQUEST["btnDN"])){
        include_once("controller/cNguoiDung.php");
        $p = new controlNguoiDung();
        $kq=$p -> get01NguoiDung($_REQUEST["txtTDN"],$_REQUEST["txtMK"]);
    }
?>

