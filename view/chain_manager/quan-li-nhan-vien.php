<?php
$successMessage = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Giả sử bạn đã có kết nối database
    // Thực hiện thêm nhân viên vào database
    $ID_NhanVien = $_POST['ID_NhanVien'];
    $HoTen = $_POST['HoTen'];
    $Email = $_POST['Email'];
    $SoDienThoai = $_POST['SoDienThoai'];
    $ID_TaiKhoan = $_POST['ID_TaiKhoan'];
    $MatKhau = $_POST['MatKhau'];
    $PhanQuyen = $_POST['PhanQuyen'];
    $TrangThaiLamViec = $_POST['TrangThaiLamViec'];

    // Giả sử bạn có hàm thêm nhân viên vào database, ví dụ như addEmployee()
    $isAdded = addEmployee($ID_NhanVien, $HoTen, $Email, $SoDienThoai, $ID_TaiKhoan, $MatKhau, $PhanQuyen, $TrangThaiLamViec);

    if ($isAdded) {
        $successMessage = "Thêm nhân viên thành công!";
    }
}

function addEmployee($ID_NhanVien, $HoTen, $Email, $SoDienThoai, $ID_TaiKhoan, $MatKhau, $PhanQuyen, $TrangThaiLamViec) {
    // Giả sử bạn thực hiện kết nối và câu truy vấn vào database ở đây
    // Trả về true nếu thêm thành công
    return true; // Thay thế với logic thực tế
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý nhân viên</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        #CuaHang {
            width: 600px;
            height: 40px;
            margin-left: 0px;
            border: 1px solid black;
            text-align: center;
        }
        #them-btn, #xoa-btn {
            padding: 8px 40px;
            margin-top: 10px;
            margin-left: 20px;
            background-color: white;
            border: 1px solid black;
        }
        input[type= "text"]{
            width: 700px;
        }
        th, tr, td {
            border: 1px solid black;
        }
        .form-group {
            margin-bottom: 15px;
        }
        .form-group label {
            display: block;
            font-weight: bold;
            margin-bottom: 5px;
        }
        .form-group input,
        .form-group select {
            width: 100%;
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        .form-group input[type="submit"] {
            background-color: #4CAF50;
            color: white;
            border: none;
            cursor: pointer;
            font-weight: bold;
        }
        .form-group input[type="submit"]:hover {
            background-color: #45a049;
        }
        #form {
            display: none; /* Ẩn form ban đầu */
            margin-top: 20px;
        }
        #nhan-vien-form h4{
            text-align: center;
        }
        #ds-nhan-vien{
            width: 100%;
        }
    </style>
</head>
<body class="bg-gray-200">
    <div class="flex justify-between items-center">
        <select name="cuahang" id="CuaHang">
            <option value="Gò Vấp">Chi nhánh 1: Gò Vấp</option>
            <option value="Quận 1">Chi nhánh 2: Quận 1</option>
            <option value="Quận 2">Chi nhánh 3: Quận 2</option>
        </select>
        <div class="flex justify-between items-center mb-4 mt-3">
            <button id="them-btn" onclick="showOrderForm()">Thêm</button>
            <button id="xoa-btn">Xóa</button>
        </div>
    </div>
    <table id="ds-nhan-vien">
        <thead>
            <tr>
                <th class="p-2">Mã nhân viên</th>
                <th class="p-2">Họ và tên</th>
                <th class="p-2">Email</th>
                <th class="p-2">SDT</th>
                <th class="p-2">Tên đăng nhập</th>
                <th class="p-2">Mật khẩu</th>
                <th class="p-2">Chức vụ</th>
                <th class="p-2">Trạng thái</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td class="p-2"></td>
                <td class="p-2"></td>
                <td class="p-2"></td>
                <td class="p-2"></td>
                <td class="p-2"></td>
                <td class="p-2"></td>
                <td class="p-2"></td>
                <td class="p-2"></td>
            </tr>
        </tbody>
    </table>

    <div id="form">
        <div id="nhan-vien-form">
            <h4 >NHẬP THÔNG TIN NHÂN VIÊN</h4>
            <table>
                <form method="POST" action="">
                    <div class="form-group">
                        <label for="employeeID">Mã nhân viên</label>
                        <input type="text" id="employeeID" name="employeeID" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="fullName">Họ và tên</label>
                        <input type="text" id="fullName" name="fullName" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" id="email" name="email" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="phone">Số điện thoại</label>
                        <input type="tel" id="phone" name="phone" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="username">Tên đăng nhập</label>
                        <input type="text" id="username" name="username" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="password">Mật khẩu</label>
                        <input type="password" id="password" name="password" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="position">Chức vụ</label>
                        <select id="position" name="position" required>
                            <option value="">--Chọn chức vụ--</option>
                            <option value="Manager">Quản lý</option>
                            <option value="Staff">Nhân viên</option>
                            <option value="Intern">Nhân viên bếp</option>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label for="status">Trạng thái</label>
                        <select id="status" name="status" required>
                            <option value="active">Đang làm việc</option>
                            <option value="inactive">Ngưng làm việc</option>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <input type="submit" value="Lưu thông tin">
                    </div>
                </form>
            </table>
            
        </div>
    </div>

    <script>
        // Hiển thị form nhập thông tin khi nhấn nút "Thêm"
        function showOrderForm() {
            document.getElementById("form").style.display = "block"; 
            document.getElementById("them-btn").style.display = "none"; 
        }


    </script>
</body>
</html>
