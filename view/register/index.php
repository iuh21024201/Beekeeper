<form name="frmDangKy" method="POST" action="#">
<table align="center"> 
    <tr>
        <td>Họ và tên:</td>
        <td> <input type="text" name="txtTDN" required placeholder="Nhập họ và tên"></td>
    </tr>
    <tr>
        <td>Số điện thoại:</td>
        <td> <input type="text" name="txtTDN" required placeholder="Nhập số điện thoại"></td>
    </tr>
    <tr>
        <td>Email:</td>
        <td> <input type="text" name="txtTDN" required placeholder="Nhập email"></td>
    </tr>
    <tr>
        <td>Mật khẩu:</td>
        <td> <input type="password" name="txtMK" required placeholder="Nhập mật khẩu"></td>
    </tr>
    <tr>
        <td>Nhập lại mật khẩu:</td>
        <td> <input type="password" name="txtMKT" required placeholder="Nhập lại mật khẩu"></td>
    </tr>
    <tr>
        <td colspan ="2">
            <input type="submit" name="btnDK" value="Đăng ký">
        </td>
    </tr>
</table>
</from>
<?php
    if(isset($_REQUEST["btnDK"])){
        include_once("Controller/cNguoiDung.php");
        $p = new controlNguoiDung();
        if(strcmp($_REQUEST["txtMK"], $_REQUEST["txtMKT"]) == 0){
          $kq=$p -> dangkytk($_REQUEST["txtTDN"],md5($_REQUEST["txtMK"]));  
          echo"<script>alert('Bạn đã đăng ký thành công!!!')</script>";
          header("refresh:0;url='?dangnhap'");
        }else{
            echo "<script>alert('Vui lòng nhập đúng mật khẩu!!!')</script>";
            header("refresh:0;url='?dangky'");
        }
    }
?>
