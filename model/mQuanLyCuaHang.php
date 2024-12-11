<?php
include_once("ketnoi.php");

class mQuanLyCuaHang
{
    public $conn;

    public function __construct()
    {
        $p = new clsketnoi();
        $this->conn = $p->moKetNoi();
    }

    public function addAccount($username, $password, $position)
    {
        $sqlAccount = "INSERT INTO taikhoan (TenTaiKhoan, MatKhau, PhanQuyen) VALUES ('$username', '$password', $position)";
        if ($this->conn->query($sqlAccount) === TRUE) {
            return $this->conn->insert_id; // Trả về ID của tài khoản
        } else {
            echo "Lỗi khi thêm tài khoản: " . $this->conn->error;
            exit;
        }
    }

    // Hàm thêm nhân viên hoặc quản lý
    public function addEmployeeOrManager($accountID, $store, $fullName, $phone, $email, $status, $position)
    {
        if ($position != 2) {
            $sqlEmployee = "INSERT INTO nhanvien (ID_TaiKhoan, ID_CuaHang, HoTen, SoDienThoai, Email, TrangThai) 
                            VALUES ('$accountID', '$store', '$fullName', '$phone', '$email', $status)";
        } else {
            $sqlEmployee = "INSERT INTO quanlycuahang (ID_TaiKhoan, ID_CuaHang, HoTen, SoDienThoai, Email, TrangThai) 
                            VALUES ('$accountID', '$store', '$fullName', '$phone', '$email', $status)";
        }

        if ($this->conn->query($sqlEmployee) === TRUE) {
            return true; // Thêm thành công
        } else {
            echo "Lỗi khi thêm nhân viên: " . $this->conn->error;
            return false; // Thêm thất bại
        }
    }

    public function updateEmployee($employeeID, $fullName, $email, $phone, $store, $status, $position, $username)
    {
        if ($position != 2) {
            $sqlUpdate = "UPDATE nhanvien 
                        SET HoTen='$fullName', Email='$email', SoDienThoai='$phone', ID_CuaHang='$store', TrangThai='$status' 
                        WHERE ID_NhanVien='$employeeID'";
        } else {
            $sqlUpdate = "UPDATE quanlycuahang 
                        SET HoTen='$fullName', Email='$email', SoDienThoai='$phone', ID_CuaHang='$store', TrangThai='$status' 
                        WHERE ID_QuanLyCuaHang='$employeeID'";
        }

        $sqlUpdateAccount = "UPDATE taikhoan 
                            SET PhanQuyen='$position', TenTaiKhoan='$username' 
                            WHERE ID_TaiKhoan=(SELECT ID_TaiKhoan FROM nhanvien WHERE ID_NhanVien='$employeeID')";

        if ($this->conn->query($sqlUpdate) === TRUE) {
            $this->conn->query($sqlUpdateAccount); // Cập nhật tài khoản
            return true; // Cập nhật thành công
        } else {
            echo "Lỗi khi cập nhật nhân viên: " . $this->conn->error;
            return false; // Cập nhật thất bại
        }
    }

    public function checkDate($selectedDate, $chiNhanh)
    {
        $p = new clsketnoi();
        $conn = $p->moKetNoi();

        $idCuaHang = $chiNhanh[0]['ID_CuaHang'] ?? 0;

        if (!DateTime::createFromFormat('Y-m-d', $selectedDate)) {
            $selectedDate = date('Y-m-d');
        }

        $query = "SELECT nv.ID_NhanVien, nv.HoTen, c.id, c.CheckIn, c.CheckOut, c.TrangThai AS TrangThaiCa, c.Thu, c.Tuan, c.TenCa
                    FROM nhanvien nv
                    LEFT JOIN chamcong c ON nv.ID_NhanVien = c.ID_NhanVien 
                                        AND c.NgayChamCong = ?
                    WHERE nv.ID_CuaHang = ? 
                    AND (c.TrangThai IN ('Lịch làm việc', 'Đang chấm công', 'Đã chấm công'))";

        $stmt = $conn->prepare($query);
        if (!$stmt) {
            die('Lỗi chuẩn bị truy vấn: ' . $conn->error);
        }

        $stmt->bind_param('si', $selectedDate, $idCuaHang);
        $stmt->execute();
        $result = $stmt->get_result();

        $employees = [];
        if (!empty($result) && $result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $employees[] = $row;
            }
        }

