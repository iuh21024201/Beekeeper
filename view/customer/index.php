<?php
session_start();
ob_start();
if(!isset($_SESSION["dn"]) || $_SESSION["dn"] != 5){
    echo"<script>alert('Bạn không có quyền truy cập')</script>";
    header("refresh:0;url='../../index.php'");
}  
$idTaiKhoan=isset($_SESSION["ID_TaiKhoan"]) ? intval($_SESSION["ID_TaiKhoan"]) : 0; 
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
        body {
            font-family: Arial, sans-serif;
        }
        /* Flexbox layout for header */
        header {
            width: 80%;
            margin-left: 150px;
            background-color: #fff;
            padding: 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        /* Logo styling */
        .logo {
            font-family: 'Knewave', cursive;
            font-size: 28px;
            font-weight: bold;
            color: #ff4d4d;
            text-transform: uppercase;
            font-style: italic;
        }
        /* Navigation bar styling */
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
        /* Icon container */
        .icons {
            display: flex;
            align-items: center;
        }
        .icons a {
            text-decoration: none;
            color: black;
            font-size: 20px;
            margin-left: 15px;
        }

        .icons a:hover {
            color: #ff4d4d;
        }
        .logo:hover {
            color: #000;
            text-decoration: none;
        }
        h2{
            text-align: center;
            font-size: 32px;
            color: #ff4d4d;
            margin-top: 30px;
            margin-bottom: 20px;
        }
        #search{
            float: right;
            margin-right: 30px;
        }
        /* footer */
        .footer {
            background-image: url('image/footer.png'); 
            background-size: cover; 
            background-position: center;
            color: #fff; 
            /* padding: 40px 0;  */
            /* text-align: center; */
            width: 100%;
            height: 555px;
        }
        /* footer */
        footer {
            background-image: url('image/footer.png'); 
            background-size: cover; 
            background-position: center;
            color: #fff; 
            /* padding: 40px 0;  */
            /* text-align: center; */
            width: 100%;
            height: 555px;
        }
        .logo_img{
            height: 150px;
            float: left;
        }
        footer td{
            text-align: left;
        }
        footer{
            padding: 50px 0;
        }
        footer .text-table{
            width: 30%;
        }
        footer .text-table a{
            color: #000;
        }
        footer ul{
            list-style-type: none;
        }
        footer ul li {
            text-align: left;
            font-size: 22px;
            line-height: 2;
        }

        /* Navigation bar styling gio hang */
        .giohang nav ul {
            list-style: none;
            padding: 0;
            margin: 0;
            display: flex;
        }
        .giohang nav ul li {
            margin-right: 20px;
        }
        .giohang nav ul li a {
            text-decoration: none;
            color: black;
            font-weight: bold;
        }
        .giohang nav ul li a:hover {
            color: #ff4d4d;
        }
        /* Icon container */
        .giohang .icons {
            display: flex;
            align-items: center;
        }
        .giohang .icons a {
            text-decoration: none;
            color: black;
            font-size: 20px;
            margin-left: 15px;
        }

        .giohang .icons a:hover {
            color: #ff4d4d;
        }
        .giohang h2{
            text-align: center;
            font-size: 32px;
            color: #ff4d4d;
            margin-top: 30px;
            margin-bottom: 20px;
        }
        /* Table styling */
        .giohang table {
            width: 80%;
            margin-left: 200px;
            border-collapse: collapse;
            margin-top: 20px;
        }
        .giohang table,th,td {
            border: 1px solid black;
        }
        .giohang th,
        .giohang td {
            padding: 8px;
            text-align: center;
            font-size: 14px;
        }
        /* Order button styling */
        .giohang .order-btn {
            background-color: #ff4d4d;
            color: white;
            padding: 8px 16px;
            font-size: 16px;
            text-align: center;
            border: none;
            margin-top: 20px;
            display: block;
            width: 200px;
            cursor: pointer;
            margin-left: auto;
            margin-right: auto;
            font-weight: bold;
        }
        .giohang .order-btn:hover {
            background-color: #e63939;
        }
        .giohang #form {
            background-color: #FD9A9A;
            margin-top: 20px;
            margin-left: auto;
            margin-right: auto;
            border-radius: 0.5rem;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 700px;
            display: none;
        }
        .giohang #form h4 {
            text-align: center;
            color: #000000;
            font-weight: bold;
            margin-bottom: 20px;
            margin-top: 20px;
        }
        .giohang #orderForm {
            padding: 20px;
        }
        .giohang .btn-thanhtoan,.btn-thanhtoan1 {
            margin-left: 250px;
            margin-top: 20px;
            background-color: #ef4444;
            color: #ffffff;
            font-weight: bold;
            padding: 10px 10px;
            border: none;
            border-radius: 20px;
            cursor: pointer;
        }
        .giohang .form-group {
            margin-bottom: 10px;
        }
        .giohang .form-group:last-of-type {
            margin-bottom: 15px;
        }
        .giohang input[type="text"] {
            width: 100%;
            padding: 5px;
            background-color: #d1d5db;
            border: 1px solid #9ca3af;
            border-radius: 10px;
        }
        .giohang label {
            display: block;
            color: #000000;
            margin-bottom: 5px;
        }
        .giohang #orderSummary{
            width: 60%;
            margin-left: 200px;
            margin-top: 30px;
        }
        .main{
            display: flex;
        }
        .menu-container {
            margin-left: 20px;
        }
        .menu-item {
            margin-bottom: 20px;
            padding: 10px;
            text-align: center;
        }
        .sidebar {
            margin-left: 160px;
            width: 200px;
            padding: 20px;
            background-color: #f8f8f8;
        }
        .sidebar div {
            margin-top: 10px; 
        }
        .sidebar a {
            text-decoration: none;
            color: black;
            font-weight: bold;
        }
        .sidebar a:hover {
            color: #ff4d4d;
        }
        /* Dropdown container styling */
