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
        .text-justify {
            text-align: justify;
            font-size: 17px;    /* cỡ chữ 14px */
            line-height: 2.0;
        }
    </style>
</head>

<body>
<div id="main">
<header>
        <a href=""class="logo">BEEKEEPER</a>
        <nav>
            <ul>
                <li><a href="index.php">Trang chủ</a></li>
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
    <div id="nav" class="container">
    <b><h2>Giới thiệu về Beekeeper</h2></b>
    <table class="table table-borderless">
      <tr>
        <td class="text-justify"><b>Beekeeper</b> là chuỗi nhà hàng thức ăn nhanh trực thuộc tập đoàn Beehive – một trong những tập đoàn dẫn đầu trong lĩnh vực thực phẩm và dịch vụ ăn uống quốc tế. Được công nhận là thương hiệu xuất sắc qua nhiều năm và đạt nhiều giải thưởng về chất lượng dịch vụ, Beekeeper đã khẳng định vị thế của mình trong ngành công nghiệp ăn uống toàn cầu.

<br>Beekeeper không ngừng nỗ lực cung cấp cho khách hàng các dịch vụ tận tâm, chu đáo, đồng thời tập trung phát triển thực đơn dinh dưỡng, phù hợp với xu hướng ăn uống lành mạnh. Để đảm bảo tiêu chuẩn vệ sinh và an toàn thực phẩm, Beekeeper tự hào sở hữu các chứng nhận quốc tế uy tín như:
<br>&ensp; - An toàn thực phẩm (RVA HACCP)
<br>&ensp; - Vệ sinh môi trường (ISO 14001)
<br>&ensp; - Chất lượng sản phẩm (ISO 9001)
<br>Có mặt tại Việt Nam từ năm 2005, Beekeeper đã nhanh chóng phát triển và xây dựng vị thế hàng đầu trong ngành ẩm thực với hơn 200 nhà hàng trên toàn quốc. Đây là minh chứng cho sự cam kết không ngừng về chất lượng và dịch vụ, góp phần tạo dựng niềm tin của khách hàng với thương hiệu Beekeeper.
</td>
      </tr>
      <tr>
        <td>
        <img style="width: 100%" src="image/cuahang.png" alt="cuahang" class="cuahang">
        </td>

      </tr>
  </table>

    </div>
    <div class="footer">
        <div class="footer-content">
            <h3>Công ty Beekeeper</h3>
            <p>Địa chỉ: 123 Đường ABC, Quận XYZ, Thành phố Hồ Chí Minh</p>
            <p>Điện thoại: (0123) 456-7890 | Email: info@beekeeper.com</p>
            <p>Bản quyền &copy; 2024 Công ty Beekeeper. Đã đăng ký bản quyền.</p>
        </div>
    </div>
</div>
</body>

</html>
