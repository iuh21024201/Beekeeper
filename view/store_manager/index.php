<?php
session_start();
ob_start();
if(!isset($_SESSION["dn"]) || $_SESSION["dn"] != 2){
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
    <title>Document</title>
</head>
<body>
    
</body>
</html>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Quản lý chuỗi</title>
  <link rel="stylesheet" href="../../asset/css/bootstrap.min.css">
  <script src="../../asset/js/jquery-3.4.1.min.js"></script>
  <script src="../../asset/js/bootstrap.min.js"></script>
  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">

  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>

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
        <?php
          echo $idTaiKhoan;
        ?>
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
            <a href="?action=quan-ly-nhan-vien" class="nav-link <?php echo (isset($_REQUEST['action']) && $_REQUEST['action'] === 'quan-ly-nhan-vien') ? 'active' : ''; ?>" id="employeeManagementLink">Quản lý nhân viên</a>
          </li>
          <li class="nav-item">
            <a href="?action=quan-ly-nguyen-lieu" class="nav-link <?php echo (isset($_REQUEST['action']) && $_REQUEST['action'] === 'quan-ly-nguyen-lieu') ? 'active' : ''; ?>" id="ingredientManagementLink">Quản lý nguyên liệu</a>
          </li>
          <li class="nav-item">
            <a href="?action=quan-ly-dat-tiec" class="nav-link <?php echo (isset($_REQUEST['action']) && $_REQUEST['action'] === 'quan-ly-dat-tiec') ? 'active' : ''; ?>" id="ingredientManagementLink">Quản lý đặt tiệc</a>
          </li>
          <li class="nav-item">
            <a href="?action=thong-ke-doanh-thu" class="nav-link <?php echo (isset($_REQUEST['action']) && $_REQUEST['action'] === 'thong-ke-doanh-thu') ? 'active' : ''; ?>" id="revenueStatisticsLink">Thống kê doanh thu</a>
          </li>
          <li class="nav-item">
            <a href="?action=thong-ke-don-hang" class="nav-link <?php echo (isset($_REQUEST['action']) && $_REQUEST['action'] === 'thong-ke-don-hang') ? 'active' : ''; ?>" id="orderStatisticsLink">Thống kê đơn hàng</a>
          </li>
          <li class="nav-item">
            <a href="?action=thong-ke-don-tiec" class="nav-link <?php echo (isset($_REQUEST['action']) && $_REQUEST['action'] === 'thong-ke-don-tiec') ? 'active' : ''; ?>" id="orderStatisticsLink">Thống kê đơn tiệc</a>
          </li>
          <li class="nav-item">
            <a href="?action=xem-so-luong-ban" class="nav-link <?php echo (isset($_REQUEST['action']) && $_REQUEST['action'] === 'xem-so-luong-ban') ? 'active' : ''; ?>" id="tableCountLink">Xem số lượng bàn</a>
          </li>
          <li class="nav-item">
            <a href="?action=cham-cong" class="nav-link <?php echo (isset($_REQUEST['action']) && $_REQUEST['action'] === 'cham-cong') ? 'active' : ''; ?>" id="tableCountLink">Chấm công</a>
          </li>
          <li class="nav-item">
            <a href="?action=xep-lich" class="nav-link <?php echo (isset($_REQUEST['action']) && $_REQUEST['action'] === 'xep-lich') ? 'active' : ''; ?>" id="tableCountLink">Xếp lịch làm việc</a>
          </li>

          <li class="nav-item">
            <a href="?action=quan-ly-thuc-don" class="nav-link <?php echo (isset($_REQUEST['action']) && $_REQUEST['action'] === 'quan-ly-thuc-don') ? 'active' : ''; ?>" id="tableCountLink">Quản lý thực đơn</a>
          </li>
          <li class="nav-item">
            <a href="?action=gui-yeu-cau-trao-doi-nguyen-lieu" class="nav-link <?php echo (isset($_REQUEST['action']) && $_REQUEST['action'] === 'gui-yeu-cau-trao-doi-nguyen-lieu') ? 'active' : ''; ?>" id="tableCountLink">Gửi yêu trao đổi nguyên liệu</a>
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
                  case 'quan-ly-dat-tiec':
                      include_once("quan-ly-dat-tiec.php");
                      break;              
                  case 'quan-ly-nhan-vien':
                      include_once("quan-ly-nhan-vien.php");
                      break;
                  case 'quan-ly-nguyen-lieu':
                      include_once("quan-ly-nguyen-lieu.php");
                      break;
                  case 'thong-ke-doanh-thu':
                      include_once("thong-ke-doanh-thu.php");
                      break;
                  case 'thong-ke-don-hang':
                      include_once("thong-ke-don-hang.php");
                      break;
                  case 'thong-ke-don-tiec':
                      include_once("thong-ke-don-tiec.php");
                      break;
                  case 'xem-so-luong-ban':
                      include_once("xem-so-luong-ban.php");
                      break;
                  case 'cham-cong':
                      include_once("cham-cong.php");
                      break;
                  case 'xep-lich':
                      include_once("xep-lich.php");
                      break;
                  case 'gui-yeu-cau-trao-doi-nguyen-lieu':
                      include_once("gui-yeu-cau-trao-doi-nguyen-lieu.php");
                      break;
                  case 'quan-ly-thuc-don':
                      include_once("quan-ly-thuc-don.php");
                      break;
                  case 'trao-doi':
                      include_once("trao-doi.php");
                      break;
                  case 'lay_nguyen_lieu':
                    include_once("lay_nguyen_lieu.php");
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

