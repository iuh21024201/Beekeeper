<?php
session_start();
$isOrderPlaced = $_SERVER["REQUEST_METHOD"] == "POST"; // Kiểm tra xem đơn hàng đã được gửi hay chưa

if ($isOrderPlaced && isset($_POST['paymentMethod'])) {
    $paymentMethod = $_POST['paymentMethod'];
    
    // Kiểm tra phương thức thanh toán
    if ($paymentMethod === "cash") {
        echo "<script>alert('Đặt hàng thành công! Bạn sẽ thanh toán bằng tiền mặt.');</script>";
        echo "<script>setTimeout(function(){ window.location.href = 'menu.php'; }, 1000);</script>"; 
    } elseif ($paymentMethod === "transfer") {
        header("Location: thanhtoan.php"); 
        exit();
    }
}
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
    <h2>Giỏ hàng</h2>
    <table>
        <thead>
            <tr>
                <th>STT</th>
                <th>Sản phẩm</th>
                <th>Số lượng</th>
                <th>Đơn giá(VND)</th>
                <th>Tổng tiền(VND)</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
        </tbody>
    </table>
    <button class="order-btn" onclick="showOrderForm()">Đặt Hàng</button>

    <div id="form">
        <div id="orderForm">
            <h4>NHẬP THÔNG TIN ĐẶT HÀNG</h4>
            <form method="POST" action="">
                <div class="form-group">
                    <label>Địa chỉ giao hàng:</label>
                    <input type="text" name="address" required>
                </div>
                <div class="form-group">
                    <label>Ghi chú:</label>
                    <input type="text" name="note">
                </div>
                <div class="form-group">
                    <button class="btn-thanhtoan" type="submit">Tiến hành thanh toán</button>
                </div>
            </form>
        </div>
    </div>

    <?php if ($isOrderPlaced) : ?>
        <div id="orderSummary" style="display: block;">
            <p>Mã khách hàng:<span id="CustomerID"></span></p>
            <p>SĐT:<span id="phone"></span></p>
            <p>Địa chỉ giao hàng: <?php echo htmlspecialchars($_POST['address']); ?></p>
            <p>Ghi chú: <?php echo htmlspecialchars($_POST['note']); ?></p>
            <p>Tổng tiền:<span id="Total"></span></p>
            <div>
                <p>Chọn phương thức thanh toán:</p>
                <form method="POST">
                    <input type="hidden" name="address" value="<?php echo htmlspecialchars($_POST['address']); ?>">
                    <input type="hidden" name="note" value="<?php echo htmlspecialchars($_POST['note']); ?>">
                    <label>
                        <input type="radio" name="paymentMethod" value="cash" checked> Tiền mặt
                    </label>
                    <label>
                        <input type="radio" name="paymentMethod" value="transfer"> Chuyển khoản
                    </label>
                    <button type="submit" class="btn-thanhtoan1">Thanh toán</button>
                </form>
            </div>
        </div>
    <?php endif; ?>

    <script>
        // Hiển thị form nhập thông tin khi nhấn nút Đặt hàng
        function showOrderForm() {
            document.getElementById("form").style.display = "block"; 
            document.querySelector(".order-btn").style.display = "none"; 
        }

        // Kiểm tra nếu có dữ liệu POST thì hiển thị tóm tắt đơn hàng và ẩn form nhập thông tin
        <?php if ($isOrderPlaced) : ?>
            document.getElementById("form").style.display = "none"; 
            document.querySelector(".order-btn").style.display = "none";
            document.getElementById("orderSummary").style.display = "block"; 
        <?php endif; ?>
    </script>
</body>

</html>
