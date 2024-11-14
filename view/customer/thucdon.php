<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thực đơn</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="../../asset/css/bootstrap.min.css">
    <script src="../../asset/js/jquery-3.4.1.min.js"></script>
    <script src="../../asset/js/bootstrap.min.js"></script>
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
        .main{
            display: flex;
        }
        .menu-container {
            margin-left: 20px;
        }
        .menu-item {
            border: 1px solid #ddd;
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
    </style>
</head>
<body>
    <header>
        <div class="logo">BEEKEEPER</div>
        <nav>
            <ul>
                <li><a href="trangchu.php">Trang chủ</a></li>
                <li><a href="thucdon.php">Thực đơn</a></li>
                <li><a href="gioithieu.php">Giới thiệu</a></li>
                <li><a href="lienhe.php">Liên hệ</a></li>
            </ul>
        </nav>
        <div class="icons">
            <a href="donhang.php"><i class="fas fa-user"></i></a>
            <a href="giohang.php"><i class="fas fa-shopping-cart"></i></a>
        </div>
    </header>
    <h2>Thực đơn</h2>
    <div class="main">
        <div class="sidebar">
            <h3 style="color: #ff4d4d;">Danh mục</h3>
            <?php
                include_once("../../view/customer/vListLoaiMonAn.php");
            ?>
        </div>
        <div class="main-content"> 
            <form method="get" action="#" style="margin-left: 500px;">
                <input type="text" name="txtname" placeholder="Tìm kiếm ở đây"/>
                <input type="submit" name="btnTimKiem" value="Tìm" />
            </form>
            <div class="menu-container">
                <?php
                    include_once("../../view/customer/vListSanPham.php");
                ?>
            </div>
    </div>
    
    
</body>
</html>
