<?php
error_reporting(0);  
session_start();

if (!isset($_SESSION["dn"]) || $_SESSION["dn"] != 4 || !isset($_SESSION["ID_TaiKhoan"]) || intval($_SESSION["ID_TaiKhoan"]) <= 0) {
    echo "<script>alert('Bạn không có quyền truy cập hoặc chưa đăng nhập!')</script>";
ob_start();
if(!isset($_SESSION["dn"]) || $_SESSION["dn"] != 4){
    echo"<script>alert('Bạn không có quyền truy cập')</script>";
    header("refresh:0;url='../../index.php'");
    exit(); // Đảm bảo ngừng mọi xử lý sau khi chuyển hướng
}
}
$idTaiKhoan = intval($_SESSION["ID_TaiKhoan"]);
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Nhân Viên</title>
  <link rel="stylesheet" href="../../asset/css/bootstrap.min.css">
  <script src="../../asset/js/jquery-3.4.1.min.js"></script>
  <script src="../../asset/js/bootstrap.min.js"></script>
  <style>
    .sidebar {
      background-color: #f8f9fa;
      padding: 20px;
      min-height: calc(100vh - 56px);
      border-right: 1px solid #dee2e6;
    }
    .sidebar .nav-link {
      color: #333;
      font-weight: bold;
      margin-bottom: 10px;
      display: flex;
      align-items: center;
      padding: 10px 15px;
      transition: background-color 0.3s ease, color 0.3s ease;
      border-radius: 5px;
    }

    .sidebar .nav-link i {
      margin-right: 10px;
    }
    .sidebar .nav-link.active {
      background-color: #6c757d;
      color: white;
      box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2); 
    }

    .sidebar .nav-link:hover {
      background-color: #e9ecef;
      text-decoration: none;
    }
    .content {
      padding: 20px;
    }
    h3,
    h2 {
      color: #333;
    }

    /* Style for iframe */
    #contentFrame {
      width: 100%;
      height: calc(100vh - 56px - 40px);
      border: none;
    }

    .hidden {
      display: none;
    }

    .navbar {
      height: 70px; 
      display: flex;
      align-items: center; 
    }
    .logout-btn {
      background-color: #dc3545;
      color: white;
      padding: 8px 12px;
      border-radius: 4px;
      border: none;
      text-decoration: none;
      transition: background-color 0.3s ease;
    }

    .logout-btn:hover {
      background-color: #c82333;
    }
    .navbar h2 {
    font-family: 'Knewave', cursive; 
    font-size: 2rem; 
    color: #dc3545; 
    margin: 0; 
    text-transform: uppercase; 
    font-style: italic; 
    font-weight: bold;
    }
    .sidebar .dropdown-menu {
    background-color: #f8f9fa;
    padding: 10px 0; 
    border: 1px solid #dee2e6;
    border-radius: 5px;
    width: 100%; 
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); 
    position: relative; 
    }

    .sidebar .dropdown-item {
      color: #333;
      padding: 10px 15px; 
      border-radius: 3px;
      transition: background-color 0.3s ease, color 0.3s ease;
      width: 100%; 
      display: block; 
    }

    .sidebar .dropdown-item:hover {
      background-color: #e9ecef;
    }

    .sidebar .dropdown-toggle::after {
      margin-left: 10px;
    }

    .sidebar .dropdown-item.active, 
    .sidebar .dropdown-item:active {
      background-color: #6c757d;
      color: white;
    }

    .nav-item .dropdown-menu {
      display: none;
      position: relative;
      width: 100%; 
    }

    .nav-item.dropdown:hover .dropdown-menu {
      display: block;
      width: 100%; 
    }
  </style>
  
</head>

<body>  
  <!-- Navbar -->
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid">
      <span><h2>
        BEEKEEPER
      </h2></span>
      <div class="ml-auto">
        <a href="../Account/logout.php" class="btn logout-btn" id="logoutBtn">Đăng xuất</a>
      </div>
    </div>
  </nav>
  <div class="container-fluid">
    <div class="row">
      <div class="col-12 col-md-3 sidebar">
        <ul class="nav flex-column">
          <li class="nav-item">
            <a href="?action=index" class="nav-link <?php echo (isset($_REQUEST['action']) && $_REQUEST['action'] === 'index') ? 'active' : ''; ?>" id="homeLink">Trang chủ</a>
          </li>
          <li class="nav-item">
            <a href="?action=xem-don-hang" class="nav-link <?php echo (isset($_REQUEST['action']) && $_REQUEST['action'] === 'xem-don-hang') ? 'active' : ''; ?>" id="xem-don-hang">Xem Đơn Hàng</a>
          </li>
          <li class="nav-item">
            <a href="?action=xem-luong" class="nav-link <?php echo (isset($_REQUEST['action']) && $_REQUEST['action'] === 'xem-luong') ? 'active' : ''; ?>" id="xem-luong">Xem lương</a>
          </li> 
          <li class="nav-item">
            <a href="?action=dang-ky-ca" class="nav-link <?php echo (isset($_REQUEST['action']) && $_REQUEST['action'] === 'dang-ky-ca') ? 'active' : ''; ?>" id="newDishProposalLink">Đăng ký ca</a>
          </li>
          <li class="nav-item">
            <a href="?action=lich-lam-viec" class="nav-link <?php echo (isset($_REQUEST['action']) && $_REQUEST['action'] === 'lich-lam-viec') ? 'active' : ''; ?>" id="ingredientRequestLink">Xem lịch làm việc</a>
          </li>
          <li class="nav-item">
            <a href="?action=de-xuat-mon-moi" class="nav-link <?php echo (isset($_REQUEST['action']) && $_REQUEST['action'] === 'de-xuat-mon-moi') ? 'active' : ''; ?>" id="ingredientRequestLink">Đề xuất món mới</a>
          </li>
        </ul>
      </div>
      <div class="col-12 col-md-9 content">
        <div class="content" id="content">
          <?php
          // Hiển thị nội dung dựa trên tham số action trong URL
          if (isset($_REQUEST["action"])) {
              $val = $_REQUEST["action"];
              switch ($val) {
                  case 'xem-don-hang':
                    include_once("xem-don-hang.php");
                    break;
                  case 'de-xuat-mon-moi':
                      include_once("de-xuat-mon-moi.php");
                      break;
                  case 'dang-ky-ca':
                      include_once("dang-ky-ca.php");
                      break;
                  case 'xem-luong':
                      include_once("xem-luong.php");
                      break;
                  case 'lich-lam-viec':
                      include_once("lich-lam-viec.php");
                      break;
                  case 'next_week':
                      include_once("lich-lam-viec.php");
                      break;
                  case 'current_week':
                      include_once("lich-lam-viec.php");
                      break;
                  case 'index':
                  default:
                      echo "<h2>Chào mừng quay trở lại</h2>"; 
              }
          } else {
              echo "<h2>Chào mừng quay trở lại</h2>"; 
          }
          ?>
        </div>
      </div>
    </div>
  </div>
</body>

</html>
        