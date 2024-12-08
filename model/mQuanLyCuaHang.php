<?php
include_once("ketnoi.php");

class mQuanLyCuaHang
{
    public function getEmployeesByStore($storeID)
    {
        // Tạo kết nối CSDL
        $conn = new mysqli("localhost", "root", "", "beekeeper");
        if ($conn->connect_error) {
            die("Kết nối thất bại: " . $conn->connect_error);
        }

        // Truy vấn lấy nhân viên theo cửa hàng
        $sql = "SELECT 
                    nhanvien.ID_NhanVien,
                    nhanvien.HoTen,
                    nhanvien.SoDienThoai,
                    nhanvien.Email,
                    nhanvien.TrangThai,
                    cuahang.TenCuaHang,
                    cuahang.DiaChi,
                    taikhoan.TenTaiKhoan,
                    taikhoan.MatKhau,
                    taikhoan.PhanQuyen
                FROM nhanvien
                JOIN cuahang ON nhanvien.ID_CuaHang = cuahang.ID_CuaHang
                JOIN taikhoan ON nhanvien.ID_TaiKhoan = taikhoan.ID_TaiKhoan 
                WHERE nhanvien.ID_CuaHang = ?";

        $stmt = $conn->prepare($sql);
        $stmt->bind_param('i', $storeID);  // Bind ID cửa hàng vào câu truy vấn
        $stmt->execute();
        $result = $stmt->get_result();

        $nhanvienlist = [];
        while ($row = $result->fetch_assoc()) {
            $nhanvienlist[] = $row;
        }

        $stmt->close();
        $conn->close();

        return $nhanvienlist;
    }

    public function selectAllCuaHang()
    {
        $p = new clsketnoi();
        $con = $p->moKetNoi();
        $truyvan = "select * from cuahang";
        $tbl = mysqli_query($con, $truyvan);
        $p->dongKetNoi($con);
        return $tbl;
    }

    public function selectAllNhanVien()
    {
        $p = new clsketnoi();
        $con = $p->moKetNoi();
        $truyvan = "SELECT 
                nhanvien.ID_NhanVien,
                nhanvien.HoTen,
                nhanvien.SoDienThoai,
                nhanvien.Email,
                nhanvien.TrangThai,
                cuahang.TenCuaHang,
                cuahang.DiaChi,
                taikhoan.TenTaiKhoan,
                taikhoan.MatKhau,
                taikhoan.PhanQuyen
            FROM nhanvien
            JOIN cuahang ON nhanvien.ID_CuaHang = cuahang.ID_CuaHang
            JOIN taikhoan ON nhanvien.ID_TaiKhoan = taikhoan.ID_TaiKhoan";
        $tbl = mysqli_query($con, $truyvan);

        if (!$tbl) {
            die('Lỗi truy vấn: ' . mysqli_error($con));
        }

        // Duyệt qua kết quả và lưu vào mảng
        $nhanvienlist = [];
        while ($row = mysqli_fetch_assoc($tbl)) {
            $nhanvienlist[] = $row;
        }

        $p->dongKetNoi($con);
        return $nhanvienlist;
    }

    public function getChiNhanhByID($id)
    {
        $p = new clsketnoi();
        $con = $p->moKetNoi();

        $truyvan = "SELECT 
                    taikhoan.ID_TaiKhoan,
                    cuahang.ID_CuaHang,
                    cuahang.TenCuaHang,
                    cuahang.DiaChi
                FROM
                    taikhoan
                JOIN quanlycuahang ON taikhoan.ID_TaiKhoan = quanlycuahang.ID_TaiKhoan
                JOIN cuahang ON quanlycuahang.ID_CuaHang = cuahang.ID_CuaHang
                WHERE taikhoan.ID_TaiKhoan = ?";

        $stmt = mysqli_prepare($con, $truyvan);
        if ($stmt === false) {
            echo "Lỗi chuẩn bị truy vấn: " . mysqli_error($con);
            return null;
        }

        mysqli_stmt_bind_param($stmt, "i", $id);

        if (!mysqli_stmt_execute($stmt)) {
            echo "Lỗi thực thi truy vấn: " . mysqli_stmt_error($stmt);
            mysqli_stmt_close($stmt);
            $p->dongKetNoi($con);
            return null;
        }

        $result = mysqli_stmt_get_result($stmt);
        $data = [];
        while ($row = mysqli_fetch_assoc($result)) {
            $data[] = $row;
        }

        mysqli_stmt_close($stmt);
        $p->dongKetNoi($con);

        return $data;
    }



    public function selectOneNhanVien($id)
    {
        $p = new clsketnoi();
        $con = $p->moKetNoi();

        $truyvan = "SELECT 
                    nhanvien.ID_NhanVien,
                    nhanvien.HoTen,
                    nhanvien.SoDienThoai,
                    nhanvien.Email,
                    nhanvien.TrangThai,
                    cuahang.ID_CuaHang,
                    cuahang.TenCuaHang,
                    cuahang.DiaChi,
                    taikhoan.TenTaiKhoan,
                    taikhoan.MatKhau,
                    taikhoan.PhanQuyen
                FROM nhanvien
                JOIN cuahang ON nhanvien.ID_CuaHang = cuahang.ID_CuaHang
                JOIN taikhoan ON nhanvien.ID_TaiKhoan = taikhoan.ID_TaiKhoan WHERE nhanvien.ID_NhanVien = ?";

        $stmt = mysqli_stmt_init($con);

        if (mysqli_stmt_prepare($stmt, $truyvan)) {
            mysqli_stmt_bind_param($stmt, 'i', $id);

            mysqli_stmt_execute($stmt);

            $result = mysqli_stmt_get_result($stmt);

            if ($row = mysqli_fetch_assoc($result)) {
                $tbl = $row;
            } else {
                $tbl = null;
            }

            mysqli_stmt_close($stmt);
        } else {
            $tbl = null;
        }

        $p->dongKetNoi($con);

        return $tbl;
    }



    public function updateTrangThai($id, $trangthai)
    {
        $p = new clsketnoi();
        $con = $p->moKetNoi();
        $truyvan = "UPDATE nhanvien SET TrangThai = $trangthai WHERE ID_NhanVien = $id";
        $tbl = mysqli_query($con, $truyvan);
        $p->dongKetNoi($con);
        return $tbl;
    }
}
