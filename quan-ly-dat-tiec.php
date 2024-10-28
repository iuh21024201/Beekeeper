<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Quản lý chuỗi</title>
  <link rel="stylesheet" href="../../asset/css/bootstrap.min.css">
  <script src="../../asset/js/jquery-3.4.1.min.js"></script>
  <script src="../../asset/js/bootstrap.min.js"></script>
  <link rel="stylesheet" href="../../asset/css/all.min.css">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
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

    .content {
        padding: 20px;
    }
    
    h2 {
        font-size: 24px;
        margin-bottom: 20px;
    }
    
    .filter {
        display: flex;
        flex-direction: column;
        align-items: left;
        gap: 10px;
        margin-bottom: 20px;
    }
    
    input[type="date"], input[type="text"] {
        padding: 5px;
        border: 1px solid #ccc;
        border-radius: 5px;
    }
    
    button {
        background-color: #f64a4a;
        color: white;
        border: none;
        padding: 5px 10px;
        border-radius: 5px;
        cursor: pointer;
    }
    
    table {
        width: 100%;
        border-collapse: collapse;
    }
    
    table, th, td {
        border: 1px solid #ccc;
    }
    
    th, td {
        padding: 10px;
        text-align: center;
    }
    
    button:hover {
        background-color: #d73838;
    }
    
  </style>

</head>

<body>
  <!-- Navbar -->
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid">
      <span><h2>BEEKEEPER</h2></span>
      <div class="ml-auto">
        <a href="logout.php" class="btn logout-btn" id="logoutBtn">Đăng xuất</a>
      </div>
    </div>
  </nav>
  <div class="container-fluid">
    <div class="row">
      <div class="col-12 col-md-3 sidebar">
        <ul class="nav flex-column">
          <li class="nav-item">
            <a href="./GD_QuanLy.html" class="nav-link <?php echo (isset($_REQUEST['action']) && $_REQUEST['action'] === 'index') ? 'active' : ''; ?>" id="homeLink">Trang chủ</a>
          </li>
          <li class="nav-item">
            <a href="?action=duyet-de-xuat-mon-moi" class="nav-link <?php echo (isset($_REQUEST['action']) && $_REQUEST['action'] === 'duyet-de-xuat-mon-moi') ? 'active' : ''; ?>" id="newDishProposalLink">Duyệt đề xuất món mới</a>
          </li>
          <li class="nav-item">
            <a href="?action=duyet-yeu-cau-bo-sung-nguyen-lieu" class="nav-link <?php echo (isset($_REQUEST['action']) && $_REQUEST['action'] === 'duyet-yeu-cau-bo-sung-nguyen-lieu') ? 'active' : ''; ?>" id="ingredientRequestLink">Duyệt yêu cầu bổ sung nguyên liệu</a>
          </li>
          <li class="nav-item">
            <a href="?action=quan-ly-nhan-vien" class="nav-link <?php echo (isset($_REQUEST['action']) && $_REQUEST['action'] === 'quan-ly-nhan-vien') ? 'active' : ''; ?>" id="employeeManagementLink">Quản lý nhân viên</a>
          </li>
          <li class="nav-item">
            <a href="?action=quan-ly-nguyen-lieu" class="nav-link <?php echo (isset($_REQUEST['action']) && $_REQUEST['action'] === 'quan-ly-nguyen-lieu') ? 'active' : ''; ?>" id="ingredientManagementLink">Quản lý nguyên liệu</a>
          </li>
          <li class="nav-item">
            <a href="?action=quan-ly-mon-an" class="nav-link <?php echo (isset($_REQUEST['action']) && $_REQUEST['action'] === 'quan-ly-mon-an') ? 'active' : ''; ?>" id="menuManagementLink">Quản lý món ăn</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#" data-bs-toggle="collapse" data-bs-target="#party-management">
                Quản lý đặt tiệc
            </a>
            <div class="collapse sub-menu" id="party-management">
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link" href="#" data-bs-toggle="tab" data-bs-target="#add-party">Thêm</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#" data-bs-toggle="tab" data-bs-target="#edit-party">Sửa</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#" data-bs-toggle="tab" data-bs-target="#delete-party">Xóa</a>
                    </li>
                </ul>
            </div>
        </li>
          <li class="nav-item">
            <a href="./Thong_Ke_Don_Hang.html" class="nav-link <?php echo (isset($_REQUEST['action']) && $_REQUEST['action'] === 'thong-ke-don-hang') ? 'active' : ''; ?>" id="orderStatisticsLink">Thống kê đơn hàng</a>
          </li>
          <li class="nav-item">
            <a href="./XepLich.html" class="nav-link <?php echo (isset($_REQUEST['action']) && $_REQUEST['action'] === 'xem-so-luong-ban') ? 'active' : ''; ?>" id="tableCountLink">Xếp lịch</a>
          </li>
        </ul>
      </div>
      <div class="col-12 col-md-9 content">
        <div class="content" id="content">
            <div class="main">
                <div class="tab-pane fade" id="add-party">
                    <h2>Thêm đặt tiệc</h2>
                    <form>
                        <div class="mb-3">
                            <label for="customerName" class="form-label">Tên khách hàng</label>
                            <input type="text" class="form-control" id="customerName" required>
                        </div>
                        <div class="mb-3">
                            <label for="partyDate" class="form-label">Ngày đặt tiệc</label>
                            <input type="date" class="form-control" id="partyDate" required>
                        </div>
                        <div class="mb-3">
                            <label for="guestCount" class="form-label">Số lượng khách</label>
                            <input type="number" class="form-control" id="guestCount" required>
                        </div>
                        <div class="mb-3">
                            <label for="menu" class="form-label">Menu</label>
                            <textarea class="form-control" id="menu" rows="3" required></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="totalAmount" class="form-label">Tổng tiền</label>
                            <input type="number" class="form-control" id="totalAmount" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Thêm đặt tiệc</button>
                    </form>
                </div>
                <div class="tab-pane fade" id="edit-party">
                    <h2>Sửa đặt tiệc</h2>
                    <form>
                        <div class="mb-3">
                            <label for="partyId" class="form-label">ID đặt tiệc</label>
                            <input type="number" class="form-control" id="partyId" required>
                        </div>
                        <div class="mb-3">
                            <label for="customerName" class="form-label">Tên khách hàng</label>
                            <input type="text" class="form-control" id="customerName" required>
                        </div>
                        <div class="mb-3">
                            <label for="partyDate" class="form-label">Ngày đặt tiệc</label>
                            <input type="date" class="form-control" id="partyDate" required>
                        </div>
                        <div class="mb-3">
                            <label for="guestCount" class="form-label">Số lượng khách</label>
                            <input type="number" class="form-control" id="guestCount" required>
                        </div>
                        <div class="mb-3">
                            <label for="menu" class="form-label">Menu</label>
                            <textarea class="form-control" id="menu" rows="3" required></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="totalAmount" class="form-label">Tổng tiền</label>
                            <input type="number" class="form-control" id="totalAmount" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Cập nhật đặt tiệc</button>
                    </form>
                </div>
                <div class="tab-pane fade" id="delete-party">
                    <h2>Xóa đặt tiệc</h2>
                    <form>
                        <div class="mb-3">
                            <label for="deletePartyId" class="form-label">ID đặt tiệc cần xóa</label>
                            <input type="number" class="form-control" id="deletePartyId" required>
                        </div>
                        <button type="submit" class="btn btn-danger">Xóa đặt tiệc</button>
                    </form>
                </div>   
        </div>
      </div>
    </div>
  </div>
</body>

</html>