        $stmt->close();
        $p->dongKetNoi($conn);

        return $employees;
    }

    public function selectCheckIn($idNhanVien, $currentDate)
    {
        $query = "SELECT * FROM chamcong WHERE ID_NhanVien = ? AND NgayChamCong = ? AND CheckIn IS NOT NULL";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param('is', $idNhanVien, $currentDate);
        $stmt->execute();
        $result = $stmt->get_result();

        return $result;
    }

    public function selectBonus($idNhanVien, $currentDate)
    {
        $query = "SELECT COUNT(*) AS total_approved 
              FROM danhsachdexuatmonmoi 
              WHERE ID_NhanVien = ? AND TrangThai = 1 AND MONTH(NgayDuyet) = MONTH(?)";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param('is', $idNhanVien, $currentDate);
        $stmt->execute();
        $result = $stmt->get_result();
        $data = $result->fetch_assoc();

        return $data['total_approved'];
    }

    public function updateCheckOut($idNhanVien, $currentDate, $checkOutDateTime, $soGioLam, $bonusAmount, $tongLuong)
    {
        $query = "UPDATE chamcong 
              SET CheckOut = ?, TrangThai = 'Đã chấm công', SoGioLam = ?
              WHERE ID_NhanVien = ? AND NgayChamCong = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param('sdis', $checkOutDateTime, $soGioLam, $idNhanVien, $currentDate);

        if ($stmt->execute()) {
            $insertLuongQuery = "INSERT INTO luong (ID_NhanVien, TongGioLam, LuongTheoGio, Thuong, TongLuong, start_date, end_date)
                             VALUES (?, ?, ?, ?, ?, ?, ?)";
            $stmtLuong = $this->conn->prepare($insertLuongQuery);
            $luongTheoGio = 30000;
            $stmtLuong->bind_param('idddsss', $idNhanVien, $soGioLam, $luongTheoGio, $bonusAmount, $tongLuong, $currentDate, $currentDate);

            return $stmtLuong->execute();
        }

        return false;
    }

    public function checkAndUpdateCheckIn($idNhanVien, $idChamCong)
    {
        $currentDate = date('Y-m-d');
        $checkExisting = "SELECT * FROM chamcong WHERE ID_NhanVien = ? AND NgayChamCong = ? AND id = ?";

        $stmt = $this->conn->prepare($checkExisting);
        if (!$stmt) {
            die('Lỗi chuẩn bị truy vấn: ' . $this->conn->error);
        }

        $stmt->bind_param('isi', $idNhanVien, $currentDate, $idChamCong);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $existingRecord = $result->fetch_assoc();

            // Kiểm tra xem đã Check-out chưa
            if ($existingRecord['CheckOut'] !== null) {
                return false;
            }

            if ($existingRecord['TrangThai'] != 'Lịch làm việc' && $existingRecord['TrangThai'] !== null) {
                return false;
            }

            $checkInTime = date('H:i:s');
            $trangThaiMoi = 'Đang chấm công';
            $updateQuery = "UPDATE chamcong SET Checkin = ?, TrangThai = ? WHERE id = ?";

            $stmtUpdate = $this->conn->prepare($updateQuery);
            $stmtUpdate->bind_param('ssi', $checkInTime, $trangThaiMoi, $idChamCong);

            if ($stmtUpdate->execute()) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }


    public function getEmployeesByStore($storeID)
    {
        $p = new clsketnoi();
        $conn = $p->moKetNoi();

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

    public function getEmployeesByStoreQuanLy($storeID)
    {
        $p = new clsketnoi();
        $conn = $p->moKetNoi();

        // Truy vấn lấy nhân viên theo cửa hàng
        $sql = "SELECT 
                    quanlycuahang.ID_QuanLyCuaHang,
                    quanlycuahang.ID_CuaHang,
                    quanlycuahang.HoTen,
                    quanlycuahang.SoDienThoai,
                    quanlycuahang.Email,
                    quanlycuahang.TrangThai,
                    cuahang.TenCuaHang,
                    cuahang.DiaChi,
                    taikhoan.TenTaiKhoan,
                    taikhoan.MatKhau,
                    taikhoan.PhanQuyen
                FROM quanlycuahang
                JOIN cuahang ON quanlycuahang.ID_CuaHang = cuahang.ID_CuaHang
                JOIN taikhoan ON quanlycuahang.ID_TaiKhoan = taikhoan.ID_TaiKhoan 
                WHERE quanlycuahang.ID_CuaHang = ?";

        $stmt = $conn->prepare($sql);
        $stmt->bind_param('i', $storeID);  // Bind ID cửa hàng vào câu truy vấn
        $stmt->execute();
        $result = $stmt->get_result();

        $quanlyCuaHanglist = [];
        while ($row = $result->fetch_assoc()) {
            $quanlyCuaHanglist[] = $row;
        }


        $stmt->close();
        $conn->close();

        return $quanlyCuaHanglist;
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

        // Câu truy vấn
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
                JOIN taikhoan ON nhanvien.ID_TaiKhoan = taikhoan.ID_TaiKhoan";

        // Chuẩn bị truy vấn
        $stmt = $con->prepare($sql);
        if (!$stmt) {
            die('Lỗi chuẩn bị truy vấn: ' . $con->error);
        }

        $stmt->execute();
        $result = $stmt->get_result();

        // Xử lý kết quả
        $nhanvienlist = [];
        if ($result) {
            while ($row = $result->fetch_assoc()) {
                $nhanvienlist[] = $row;
            }
        } else {
            error_log("Lỗi truy vấn: " . $stmt->error);
        }

        // Đóng kết nối
        $stmt->close();
        $p->dongKetNoi($con);

        return $nhanvienlist;
    }

    public function selectAllQuanLy()
    {
        $p = new clsketnoi();
        $con = $p->moKetNoi();
        $truyvan = "SELECT 
                quanlycuahang.ID_QuanLyCuaHang,
                quanlycuahang.HoTen,
                quanlycuahang.SoDienThoai,
                quanlycuahang.Email,
                quanlycuahang.TrangThai,
                cuahang.TenCuaHang,
                cuahang.DiaChi,
                taikhoan.TenTaiKhoan,
                taikhoan.MatKhau,
                taikhoan.PhanQuyen
            FROM quanlycuahang
            JOIN cuahang ON quanlycuahang.ID_CuaHang = cuahang.ID_CuaHang
            JOIN taikhoan ON quanlycuahang.ID_TaiKhoan = taikhoan.ID_TaiKhoan";
        $tbl = mysqli_query($con, $truyvan);

        if (!$tbl) {
            die('Lỗi truy vấn: ' . mysqli_error($con));
        }

        // Duyệt qua kết quả và lưu vào mảng
        $quanlylist = [];
        while ($row = mysqli_fetch_assoc($tbl)) {
            $quanlylist[] = $row;
        }

        $p->dongKetNoi($con);
        return $quanlylist;
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


    public function selectOneQL($id)
    {
        $p = new clsketnoi();
        $con = $p->moKetNoi();

        $truyvan = "SELECT 
                        quanlycuahang.ID_QuanLyCuaHang,
                        quanlycuahang.HoTen,
                        quanlycuahang.SoDienThoai,
                        quanlycuahang.Email,
                        quanlycuahang.TrangThai,
                        cuahang.ID_CuaHang,
                        cuahang.TenCuaHang,
                        cuahang.DiaChi,
                        taikhoan.TenTaiKhoan,
                        taikhoan.MatKhau,
                        taikhoan.PhanQuyen
                    FROM quanlycuahang
                    JOIN cuahang ON quanlycuahang.ID_CuaHang = cuahang.ID_CuaHang
                    JOIN taikhoan ON quanlycuahang.ID_TaiKhoan = taikhoan.ID_TaiKhoan WHERE quanlycuahang.ID_QuanLyCuaHang = ?";

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

    public function updateTrangThaiQL($id, $trangthai)
    {
        $p = new clsketnoi();
        $con = $p->moKetNoi();
        $truyvan = "UPDATE quanlycuahang SET TrangThai = $trangthai WHERE ID_QuanLyCuaHang = $id";
        $tbl = mysqli_query($con, $truyvan);
        $p->dongKetNoi($con);
        return $tbl;
    }
}
