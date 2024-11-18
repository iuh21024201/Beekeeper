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
            background-color: #f5f5f5;
            display: flex;
            justify-content: center;
            margin: 0;
        }

        header {
            width: 100%;
            max-width: 1200px;
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

        .horizontal-sidebar {
            display: flex;
            gap: 20px;
            margin: 20px 0;
            justify-content: center;
        }

        .horizontal-sidebar a {
            background-color: #ff5e5e;
            color: white;
            padding: 15px 30px;
            border-radius: 8px;
            text-align: center;
            text-decoration: none;
            font-weight: bold;
            font-size: 16px;
        }

        .horizontal-sidebar a:hover {
            background-color: #ff4444;
        }

        .container {
            display: flex;
            gap: 20px;
            max-width: 1200px;
            width: 100%;
            margin-top: 20px;
        }

        .menu-container {
            flex: 1;
            display: flex;
            gap: 15px;
            flex-wrap: wrap;
            justify-content: center;
        }

        .menu-item {
            background-color: #fff;
            border-radius: 8px;
            text-align: center;
            padding: 10px;
            width: 120px;
        }

        .menu-item img {
            width: 100%;
            height: auto;
            border-radius: 8px;
        }

        .menu-item p {
            margin: 8px 0;
            font-weight: bold;
            color: #333;
        }

        .order-section {
            flex: 0.4;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
        }

        .order-section h3 {
            text-align: center;
            margin-bottom: 20px;
            color: #333;
        }

        .order-table {
            width: 100%;
            margin-bottom: 15px;
            border-collapse: collapse;
            border: 1px solid #ddd;
        }

        .order-table th, .order-table td {
            padding: 10px;
            text-align: center;
            border: 1px solid #ddd;
        }

        .summary {
            display: flex;
            flex-direction: column;
            gap: 10px;
            align-items: center;
        }

        .summary textarea {
            width: 100%;
            height: 50px;
            padding: 8px;
            border: 1px solid #ddd;
            border-radius: 4px;
            resize: none;
        }

        .summary p {
            font-weight: bold;
            color: #333;
        }

        .summary button {
            padding: 10px 20px;
            border: none;
            color: white;
            font-weight: bold;
            border-radius: 4px;
            cursor: pointer;
        }

        .summary button:first-of-type {
            background-color: red;
        }

        .summary button:last-of-type {
            background-color: green;
        }

        .summary button:hover {
            opacity: 0.9;
        }

        .delete {
            color: red;
            cursor: pointer;
        }

        @media (max-width: 768px) {
            .container {
                flex-direction: column;
                align-items: center;
            }

            .order-section {
                max-width: 100%;
            }
        }
    </style>
</head>
<body>

<div id="container">
    <header>
        <div class="logo">
                <?php
                    echo $idTaiKhoan;
                ?>
            BEEKEEPER
        </div>
        <nav>
            <ul>
                <li><a href="#">Trang bán hàng</a></li>
                <li><a href="trang-quan-tri.php">Trang quản trị</a></li>
            </ul>
        </nav>
        <div class="icons">
            <a href="#"><i class="fas fa-user"></i></a>
        </div>
    </header>

    <div class="horizontal-sidebar">
        <a href="#">Cơm</a>
        <a href="#">Gà rán</a>
        <a href="#">Mì ý</a>
    </div>

    <div class="container">
        <!-- Left side: Menu items --> 
        <div class="menu-container">
            <div class="menu-item">
                <img src="example.jpg" alt="Cơm">
                <p>Cơm Teriyaki</p>
                <p class="price">50.000 đ</p>
            </div>
            <div class="menu-item">
                <img src="example.jpg" alt="Gà rán">
                <p>Gà rán</p>
                <p class="price">50.000 đ</p>
            </div>
            <div class="menu-item">
                <img src="example.jpg" alt="Mì ý">
                <p>Mì ý</p>
                <p class="price">50.000 đ</p>
            </div>
        </div>

        <!-- Right side: Order section -->
        <div class="order-section">
            <h3>Đơn hàng</h3>
            <table class="order-table" id="order-table">
                <thead>
                    <tr>
                        <th>STT</th>
                        <th>Món</th>
                        <th>Số lượng</th>
                        <th>Giá bán</th>
                        <th>Thành tiền</th>
                        <th>Xóa</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
            <div class="summary">
                <textarea placeholder="Nhập ghi chú"></textarea>
                <p>Tổng đơn: <span id="total">0</span> đ</p>
                <button onclick="clearOrder()">Xóa</button>
                <button>Thanh Toán</button>
            </div>
        </div>
    </div>
</div>

</body>
</html>
