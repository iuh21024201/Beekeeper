<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title></title>
</head>
<style>
    * {
    margin: 0 auto;
    box-sizing: border-box;
    font-family: Arial, sans-serif;
}

body {
    background-color: #f0f2f5;
}

#container {
    background-image: url("asset/image/backgr_login.jpg");
    background-size: cover;
    background-position: center;
    width: 100%;
    height: 100vh; /* Full viewport height */
    display: flex;
    justify-content: center;
    align-items: center;
    margin: 0;
    position: relative;
}

#login {
    position: absolute;
    top: 20px;
    right: 20px;
    font-size: 18px;
}

#login a {
    color: #fff;
    text-decoration: none;
    margin-right: 10px;
    padding: 8px 15px;
    background-color: #007bff;
    border-radius: 5px;
    transition: background-color 0.3s ease;
}

#login a:hover {
    background-color: #0056b3;
}

/* Làm cho form lớn hơn */
#main {
    background-color: rgba(255, 255, 255, 0.9);
    border-radius: 10px;
    padding: 40px; /* Tăng padding để làm form lớn hơn */
    box-shadow: 0 6px 12px rgba(0, 0, 0, 0.2); /* Tăng hiệu ứng đổ bóng */
    width: 500px; /* Tăng chiều rộng của form */
    text-align: center;
}

/* Chỉnh sửa input của form */
form input[type="text"],
form input[type="password"] {
    width: 100%;
    padding: 15px; /* Tăng padding để làm input lớn hơn */
    border: 1px solid #ccc;
    border-radius: 5px;
    font-size: 18px; /* Tăng kích thước chữ */
}

/* Chỉnh sửa nút submit */
form input[type="submit"] {
    background-color: #28a745;
    color: #fff;
    border: none;
    padding: 15px; /* Tăng padding để làm nút lớn hơn */
    border-radius: 5px;
    cursor: pointer;
    font-size: 20px; /* Tăng kích thước chữ */
    transition: background-color 0.3s ease;
}

/* Khoảng cách giữa các thành phần trong form */
form {
    display: flex;
    flex-direction: column;
    gap: 20px; /* Tăng khoảng cách giữa các phần tử */
}
.logo {
    font-family: 'Knewave', cursive;
    font-size: 28px;
    font-weight: bold;
    color: #ff4d4d;
    text-transform: uppercase;
    font-style: italic;
    position: absolute;
    top: 20px;
    left: 40px;
    background: white;  
        }

</style>

<body>
<div id="container">
  <div class="logo">BEEKEEPER</div>
  <div id="login">
  
    <?php
      if(isset($_SESSION["dn"])){
        echo '<a href="View/account/logout.php" onclick="return confirm(\'Are you sure to logout?\');">Đăng xuất   </a>';
      }else{
        echo '<a href="?dangnhap">Đăng nhập</a>';
        echo '<a href="?dangky">Đăng ký</a>';
      }
    ?>  
  </div>
    <div id="main">

      <?php
        if(isset($_GET["dangnhap"])){
          include_once("View/account/login.php");
        }else if(isset($_GET["dangky"])){
          include_once("View/account/register.php");
        }else {
        include_once("View/account/login.php");
        }
      ?>
    </div>
  </div> 
  
</body>
</html>