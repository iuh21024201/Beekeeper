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
    <title>Hồ sơ nhân viên</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="../../asset/css/bootstrap.min.css">
    <script src="../../asset/js/jquery-3.4.1.min.js"></script>
    <script src="../../asset/js/bootstrap.min.js"></script>
</head>
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
</style>
<body>
<header>
    <div class="logo">
        BEEKEEPER
    </div>
    <nav>
        <ul>
            <li><a href="../sale/index.php">Trang bán hàng</a></li>
            <li><a href="../sale/trang-quan-tri.php">Trang quản trị</a></li>
        </ul>
    </nav>
    <div class="icons">
        <div class="dropdown">
            <a href="#" id="userIcon"><i class="fas fa-user"></i></a>
            <div class="dropdown-content">
                <a href="../account/hosoSale.php">Xem hồ sơ</a>
                <a href="logout.php">Đăng xuất</a>
            </div>
        </div>
    </div>
</header>
    <?php
include_once("../../controller/c_lay_nhan_vien.php");
$p = new cNhanVien();
$maNV = $_SESSION['ID_TaiKhoan'] ?? null;

if ($maNV === null) {
    echo "Người dùng chưa đăng nhập!";
} else {
    $kq = $p->get01NhanVien($maNV);
    if (!$kq) {
        echo "No data!";
    } else {
        echo '<style>
        .card-container {
            width: 80%;
            margin: 20px auto;
            display: flex;
            align-items: center;
            font-family: Arial, sans-serif;
            background-color: #f9f9f9;
            border: 1px solid #ddd;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }
        .card-image {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            object-fit: cover;
            margin-right: 20px;
            flex-shrink: 0;
        }
        .card-details {
            display: flex;
            flex-direction: column;
            gap: 6px;
        }
        .card-details div {
            font-size: 16px;
            color: #333;
        }
        .card-details div label {
            font-weight: bold;
            color: #4CAF50;
            margin-right: 8px;
        }
        .action-link {
            margin-top: 10px;
            color: #4CAF50;
            text-decoration: none;
            font-weight: bold;
        }
        .action-link:hover {
            text-decoration: underline;
        }
    </style>';


        while ($r = mysqli_fetch_assoc($kq)) {
            echo "<div class='card-container'>";
            echo "<img src='../../asset/image/user.jpg' alt='Avatar' class='card-image'>"; // Đường dẫn tới ảnh đại diện mặc định
            echo "<div class='card-details'>";
            echo "<div><label>ID nhân viên:</label> " . $r["ID_NhanVien"] . "</div>";
            echo "<div><label>ID Cửa hàng:</label> " . $r["ID_CuaHang"] . "</div>";
            echo "<div><label>Họ và tên:</label> " . $r["HoTen"] . "</div>";
            echo "<div><label>Số điện thoại:</label> " . $r["SoDienThoai"] . "</div>";
            echo "<div><label>Email:</label> " . $r["Email"] . "</div>";
            echo "</div></div>";
        }
    }
}
?>

</body>
</html>