.dropdown {
    position: relative;
    display: inline-block;
}

/* Dropdown content (hidden by default) */
.dropdown-content {
    display: none;
    position: absolute;
    background-color: #f9f9f9;
    min-width: 160px;
    box-shadow: 0px 8px 16px rgba(0, 0, 0, 0.2);
    z-index: 1;
}

/* Links inside the dropdown */
.dropdown-content a {
    color: black;
    padding: 12px 16px;
    text-decoration: none;
    display: block;
    font-size: 16px;
}

.dropdown-content a:hover {
    background-color: #f1f1f1;
}

/* Show the dropdown when hovering over the icon */
.dropdown:hover .dropdown-content {
    display: block;
}

/* Optional: change icon color when active */
#userIcon:hover {
    color: #ff4d4d;
}

</style>

<body>
<header>
        <div >
            <a href="?action=index" class="logo <?php echo (isset($_REQUEST['action']) && $_REQUEST['action'] === 'index') ? 'active' : ''; ?>" >
            <?php echo $idTaiKhoan;?>    
            BEEKEEPER
            </a>
        </div>
        <nav>
            <ul>
                <li>
                    <a href="?action=index" class=" <?php echo (isset($_REQUEST['action']) && $_REQUEST['action'] === 'index') ? 'active' : ''; ?>" >Trang chủ</a>
                </li>
                <li><a href="?action=thucdon" class=" <?php echo (isset($_REQUEST['action']) && $_REQUEST['action'] === 'thucdon') ? 'active' : ''; ?>" >Thực đơn</a></li>
                <li><a href="?action=dattiec" class=" <?php echo (isset($_REQUEST['action']) && $_REQUEST['action'] === 'dattiec') ? 'active' : ''; ?>" >Đặt tiệc</a></li>
                <li><a href="?action=gioithieu" class=" <?php echo (isset($_REQUEST['action']) && $_REQUEST['action'] === 'gioithieu') ? 'active' : ''; ?>" >Giới thiệu</a></li>
                <li><a href="?action=lienhe" class=" <?php echo (isset($_REQUEST['action']) && $_REQUEST['action'] === 'lienhe') ? 'active' : ''; ?>" >Liên hệ</a></li>
            </ul>
        </nav>
        <div class="icons">
            <a href="?action=giohang"><i class="fas fa-shopping-cart <?php echo (isset($_REQUEST['action']) && $_REQUEST['action'] === 'giohang') ? 'active' : ''; ?>"></i></a>
            <div class="dropdown">
                <a href="#" id="userIcon"><i class="fas fa-user"></i></a>
                <div class="dropdown-content">
                    <a href="?action=hoso">Xem hồ sơ</a>
                    <a href="?action=suahoso">Sửa hồ sơ</a>
                    <a href="?action=donhang">Đơn hàng</a>
                    <a href="?action=logout">Đăng xuất</a>
                </div>
            </div> 
        </div>
