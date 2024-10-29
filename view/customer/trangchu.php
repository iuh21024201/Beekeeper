<?php
// session_start();
// if(isset($_SESSION["dn"]==6)){
//     echo"<script>alert('Đăng nhập thành công')</script>";
//     header("refresh:0;url='customer/index.php'");
// } else{
//     echo"<script>alert('Bạn không có quyền truy cập')</script>";
//     header("refresh:0;url='index.php'");
// }  
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
        .footer {
            background-image: url('image/footer.png'); 
            background-size: cover; 
            background-position: center;
            color: #fff; 
            padding: 40px 0; 
            text-align: center;
            width: 100%;
            height: 100%;
        }
        .footer .footer-content {
            color: black;
            max-width: 80%;
            margin: auto;
            line-height: 1.6;
        }
        .footer h3 {
            font-size: 24px;
            margin-bottom: 10px;
        }
        .footer p {
            font-size: 16px;
            margin: 5px 0;
        }
</style>

<body>
<header>
        <div class="logo">BEEKEEPER</div>
        <nav>
            <ul>
                <li><a href="trangchu.php">Trang chủ</a></li>
                <li><a href="thucdon.php">Thực đơn</a></li>
                <li><a href="#">Giới thiệu</a></li>
                <li><a href="lienhe.php">Liên hệ</a></li>
            </ul>
        </nav>
        <div class="icons">
            <a href="donhang.php"><i class="fas fa-user"></i></a>
            <a href="giohang.php"><i class="fas fa-shopping-cart"></i></a>
        </div>
    </header>
    <div>
        <img style="width: 100%; height: 600px;" src="image/banner.png" alt="Banner" class="banner">
    </div>
    <div class="div" style="height:500px">

    </div>
    <div>
        <img style="width: 100%; height: 400px;" src="image/cover.png" alt="cover" class="cover">
    </div>
    <div class="div" style="height:500px">
    </div>
    <div class="footer">
        <div class="footer-content">
            <h3>Công ty Beekeeper</h3>
            <p>Địa chỉ: 123 Đường ABC, Quận XYZ, Thành phố Hồ Chí Minh</p>
            <p>Điện thoại: (0123) 456-7890 | Email: info@beekeeper.com</p>
            <p>Bản quyền &copy; 2024 Công ty Beekeeper. Đã đăng ký bản quyền.</p>
        </div>
    </div>
</body>
</html>