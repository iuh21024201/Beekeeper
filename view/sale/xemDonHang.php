<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Danh Sách Đơn Hàng</title>
    <!-- Thêm Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .table {
            border-radius: 10px;
            overflow: hidden;
        }
        .table th, .table td {
            vertical-align: middle;
        }
        .table tbody tr:hover {
            background-color: #f5f5f5;
        }
        .container {
            margin-top: 50px;
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
    </style>
</head>
<body>
    <?php
    include_once("../../Controller/cDonHang.php");
    include_once("../../Controller/c_lay_nhan_vien.php");

    // Kiểm tra người dùng đã đăng nhập hay chưa
    $idTaiKhoan = isset($_SESSION['ID_TaiKhoan']) ? $_SESSION['ID_TaiKhoan'] : null;

    if ($idTaiKhoan !== null) {
        // Lấy thông tin nhân viên dựa trên tài khoản
        $pNhanVien = new cNhanVien();
        $kq = $pNhanVien->get01NhanVien($idTaiKhoan);

        if ($kq && $row = mysqli_fetch_assoc($kq)) {
            $idCuaHang = intval($row['ID_CuaHang']); // Lấy ID_CuaHang từ nhân viên
        } else {
            echo "<script>alert('Không tìm thấy thông tin nhân viên. Vui lòng đăng nhập lại.'); window.history.back();</script>";
            exit;
        }
    } else {
        echo "<script>alert('Người dùng chưa đăng nhập.'); window.history.back();</script>";
        exit;
    }

    // Kiểm tra và lấy danh sách đơn hàng dựa trên ID_CuaHang
    if ($idCuaHang !== null) {
        $pDonHang = new controlDonHang();
        $kqDonHang = $pDonHang->getDHByIDCuaHang($idCuaHang);

        if ($kqDonHang && mysqli_num_rows($kqDonHang) > 0) {
            // Hiển thị bảng danh sách đơn hàng
            echo "<div class='container'>";
            echo "<h2 class='text-center mb-4'>Danh Sách Đơn Hàng</h2>";
            echo "<table class='table table-striped table-hover table-bordered text-center'>";
            echo "<thead class='thead-dark'>
                    <tr>
                        <th scope='col'>Đơn hàng ID</th>
                        <th scope='col'>Cửa hàng</th>
                        <th scope='col'>Ngày đặt</th>
                        <th scope='col'>Địa chỉ giao hàng</th>
                        <th scope='col'>Trạng thái</th>
                        <th scope='col'>Chi tiết</th>
                    </tr>
                  </thead>";
            echo "<tbody>";
            while ($row = mysqli_fetch_assoc($kqDonHang)) {
                echo "<tr>";
                echo "<td>" . $row['ID_DonHang'] . "</td>";
                echo "<td>" . $row['TenCuaHang'] . "</td>";
                echo "<td>" . date('d/m/Y', strtotime($row['NgayDat'])) . "</td>";
                echo "<td>" . htmlspecialchars($row['DiaChiGiaoHang']) . "</td>";
                echo "<td>" . htmlspecialchars($row['TrangThai']) . "</td>";
                echo "<td><a href='trang-quan-tri.php?action=chitietdonhang&order_id=". $row['ID_DonHang'] ."' class='btn btn-primary btn-sm'>Xem chi tiết</a></td>";
                echo "</tr>";
            }
            echo "</tbody></table>";
            echo "</div>";
        } else {
            echo "<div class='container text-center'>";
            echo "<p class='alert alert-warning'>Không có đơn hàng nào thuộc cửa hàng này.</p>";
            echo "</div>";
        }
    } else {
        echo "<div class='container text-center'>";
        echo "<p class='alert alert-danger'>Không tìm thấy thông tin cửa hàng.</p>";
        echo "</div>";
    }
    ?>
    <!-- Thêm Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
