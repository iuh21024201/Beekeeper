<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <title>Form Đăng Nhập</title>
    <script src="../asset/js/login.js"></script>
    <style>
        .error {
            color: red;
            font-size: 0.9em;
            float: left;
        }
    </style>
</head>

<body>
    <form method="POST" action="#">
        <table style="margin-top: 20px;">
            <tr>
                <td>Tài Khoản:</td>
                <td>
                    <input type="text" id="email" name="txtTDN" required placeholder="Nhập email của bạn" style="width: 100%;">
                    <span id="errorEmail" class="error">*</span>
                </td>
            </tr>
            <tr>
                <td>Mật khẩu:</td>
                <td>
                    <input type="password" id="password" name="txtMK" required placeholder="Nhập mật khẩu của bạn" style="width: 100%;">
                    <span id="errorPassword" class="error">*</span>
                </td>
            </tr>
            <tr>
                <td colspan="2" style="text-align: right;">
                    <a href="?quenmk" class="forgot-password">Quên mật khẩu</a>
                </td>
            </tr>
            <tr>
                <td colspan="2" style="text-align: center;">
                    <input type="submit" name="btnDN" value="Đăng nhập" class="btn">
                </td>
            </tr>
        </table>
    </form>

</body>

<?php
if (isset($_SERVER['REQUEST_METHOD']) == 'POST') {
    if (isset($_POST['btnDN'])) {
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "beekeeper";

        $conn = new mysqli($servername, $username, $password, $dbname);

        if ($conn->connect_error) {
            die("Kết nối thất bại: " . $conn->connect_error);
        }
        $tenDangNhap = trim($_POST["txtTDN"]);
        $matKhau = md5(trim($_POST["txtMK"]));

        $sql = "SELECT tk.ID_TaiKhoan, tk.PhanQuyen, tk.TenTaiKhoan, tk.MatKhau, nv.ID_NhanVien, nv.ID_TaiKhoan FROM TaiKhoan tk 
            LEFT JOIN nhanvien nv ON tk.ID_TaiKhoan = nv.ID_TaiKhoan
            WHERE TenTaiKhoan = ? AND MatKhau = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ss", $tenDangNhap, $matKhau);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $_SESSION["dn"] = $row["PhanQuyen"];
            $_SESSION["ID_TaiKhoan"] = $row["ID_TaiKhoan"];
            $_SESSION["ID_NhanVien"] = $row["ID_NhanVien"];
            echo "<script>alert('Đăng nhập thành công!');</script>";
        } else {
            echo "<script>alert('Tên đăng nhập hoặc mật khẩu không đúng!');</script>";
        }

        // Đóng kết nối
        $stmt->close();
        $conn->close();
    }
}
