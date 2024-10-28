<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đơn hàng của tôi</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="../../asset/css/bootstrap.min.css">
    <script src="../../asset/js/jquery-3.4.1.min.js"></script>
    <script src="../../asset/js/bootstrap.min.js"></script>
    <style>
        body {
            font-family: Arial, sans-serif;
            width: 90%;
        }
        /* Flexbox layout for header */
        header {
            width: 90%;
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
    </style>
</head>

<body>
    <header>
        <div class="logo">BEEKEEPER</div>
        <nav>
            <ul>
                <li><a href="#">Trang chủ</a></li>
                <li><a href="thucdon.php">Thực đơn</a></li>
                <li><a href="#">Giới thiệu</a></li>
                <li><a href="#">Liên hệ</a></li>
            </ul>
        </nav>
        <div class="icons">
            <a href="donhang.php"><i class="fas fa-user"></i></a>
            <a href="giohang.php"><i class="fas fa-shopping-cart"></i></a>
        </div>
    </header>
    <h2>Đơn hàng của tôi</h2>
    
    
</body>

</html>
