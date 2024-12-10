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
<form name="frmDangNhap" method="POST" action="#"> 
    <table style="margin-top: 20px;"> 
        <tr>
            <td><label for="name">Họ và tên:</label></td>
            <td>
                <input type="text" id="email" name="txtTDN" required placeholder="Nhập email của bạn" style="width: 100%;">
                <span id="errorEmail" class="error">*</span>
            </td>
        </tr>
        <tr>
            <td><label for="password">Mật khẩu:</label></td>
            <td>
                <input type="password" id="password" name="txtMK" required placeholder="Nhập mật khẩu của bạn" style="width: 100%;">
                <span id="errorPassword" class="error">*</span>
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

