<?php
session_start();

// Hiển thị thông báo nếu có trong session
if (isset($_SESSION['message'])) {
    echo "<div class='alert alert-success'>" . $_SESSION['message'] . "</div>";
    unset($_SESSION['message']); // Xóa thông báo sau khi hiển thị
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liên hệ</title>
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
        #search{
            float: right;
            margin-right: 30px;
        }
        /* footer */
        .footer {
            background-image: url('image/footer.png'); 
            background-size: cover; 
            background-position: center;
            color: #fff; 
            /* padding: 40px 0;  */
            /* text-align: center; */
            width: 100%;
            height: 555px;
        }
        .logo_img{
            height: 150px;
            float: left;
        }
        .footer td{
            text-align: left;
        }
        .footer{
            padding: 50px 0;
        }
        .text-table{
            width: 30%;
        }
        .text-table a{
            color: #000;
        }
        .footer ul{
            list-style-type: none;
        }
        .footer ul li {
            text-align: left;
            font-size: 22px;
            line-height: 2;
        }

    </style>
</head>

<body>
<div id="main">
<header>
        <div class="logo">BEEKEEPER</div>
        <nav>
            <ul>
                <li><a href="index.php">Trang chủ</a></li>
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
<div id="nav" class="container">
    <h2>Liên hệ</h2>
    <table class="table table-borderless">
        <tr>
            <td>
                <h3>Thông tin liên hệ:</h3>
                    <table class="table">
                        <tr>
                            <td><i class="fa-solid fa-cart-shopping" style="color: #ff0000;"></i></td>
                            <td>Beekeper</td>
                        </tr>
                        <tr>
                            <td><i class="fa-solid fa-phone" style="color: #ff0000;"></i></td>
                            <td>0123456789</td>
                        </tr>
                        <tr>
                            <td><i class="fa-solid fa-location-dot" style="color: #ff0000;"></i></td>
                            <td>12 Nguyễn Văn Bảo, Phường 4, Gò Vấp, Hồ Chí Minh</td>
                        </tr>
                    </table>
                <h3>Gửi tin nhắn cho chúng tôi</h3>
                <!-- Form gửi tin nhắn -->
                <form action="../../model/msubmit.php" method="post">
                    <table class="table table-borderless">
                        <tr>
                            <td>
                                <input type="text" class="form-control" placeholder="Họ tên" name="name" required>
                            </td>
                            <td>
                                <input type="text" class="form-control" placeholder="Số điện thoại" name="numberPhone" required>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2">
                                <input type="email" class="form-control" placeholder="Email" name="email" required>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2">
                                <textarea class="form-control" rows="5" placeholder="Tin nhắn" name="message" required></textarea>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <button type="submit" class="btn btn-danger">Gửi</button>
                            </td>
                        </tr>
                    </table>
                </form>
            </td>
            <td>
                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3918.858169091082!2d106.68427047570354!3d10.822164158347038!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3174deb3ef536f31%3A0x8b7bb8b7c956157b!2zVHLGsOG7nW5nIMSQ4bqhaSBo4buNYyBDw7RuZyBuZ2hp4buHcCBUUC5IQ00!5e0!3m2!1svi!2s!4v1730039053057!5m2!1svi!2s" width="600" height="650" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
            </td>
        </tr>
    </table>
</div>
<div class="footer">        
            <table class="table table-footer table-borderless">
                <tr>
                    <td><a href="http://localhost/Beekeeper/view/customer/trangchu.php"><img src="image/logo_beekeeper.png" alt="" class ="logo_img"></a></td>
                    <td class="text-table">
                        <ul>
                            <li>
                                <b>CÔNG TY TNHH BEEKEEPER VIỆT NAM</b>
                            </li>
                            <li>
                                Địa chỉ: Phòng H4.02, Tòa H, Số 12 Nguyễn Văn Bảo, <br>Phường 4, Quận Gò Vấp, Thành phố Hồ Chí Minh. 
                            </li>
                            <li>Điện thoại: 0384902203</li>
                            <li>Hộp thư góp ý: <a href="http://localhost/Beekeeper/view/customer/lienhe.php">beekeeper.vn</a></li>
                        </ul>
                    </td>
                    <td class="text-table">
                        <ul>
                            <li>
                                <b>CHÍNH SÁCH </b>
                            </li>
                            <li>
                                <a href="http://localhost/Beekeeper/view/customer/lienhe.php">Liên hệ</a>
                            </li>
                            <li>
                                <a href="http://localhost/Beekeeper/view/customer/chinhsachvaquydinhchung.php">Chính sách và quy định chung</a>
                            </li>
                            <li>
                                <a href="http://localhost/Beekeeper/view/customer/chinhsachthanhtoankhidathang.php">Chính sách thanh toán khi đặt hàng</a>
                            </li>
                            <li>
                                <a href="http://localhost/Beekeeper/view/customer/chinhsachhoatdong.php">Chính sách hoạt động</a>
                            </li>
                            <li>
                                <a href="http://localhost/Beekeeper/view/customer/chinhsachbaomatthongtin.php">Chính sách bảo mật thông tin</a>
                            </li>
                            <li>
                                <a href="http://localhost/Beekeeper/view/customer/thongtinvanchuyenvagiaonhan.php">Thông tin vận chuyển và giao nhận</a>
                            </li>
                            <li>
                                <a href="http://localhost/Beekeeper/view/customer/thongtindangkygiaodichchung.php">Thông tin đăng ký giao dịch chung</a>
                            </li>
                            <li>
                                <a href="http://localhost/Beekeeper/view/customer/huongdandatphanan.php">Hướng dẫn đặt phần ăn</a>
                            </li>
                        </ul>
                    </td>
                    <td class="text-table">
                        <ul>
                            <li>
                                <h3><b>Kết nối cùng với nhau nhá!</b></h3>
                            </li>
                            <li>
                                <a href="">
                                    <i class="fa-brands fa-facebook fa-bounce fa-xl" style="color: #ff0000;"></i> Facebook
                                </a>
                            </li>
                            <li>
                                <a href="">
                                    <i class="fa-brands fa-google fa-xl" style="color: #ff0000;"></i> Gmail 
                                </a>
                            </li>
                            <li>
                                <a href="">
                                    <i class="fa-brands fa-instagram fa-xl" style="color: #ff0000;"></i> Instagram
                                </a>
                            </li>
                            <li>
                                <a href="">
                                <i class="fa-brands fa-tiktok fa-xl" style="color: #ff0000;"></i> Tiktok
                                </a>
                            </li>
                            <li>
                                <a href="">
                                    <i class="fa-solid fa-z fa-xl" style="color: #ff0000;"></i> Zalo
                                </a>
                            </li>
                            
                        </ul>
                    </td>
                </tr>
            </table>
</div>
</div>
</body>

</html>
