<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/Beekeeper/model/mQuanLyCuaHang.php');
if(!empty($_POST)) {

}
$sql = 'insert into nhanvien'
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
        h4{
            text-align: center;
            margin-top: 30px;
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
            text-align: center;
        }
        #form-container{
            border: 1px solid black;
            
            padding: 20px 40px;
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
            <button class="btn btn-submit" id="them-btn" onclick="openForm()">Thêm</button>
        </div>
    </div>
    <table id="ds-nhan-vien">
        <thead>
            <tr>
                <th class="p-2">Mã nhân viên</th>
                <th class="p-2">Họ và tên</th>
                <th class="p-2">Email</th>
                <th class="p-2">SDT</th>
                <th class="p-2">ID cửa hàng</th>
                <th class="p-2">Trạng thái</th>
                <th class="p-2"></th>
            </tr>
        </thead> 
        <tbody>
            <?php
            $sql = 'SELECT * FROM nhanvien';
                $nhanvienlist = executeResult($sql);
                foreach ($nhanvienlist as $nv)  {
                    echo '
                        <tr>                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            
                            <td>'.$nv['ID_NhanVien'].'</td>
                            <td>'.$nv['HoTen'].'</td>
                            <td>'.$nv['Email'].'</td>
                            <td>'.$nv['SoDienThoai'].'</td>
                            <td>'.$nv['ID_CuaHang'].'</td>
                            <td>'.$nv['TrangThai'].'</td>
                            <td><button type="button" class="btn btn-warning">Sửa</button> <button type="button" class="btn btn-danger">Xóa</button> </td>
                        </tr>';
                }
            ?>
        </tbody>
    </table>

<!-- Nút mở form -->
<!-- Form nhập thông tin nhân viên -->
<div id="form-container" class="form-container" style="display: none;">
    <h4>NHẬP THÔNG TIN NHÂN VIÊN</h4>
    <form method="POST" action="save_employee.php">
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
                <option value="Staff">Nhân viên</option>
                <option value="Intern">Nhân viên bếp</option>
            </select>
        </div>
        <div class="form-group">
            <label for="store">Cửa hàng</label>
            <select id="store" name="store" required>
                <option value="">Chi nhánh : Gò Vấp </option>
                <option value="">Chi nhánh : Q1 </option>
            </select>
        </div>
        <div class="form-group">
            <label for="status">Trạng thái</label>
            <select id="status" name="status" required>
                <option value="active">Đang làm việc</option>
                <option value="inactive">Ngưng làm việc</option>
            </select>
        </div>
        <div class="form-group my-4">
            <input type="submit" value="Lưu thông tin" class="submit-btn">
        </div>
    </form>
</div>

<script>
function openForm() {
    document.getElementById("form-container").style.display = "block";
    document.getElementById("them-btn").style.display = "none";
}
</script>

</body>
</html>
