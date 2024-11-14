<?php
session_start();

$isOrderPlaced = isset($_SESSION['isOrderPlaced']) ? $_SESSION['isOrderPlaced'] : false;

// Xử lý đơn hàng khi người dùng nhấn nút "Tiến hành thanh toán"
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['placeOrder'])) {
    $_SESSION['order_address'] = $_POST['address'];
    $_SESSION['order_note'] = $_POST['note'];
    $_SESSION['order_store_id'] = $_POST['store_id'];
    $_SESSION['payment_method'] = $_POST['paymentMethod'];
    $_SESSION['isOrderPlaced'] = true;
    $isOrderPlaced = true;

    // Thông báo và chuyển hướng tùy thuộc vào phương thức thanh toán
    if ($_SESSION['payment_method'] === "cash") {
        echo "<script>alert('Đặt hàng thành công! Bạn sẽ thanh toán bằng tiền mặt.');</script>";
        echo "<script>setTimeout(function(){ window.location.href = 'donhang.php'; }, 1000);</script>";
    } elseif ($_SESSION['payment_method'] === "transfer") {
        header("Location: thanhtoan.php");
        exit();
    }

    // Reset lại session để người dùng có thể đặt hàng lại
    session_unset();
    session_destroy();
    exit();
}

include_once("../../controller/cCuaHang.php");
$p = new cCuaHang();
$stores = $p->getAllStore();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Giỏ hàng</title>
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
        /* Table styling */
        table {
            width: 80%;
            margin-left: 200px;
            border-collapse: collapse;
            margin-top: 20px;
        }
        table,th,td {
            border: 1px solid black;
        }
        th,
        td {
            padding: 8px;
            text-align: center;
            font-size: 14px;
        }
        /* Order button styling */
        .order-btn {
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
        .order-btn:hover {
            background-color: #e63939;
        }
        #form {
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
        #form h4 {
            text-align: center;
            color: #000000;
            font-weight: bold;
            margin-bottom: 20px;
            margin-top: 20px;
        }
        #orderForm {
            padding: 20px;
        }
        .btn-thanhtoan,.btn-thanhtoan1 {
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
        .form-group {
            margin-bottom: 10px;
        }
        .form-group:last-of-type {
            margin-bottom: 15px;
        }
        input[type="text"] {
            width: 100%;
            padding: 5px;
            background-color: #d1d5db;
            border: 1px solid #9ca3af;
            border-radius: 10px;
        }
        label {
            display: block;
            color: #000000;
            margin-bottom: 5px;
        }
        #orderSummary{
            width: 60%;
            margin-left: 200px;
            margin-top: 30px;
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
                <li><a href="#">Giới thiệu</a></li>
                <li><a href="lienhe.php">Liên hệ</a></li>
            </ul>
        </nav>
        <div class="icons">
            <a href="donhang.php"><i class="fas fa-user"></i></a>
            <a href="giohang.php"><i class="fas fa-shopping-cart"></i></a>
        </div>
    </header>
    <h2>Giỏ hàng</h2>
    <?php include_once("../../view/customer/add_to_cart.php"); ?>

    <!-- Nút đặt hàng -->
    <button class="order-btn" onclick="showOrderForm()" style="display: <?= $isOrderPlaced ? 'none' : 'block' ?>;">Đặt Hàng</button>

    <!-- Form nhập thông tin đơn hàng -->
    <div id="form" style="display: <?= $isOrderPlaced ? 'none' : 'none' ?>;">
        <div id="orderForm">
            <h4>NHẬP THÔNG TIN ĐẶT HÀNG</h4>
            <form method="POST" action="">
                <div class="form-group">
                    <label>Chọn cửa hàng:</label>
                    <select name="store_id" required>
                        <option value="">Chọn cửa hàng</option>
                        <?php while ($store = mysqli_fetch_assoc($stores)) : ?>
                            <option value="<?= $store['ID_CuaHang'] ?>"><?= htmlspecialchars($store['TenCuaHang']) ?></option>
                        <?php endwhile; ?>
                    </select>
                </div>
                <div class="form-group">
                    <label>Giao hàng tới địa chỉ:</label>
                    <input type="text" name="address" required>
                </div>
                <div class="form-group">
                    <label>Ghi chú:</label>
                    <input type="text" name="note">
                </div>
                <div class="form-group">
                    <label>Chọn phương thức thanh toán:</label>
                    <input type="radio" name="paymentMethod" value="cash" checked> Tiền mặt khi nhận hàng<br>
                    <input type="radio" name="paymentMethod" value="transfer"> Chuyển khoản<br>
                </div>
                <div class="form-group">
                    <button class="btn-thanhtoan" type="submit" name="placeOrder">Tiến hành thanh toán</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        // Hiển thị form đặt hàng khi nhấn nút "Đặt Hàng"
        function showOrderForm() {
            document.getElementById("form").style.display = "block";
            document.querySelector(".order-btn").style.display = "none";
        }
        // Hiển thị form nhập thông tin đặt hàng nếu giỏ hàng không trống
    function showOrderForm() {
        document.getElementById("form").style.display = "block";
        const orderButton = document.querySelector(".order-btn");
        if (orderButton) {
            orderButton.style.display = "none";
        }
    }
    // Ẩn nút "Đặt Hàng" khi trang tải nếu giỏ hàng trống
    document.addEventListener('DOMContentLoaded', function() {
        const cartItems = document.querySelectorAll('.cart-item');
        const orderButton = document.querySelector('.order-btn');
        
        if (cartItems.length === 0 && orderButton) {
            orderButton.style.display = 'none'; // Ẩn nút "Đặt Hàng" nếu giỏ hàng trống
        }
    });
    </script>
