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
    <h2>Thực đơn</h2>
    <div class="main">
        <div class="sidebar">
            <h3>Danh mục</h3>
            <ul>
                <li><a href="#">Mỳ</a></li>
                <li><a href="#">Gà rán</a></li>
            </ul>
        </div>
        <div class="main-content">
            <form action="search.php" method="GET" style="margin-left: 400px;">
                <input type="text" name="query" placeholder="Tìm kiếm">
                <button type="submit">Tìm kiếm</button>
            </form>
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
                            <p>SLT:</p>
                            <button>Thêm vào giỏ hàng</button>
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
                            <p>SLT:</p>
                            <button>Thêm vào giỏ hàng</button>
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
                            <p>SLT:</p>
                            <button>Thêm vào giỏ hàng</button>
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
                            <p>SLT:</p>
                            <button>Thêm vào giỏ hàng</button>
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
                            <p>SLT:</p>
                            <button>Thêm vào giỏ hàng</button>
                        </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        function updateQuantity(button, change) {
            var input = button.parentElement.querySelector('input[name="quantity"]');
            var newValue = parseInt(input.value) + change;
            var min = parseInt(input.min); 
            var max = parseInt(input.max); 
            if (newValue >= min && newValue <= max) {
                input.value = newValue;
            }
        }
    </script>
    
</body>
</html>