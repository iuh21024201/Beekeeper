<?php
session_start();
ob_start();
if(!isset($_SESSION["dn"]) || $_SESSION["dn"] != 5){
    echo"<script>alert('Bạn không có quyền truy cập')</script>";
    header("refresh:0;url='../../index.php'");
}  
$idTaiKhoan=isset($_GET["ID_TaiKhoan"]) ? intval($_GET["ID_TaiKhoan"]) : 0; 
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trang chủ</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="../../asset/css/bootstrap.min.css">
    <script src="../../asset/js/jquery-3.4.1.min.js"></script>
    <script src="../../asset/js/bootstrap.min.js"></script>
</head>
<style>
/* General styling */
body {
        font-family: Arial, sans-serif;
    }
    header {
        width: 80%;
        margin-left: 150px;
        background-color: #fff;
        padding: 20px;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    .logo {
        font-family: 'Knewave', cursive;
        font-size: 28px;
        font-weight: bold;
        color: #ff4d4d;
        text-transform: uppercase;
        font-style: italic;
    }
    nav ul {
        list-style: none;
        padding: 0;
        margin: 0;
        display: flex;
    }
    nav ul li {
        margin-right: 20px;
    }
    nav ul li a {
        text-decoration: none;
        color: black;
        font-weight: bold;
    }
    nav ul li a:hover {
        color: #ff4d4d;
    }
    .icons {
        display: flex;
        align-items: center;
        position: relative;
    }
    .icons a {
        text-decoration: none;
        color: black;
        font-size: 20px;
        margin-left: 15px;
        padding-right: 50px;
    }
    .icons a:hover {
        color: #ff4d4d;
    }
    .user-avatar {
        cursor: pointer;
    }
    .dropdown-menu {
        display: none;
        position: absolute;
        top: 100%;
        right: 0;
        background-color: white;
        box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
        z-index: 1;
        border-radius: 5px;
        overflow: hidden;
    }
    .dropdown-menu a {
        display: block;
        padding: 10px 15px;
        color: #333;
        text-decoration: none;
    }
    .dropdown-menu a:hover {
        background-color: #f1f1f1;
    }
    .icons:hover .dropdown-menu {
        display: block;
    }

</style>

<body>
<header>
        <div class="logo">BEEKEEPER</div>
        <nav>
            <ul>
                <li><a href="index.php">Trang chủ</a></li>
                <li><a href="thucdon.php">Thực đơn</a></li>
                <li><a href="#">Giới thiệu</a></li>
                <li><a href="lienhe.php">Liên hệ</a></li>
            </ul>
        </nav>
        <div class="icons">
    <a href="giohang.php"><i class="fas fa-shopping-cart"></i></a>
    <div class="user-avatar">
        <a href="#" id="userIcon"><i class="fas fa-user"></i></a>
        <div class="dropdown-menu">
            <a href="xemhoso.php">Xem hồ sơ</a>
            <a href="suahoso.php">Sửa hồ sơ</a>
            <a href="donhang.php">Đơn hàng</a>
            <a href="../account/logout.php" onclick="return confirm('Bạn có chắc chắn muốn đăng xuất?');">Đăng xuất</a>
        </div>
    </div>
</div>

    <script>

$(document).ready(function() {
    $("#userIcon").click(function(event) {
        event.preventDefault();
        $(".dropdown-menu").toggle(); // Toggle dropdown display
    });
    
    // Close dropdown when clicking outside of it
    $(document).click(function(event) { 
        if (!$(event.target).closest('.user-avatar').length) {
            $(".dropdown-menu").hide();
        }        
    });
});


</script>

</header>
    <div>
        <img style="width: 100%; " src="image/banner.png" alt="Banner" class="banner">
    </div>
    <div class="div" style="height:500px">

    </div>
    <div>
        <img style="width: 100%;" src="image/cover.png" alt="cover" class="cover">
    </div>
    <div class="div" style="height:500px">
    </div>
    <div class="footer">
    <div class="footer">        
            <table class="table table-footer table-borderless">
                <tr>
                    <td><a href="http://localhost/Beekeeper/view/customer/trangchu.php"><img src="image/logo_beekeeper.png" alt="" class ="logo_img"></a></td>
                    <td class="text-table">
                        <ul>
                            <li>
                                <b>CÔNG TY TNHH BEEKEEPER VIỆT NAM</b>
                            </li>
                            <li>
                                Địa chỉ: Phòng H4.02, Tòa H, Số 12 Nguyễn Văn Bảo, <br>Phường 4, Quận Gò Vấp, Thành phố Hồ Chí Minh. 
                            </li>
                            <li>Điện thoại: 0384902203</li>
                            <li>Hộp thư góp ý: <a href="http://localhost/Beekeeper/view/customer/lienhe.php">beekeeper.vn</a></li>
                        </ul>
                    </td>
                    <td class="text-table">
                        <ul>
                            <li>
                                <b>CHÍNH SÁCH </b>
                            </li>
                            <li>
                                <a href="http://localhost/Beekeeper/view/customer/lienhe.php">Liên hệ</a>
                            </li>
                            <li>
                                <a href="http://localhost/Beekeeper/view/customer/chinhsachvaquydinhchung.php">Chính sách và quy định chung</a>
                            </li>
                            <li>
                                <a href="http://localhost/Beekeeper/view/customer/chinhsachthanhtoankhidathang.php">Chính sách thanh toán khi đặt hàng</a>
                            </li>
                            <li>
                                <a href="http://localhost/Beekeeper/view/customer/chinhsachhoatdong.php">Chính sách hoạt động</a>
                            </li>
                            <li>
                                <a href="http://localhost/Beekeeper/view/customer/chinhsachbaomatthongtin.php">Chính sách bảo mật thông tin</a>
                            </li>
                            <li>
                                <a href="http://localhost/Beekeeper/view/customer/thongtinvanchuyenvagiaonhan.php">Thông tin vận chuyển và giao nhận</a>
                            </li>
                            <li>
                                <a href="http://localhost/Beekeeper/view/customer/thongtindangkygiaodichchung.php">Thông tin đăng ký giao dịch chung</a>
                            </li>
                            <li>
                                <a href="http://localhost/Beekeeper/view/customer/huongdandatphanan.php">Hướng dẫn đặt phần ăn</a>
                            </li>
                        </ul>
                    </td>
                    <td class="text-table">
                        <ul>
                            <li>
                                <h3><b>Kết nối cùng với nhau nhá!</b></h3>
                            </li>
                            <li>
                                <a href="">
                                    <i class="fa-brands fa-facebook fa-bounce fa-xl" style="color: #ff0000;"></i> Facebook
                                </a>
                            </li>
                            <li>
                                <a href="">
                                    <i class="fa-brands fa-google fa-xl" style="color: #ff0000;"></i> Gmail 
                                </a>
                            </li>
                            <li>
                                <a href="">
                                    <i class="fa-brands fa-instagram fa-xl" style="color: #ff0000;"></i> Instagram
                                </a>
                            </li>
                            <li>
                                <a href="">
                                <i class="fa-brands fa-tiktok fa-xl" style="color: #ff0000;"></i> Tiktok
                                </a>
                            </li>
                            <li>
                                <a href="">
                                    <i class="fa-solid fa-z fa-xl" style="color: #ff0000;"></i> Zalo
                                </a>
                            </li>
                            
                        </ul>
                    </td>
                </tr>
            </table>
</div>
    </div>
</body>
</html>