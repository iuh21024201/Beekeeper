<?php
session_start();
ob_start();
if(!isset($_SESSION["dn"]) || $_SESSION["dn"] != 3){
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
    <title>Quản trị nhân viên bán hàng</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="../../asset/css/bootstrap.min.css">
    <script src="../../asset/js/jquery-3.4.1.min.js"></script>
    <script src="../../asset/js/bootstrap.min.js"></script>
    <style>
       body {
    font-family: Arial, sans-serif;
    margin: 0;
    box-sizing: border-box;
}

header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    background-color: #f8f9fa;
    padding: 15px 30px;
    border-bottom: 1px solid #ddd;
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
    gap: 20px;
}

nav ul li {
    margin: 0;
}

nav ul li a {
    text-decoration: none;
    color: #333;
    font-weight: bold;
    font-size: 16px;
    transition: color 0.3s ease;
}

nav ul li a:hover {
    color: #ff4d4d;
}

.icons {
    display: flex;
    align-items: center;
    gap: 20px;
}

.icons a {
    text-decoration: none;
    color: #333;
    font-size: 20px;
    transition: color 0.3s ease;
}

.icons a:hover {
    color: #ff4d4d;
}

.dropdown {
    position: relative;
    display: inline-block;
}

.dropdown-content {
    display: none;
    position: absolute;
    right: 0;
    top: 100%;
    background-color: #ffffff;
    min-width: 160px;
    box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.2);
    z-index: 1000;
    border: 1px solid #ddd;
    border-radius: 4px;
}

.dropdown-content a {
    color: #333;
    padding: 10px 15px;
    text-decoration: none;
    display: block;
    font-size: 14px;
    transition: background-color 0.3s ease, color 0.3s ease;
}

.dropdown-content a:hover {
    background-color: #f1f1f1;
    color: #ff4d4d;
}

.dropdown:hover .dropdown-content {
    display: block;
}

#userIcon:hover {
    color: #ff4d4d;
}
#content {
    display: flex;
    height: 100vh; /* Chiều cao toàn màn hình */
    width: 100%;
}

#left, #right {
    flex: 1; /* Chia đều 2 nửa */
    padding: 20px;
}
/* CSS cho loại món ăn */
#left #loaimon a {
    display: inline-block;
    text-align: center;
    background-color: #ff4d4d; /* Màu nền đỏ */
    color: #ffffff; /* Màu chữ trắng */
    padding: 10px 20px;
    margin: 10px; /* Khoảng cách giữa các nút */
    border-radius: 8px; /* Bo góc */
    font-size: 16px;
    font-weight: bold;
    text-decoration: none; /* Xóa gạch chân */
    transition: background-color 0.3s ease, transform 0.2s ease;
}

#left #loaimon a:hover {
    background-color: #e63939; /* Màu nền khi hover */
    transform: scale(1.05); /* Phóng to khi hover */
}

/* table */


    </style>
</head>
<body>

<div id="container">
    <header>
        <div class="logo">
            BEEKEEPER
        </div>
        <nav>
            <ul>
                <li><a href="#">Trang bán hàng</a></li>
                <li><a href="trang-quan-tri.php">Trang quản trị</a></li>
                <li><a href="check-thanh-toan.php">Trang kiểm tra thanh toán</a></li>
            </ul>
        </nav>
        <div class="icons">
            <a href="?action=giohang"><i class="fas fa-shopping-cart <?php echo (isset($_REQUEST['action']) && $_REQUEST['action'] === 'giohang') ? 'active' : ''; ?>"></i></a>
            <div class="dropdown">
                <a href="#" id="userIcon"><i class="fas fa-user"></i></a>
                <div class="dropdown-content">
                    <a href="../account/hosoSale.php">Xem hồ sơ</a>
                    <a href="?action=logout">Đăng xuất</a>
                </div>
            </div> 
        </div>
    </header>


    </div>
  
</header>
<div id="content">
    <div id="left">
        <?php
        include_once("vListLoaiMonAn.php");
        include_once("vListSanPham.php");
        ?>
    </div>
    <div id="right">
        <?php
        include_once("tableMon.php");
        ?>
    
    </div>
</div>







<?php
// Hiển thị nội dung dựa trên tham số action trong URL
if (isset($_REQUEST["action"])) {
    $val = $_REQUEST["action"];
    switch ($val) {
        case 'index':
            include_once("index.php");
            break;   
        case 'hoso':
            include_once("../Account/hoso.php");
            break;
        case 'suahoso':
            include_once("../Account/suahoso.php");
            break;
        case 'logout':
            include_once("../Account/logout.php");
            break;
            case 'chitietdonhang':
                include_once("chitietdonhang.php");
                break;
                case 'chitietdonhang':
                    include_once("chitietdonhang.php");
                    break;
        default:
            include_once("index.php"); // Add this line to load trangchu.php as a fallback
            break;
    }
}
?>
</div>

</body>
</html>