</header>
<nav>
<div class="content" id="content">
          <?php
          // Hiển thị nội dung dựa trên tham số action trong URL
          if (isset($_REQUEST["action"])) {
            $val = $_REQUEST["action"];
            switch ($val) {
                case 'thucdon':
                    include_once("thucdon.php");
                    break;
                case 'gioithieu':
                    include_once("gioithieu.php");
                    break;
                case 'lienhe':
                    include_once("lienhe.php");
                    break;
                case 'donhang':
                    include_once("donhang.php");
                    break;
                case 'dattiec':
                    include_once("dattiec.php");
                    break;
                case 'giohang':
                    include_once("giohang.php");
                    break;
                case 'thanhtoan':
                    include_once("thanhtoan.php");
                    break;
                case 'chitietdonhang':
                    include_once("chitietdonhang.php");
                    break;
                    case 'chitietdonhang':
                        include_once("chitietdonhang.php");
                        break;
                case 'chinhsachvaquydinhchung':
                    include_once("chinhsachvaquydinhchung.php");
                    break;
                case 'chinhsachthanhtoankhidathang':
                    include_once("chinhsachthanhtoankhidathang.php");
                    break;
                case 'chinhsachhoatdong':
                    include_once("chinhsachhoatdong.php");
                    break;
                case 'chinhsachbaomatthongtin':
                    include_once("chinhsachbaomatthongtin.php");
                    break;
                case 'thongtinvanchuyenvagiaonhan':
                    include_once("thongtinvanchuyenvagiaonhan.php");
                    break;
                case 'thongtindangkygiaodichchung':
                    include_once("thongtindangkygiaodichchung.php");
                    break;
                case 'huongdandatphanan':
                    include_once("huongdandatphanan.php");
                    break;
                case 'index':
                    include_once("trangchu.php");
                    break;
                case 'hoso':
                    include_once("../account/hoso.php");
                    break;
                case 'suahoso':
                    include_once("../account/suahoso.php");
                    break;
                case 'logout':
                    include_once("../account/logout.php");
                    break;
                default:
                    include_once("trangchu.php"); // Add this line to load trangchu.php as a fallback
                    break;
            }
        } else {
            include_once("trangchu.php"); // Load trangchu.php when no action is set
        }        
          ?>
        </div>
