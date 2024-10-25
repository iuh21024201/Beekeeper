<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../asset/css/bootstrap.min.css">
    <script src="../../asset/js/jquery-3.4.1.min.js"></script>
    <script src="../../asset/js/bootstrap.min.js"></script>
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

#main {
    background-color: rgba(255, 255, 255, 0.8);
    border-radius: 10px;
    padding: 30px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    width: 400px;
    text-align: center;
}

form {
    display: flex;
    flex-direction: column;
    gap: 15px;
}

form input[type="text"],
form input[type="password"] {
    width: 100%;
    padding: 10px;
    border: 1px solid #ccc;
    border-radius: 5px;
    font-size: 16px;
}

form input[type="submit"] {
    background-color: #28a745;
    color: #fff;
    border: none;
    padding: 10px;
    border-radius: 5px;
    cursor: pointer;
    font-size: 18px;
    transition: background-color 0.3s ease;
}

form input[type="submit"]:hover {
    background-color: #218838;
}

form a {
    color: #007bff;
    text-decoration: none;
}

form a:hover {
    text-decoration: underline;
}

</style>

<body>
<div id="container">
  <div id="login">
    <?php
      if(isset($_SESSION["dn"])){
        echo '<a href="View/dangxuat.php" onclick="return confirm(\'Are you sure to logout?\');">Đăng xuất   </a>';
      }else{
        echo '<a href="?dangnhap">Đăng nhập</a>';
        echo '<a href="?dangky">Đăng ký</a>';
      }
    ?>  
  </div>
    <div id="main">
      <?php
        if(isset($_GET["dangnhap"])){
          include_once("View/login/index.php");
        }else if(isset($_GET["dangky"])){
          include_once("View/register/index.php");
        }
      ?>
    </div>
  </div> 
  
</body>
</html>