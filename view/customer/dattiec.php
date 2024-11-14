<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đặt tiệc</title>
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
        
        .main{
            display: flex;
        }
        .menu-container {
            display: flex;
            flex-wrap: wrap; /* Cho phép các mục xuống hàng nếu không đủ chỗ */
            justify-content: space-between; /* Căn đều các mục */
        }

        .menu-category {
            flex: 0 0 calc(25% - 20px); /* Căn chỉnh chiều rộng cho 4 mục mỗi hàng */
            margin: 10px; /* Giảm khoảng cách bên ngoài cho mỗi mục */
        }
        .menu-item {
            border: 1px solid #ddd;
            margin-bottom: 20px;
            padding: 10px;
            text-align: center;
        }
        .menu-item img {
            width: 100px;
            height: 100px;
        }
        .menu-item p {
            margin: 10px 0;
        }
        .menu-item .price {
            color: red;
            font-weight: bold;
        }
        .sidebar {
            margin-left: 180px;
            width: 200px;
            padding: 20px;
            background-color: #f8f8f8;
        }
        .menu-item {
            border: 1px solid #ddd;
            margin-bottom: 20px;
            padding: 10px;
            text-align: center;
        }
        .menu-item img {
            width: 100px;
            height: 100px;
        }
        .menu-item p {
            margin: 10px 0;
        }
        .menu-item .price {
            color: red;
            font-weight: bold;
        }
        .quantity-box {
            display: flex;
            justify-content: center;
            align-items: center;
            margin: 10px 0;
        }
        .quantity-box input[type="number"] {
            width: 50px;
            text-align: center;
            appearance: textfield; 
            -moz-appearance: textfield; 
        }

        .quantity-box input[type="number"]::-webkit-outer-spin-button,
        .quantity-box input[type="number"]::-webkit-inner-spin-button {
            appearance: none; 
            margin: 0;
        }
        .quantity-box button {
            width: 30px;
            height: 30px;
            background-color: #f0f0f0;
            border: 1px solid #ddd;
            cursor: pointer;
        }
        .title h4{
            padding-left: 20px;
            padding-right: 20px;
            font-weight: 700;
            color:#ff4d4d;
            margin: 0 0 10px;
        }
        .title p{
            font-weight: 400;
            color: #000;
        }
        .title h3{
            color:#ff4d4d;
            font-weight: 700;
            margin: 0 0 10px;
        }
        .btn{
            background-color: #00b2a9;
            border: none;
            color: #fff;
            padding: 12px 0;
            width: 200px;
            border-radius: 48px;
            margin: 0 auto;
            display: block;
            font-weight: 700;
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
        #form{
            background-color: #ffde94;
            padding-bottom:100px;
            padding-top:20px;
            margin-top:100px;
        }
        .form-wrapper h5{
            font-weight: bold;
            text-align: center;
            margin-top: 30px;
        }
        .form-control {
            border: 1px solid #ffc522;
            background-color: #FFC522;
            height: 46px;
            border-radius: 8px;
        }
        input::placeholder {
            color: red;
        }
        .total{
            display: flex;
            width: 100%;
            background-color: #fff;
            padding: 25px 10px 30px;
            border-radius: 10px;
        }
        span{
            font-size: 21px;
            line-height: 32px;
            font-weight: bold;
            color: #333;
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
                <li><a href="dattiec.php">Đặt tiệc</a></li>
                <li><a href="lienhe.php">Liên hệ</a></li>
            </ul>
        </nav>
        <div class="icons">
            <a href="donhang.php"><i class="fas fa-user"></i></a>
            <a href="giohang.php"><i class="fas fa-shopping-cart"></i></a>
        </div>
    </header>
    <div class="container">
        <div class="title" style="text-align: center;">
            <h4>Buổi tiệc khó quên cùng những món ngon</h4>
                <h4>& quà tặng từ BeeKeeper</h4>
            <p>Chúng tôi sẵn sàng phục vụ mọi buổi tiệc của bạn</p>
            <h3>Thực đơn</h3>
        </div>
        <div class="menu-container">
                <div class="menu-category" id="">
                        <div class="menu-item">
                            <img src="" alt="">
                            <p>Tên</p>
                            <p class="price"> đ</p>
                            <div class="quantity-box">
                                <button type="button" onclick="updateQuantity(this, -1)">-</button>
                                <input type="number" name="quantity" value="1" min="1" max="10">
                                <button type="button" onclick="updateQuantity(this, 1)">+</button>
                            </div>
                        </div>
                </div>
                <div class="menu-category" id="">
                        <div class="menu-item">
                            <img src="" alt="">
                            <p>Tên</p>
                            <p class="price"> đ</p>
                            <div class="quantity-box">
                                <button type="button" onclick="updateQuantity(this, -1)">-</button>
                                <input type="number" name="quantity" value="1" min="1" max="10">
                                <button type="button" onclick="updateQuantity(this, 1)">+</button>
                            </div>
                        </div>
                </div>
                <div class="menu-category" id="">
                        <div class="menu-item">
                            <img src="" alt="">
                            <p>Tên</p>
                            <p class="price"> đ</p>
                            <div class="quantity-box">
                                <button type="button" onclick="updateQuantity(this, -1)">-</button>
                                <input type="number" name="quantity" value="1" min="1" max="10">
                                <button type="button" onclick="updateQuantity(this, 1)">+</button>
                            </div>
                        </div>
                </div>
                <div class="menu-category" id="">
                        <div class="menu-item">
                            <img src="" alt="">
                            <p>Tên</p>
                            <p class="price"> đ</p>
                            <div class="quantity-box">
                                <button type="button" onclick="updateQuantity(this, -1)">-</button>
                                <input type="number" name="quantity" value="1" min="1" max="10">
                                <button type="button" onclick="updateQuantity(this, 1)">+</button>
                            </div>
                        </div>
                </div>
                <button class="btn">Đặt ngay</button>
        </div>
            
    
    </div>
    <div id="form">
        <div class="container">
        <div class="row">
            <div class="form-wrapper col-md-6">
                <h5>THÔNG TIN KHÁCH HÀNG ĐẶT TIỆC</h5>
                <div class="form-group">
                    <input type="text" class="form-control" name="name" placeholder="Tên*" >
                </div>
                <div class="form-group">
                    <input type="text" class="form-control" name="" placeholder="Số điện thoại*">
                </div>
                <div class="form-group">
                    <input type="datetime" name="" id="" class="form-control" placeholder="Giờ hẹn*">
                </div>
                <div class="form-group">
                    <input type="text" class="form-control" name="" placeholder="Số người*">
                </div>
                <div class="form-group">
                <select class="form-control" id="" placeholder="Trang trí">
                        <option value="">Cửa hàng</option>
                        <option value="">Cửa hàng</option>
                        <option value="">Cửa hàng</option>
                    </select>
                </div>
                <div class="form-group">
                    <select class="form-control" id="" placeholder="Trang trí">
                        <option value="">Trang trí</option>
                        <option value="">Trang trí</option>
                        <option value="">Trang trí</option>
                    </select>
                </div>
                <div class="form-group">
                    <textarea class="form-control" name="" id="" placeholder="Ghi chú"></textarea>
                </div>
            </div>
            <div class="form-wrapper col-md-6">
                <h5>CHI TIẾT ĐƠN HÀNG</h5>
                <div class="total">
                    <div class="name">
                        <span>Tổng cộng:</span>
                    </div>
                    <div class="value">
                        <span> 0 đ</span>
                    </div>
                </div>
            </div>
            
        </div>
        <button class="btn" style="margin-top:20px;">XÁC NHẬN ĐẶT TIỆC</button>
        </div>
        
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
<!-- <script>
    function showOrderForm() {
            document.getElementById("form").style.display = "block"; 
            document.querySelector(".btn").style.display = "none"; 
        }
</script> -->