</nav>
<footer>
<table class="table table-footer table-borderless">
                <tr>
                    <td>
                        <a href="?action=index" class=" <?php echo (isset($_REQUEST['action']) && $_REQUEST['action'] === 'index') ? 'active' : ''; ?>" >
                            <img src="image/logo_beekeeper.png" alt="" class ="logo_img">
                        </a>
                    </td>
                    <td class="text-table">
                        <ul>
                            <li>
                                <b>CÔNG TY TNHH BEEKEEPER VIỆT NAM</b>
                            </li>
                            <li>
                                <b>Địa chỉ:</b> Phòng H4.02, Số 12 Nguyễn Văn Bảo, Phường 4, Quận Gò Vấp, Thành phố Hồ Chí Minh. 
                            </li>
                            <li>Điện thoại: 0384902203</li>
                            <li>Hộp thư góp ý: 
                                <a href="?action=lienhe" class=" <?php echo (isset($_REQUEST['action']) && $_REQUEST['action'] === 'lienhe') ? 'active' : ''; ?>" >
                                beekeeper.vn
                                </a>
                            </li>
                        </ul>
                    </td>
                    <td class="text-table">
                        <ul>
                            <li>
                                <b>CHÍNH SÁCH </b>
                            </li>
                            <li>
                                <a href="?action=lienhe" class=" <?php echo (isset($_REQUEST['action']) && $_REQUEST['action'] === 'lienhe') ? 'active' : ''; ?>" >
                                Liên hệ
                                </a>
                            </li>
                            <li>
                                <a href="?action=chinhsachvaquydinhchung" class=" <?php echo (isset($_REQUEST['action']) && $_REQUEST['action'] === 'chinhsachvaquydinhchung') ? 'active' : ''; ?>" >
                                Chính sách và quy định chung
                                </a>
                            </li>
                            <li>
                                <a href="?action=chinhsachthanhtoankhidathang" class=" <?php echo (isset($_REQUEST['action']) && $_REQUEST['action'] === 'chinhsachthanhtoankhidathang') ? 'active' : ''; ?>" >
                                Chính sách thanh toán khi đặt hàng
                                </a>
                            </li>
                            <li>
                                <a href="?action=chinhsachhoatdong" class=" <?php echo (isset($_REQUEST['action']) && $_REQUEST['action'] === 'chinhsachhoatdong') ? 'active' : ''; ?>" >
                                Chính sách hoạt động
                                </a>
                            </li>
                            <li>
                                <a href="?action=chinhsachbaomatthongtin" class=" <?php echo (isset($_REQUEST['action']) && $_REQUEST['action'] === 'chinhsachbaomatthongtin') ? 'active' : ''; ?>" >
                                Chính sách bảo mật thông tin
                                </a>
                            </li>
                            <li>
                                <a href="?action=thongtinvanchuyenvagiaonhan" class=" <?php echo (isset($_REQUEST['action']) && $_REQUEST['action'] === 'thongtinvanchuyenvagiaonhan') ? 'active' : ''; ?>" >
                                Thông tin vận chuyển và giao nhận
                                </a>
                            </li>
                            <li>
                                <a href="?action=thongtindangkygiaodichchung" class=" <?php echo (isset($_REQUEST['action']) && $_REQUEST['action'] === 'thongtindangkygiaodichchung') ? 'active' : ''; ?>" >
                                Thông tin đăng ký giao dịch chung
                                </a>
                            </li>
                            <li>
                                <a href="?action=huongdandatphanan" class=" <?php echo (isset($_REQUEST['action']) && $_REQUEST['action'] === 'huongdandatphanan') ? 'active' : ''; ?>" >
                                Hướng dẫn đặt phần ăn
                                </a>
                            </li>
                        </ul>
                    </td>
                    <td class="text-table">
                        <ul>
                            <li>
                                <h3><b>Kết nối cùng với nhau nhá!</b></h3>
                            </li>
                            <li>
                            <a href="https://www.facebook.com/">
                                    <i class="fa-brands fa-facebook fa-bounce fa-xl" style="color: #ff0000;"></i> Facebook
                                </a>
                            </li>
                            <li>
                            <a href="https://www.facebook.com/">
                                    <i class="fa-brands fa-google fa-xl" style="color: #ff0000;"></i> Gmail 
                                </a>
                            </li>
                            <li>
                            <a href="https://www.facebook.com/">
                                    <i class="fa-brands fa-instagram fa-xl" style="color: #ff0000;"></i> Instagram
                                </a>
                            </li>
                            <li>
                            <a href="https://www.facebook.com/">
                                <i class="fa-brands fa-tiktok fa-xl" style="color: #ff0000;"></i> Tiktok
                                </a>
                            </li>
                            <li>
                            <a href="https://www.facebook.com/">
                                    <i class="fa-solid fa-z fa-xl" style="color: #ff0000;"></i> Zalo
                                </a>
                            </li>
                            
                        </ul>
                    </td>
                </tr>
            </table>
</footer>
   
</body>
</html>