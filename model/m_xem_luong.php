<?php
include_once("ketnoi.php");
class m_xem_luong
{
    public $conn;

    public function __construct()
    {
        $p = new clsketnoi();
        $this->conn = $p->moKetNoi();
    }

    public function getSalaryInfo($employee_id, $month = null, $year = null)
    {
        $query = "
        SELECT 
            nv.ID_NhanVien, 
            nv.HoTen, 
            ch.TenCuaHang AS CuaHang, 
            SUM(l.TongGioLam) AS TongGioLam, 
            l.LuongTheoGio, 
            l.Thuong, 
            SUM(l.TongLuong) AS TongLuong,
            MONTH(l.start_date) AS Thang,
            YEAR(l.start_date) AS Nam
        FROM 
            luong l
        JOIN 
            nhanvien nv ON l.ID_NhanVien = nv.ID_NhanVien
        JOIN 
            cuahang ch ON nv.ID_CuaHang = ch.ID_CuaHang
        WHERE l.ID_NhanVien = ?
    ";

        if ($month && $year) {
            $query .= " AND MONTH(l.start_date) = ? AND YEAR(l.start_date) = ?";
        }

        $query .= " GROUP BY nv.ID_NhanVien, nv.HoTen, ch.TenCuaHang, l.LuongTheoGio, l.Thuong, MONTH(l.start_date), YEAR(l.start_date)"; // Cập nhật GROUP BY

        $stmt = $this->conn->prepare($query);

        if ($month && $year) {
            $stmt->bind_param("iss", $employee_id, $month, $year);
        } else {
            $stmt->bind_param("i", $employee_id);
        }

        $stmt->execute();
        return $stmt->get_result();
    }



    // Phương thức tính tổng lương nhân viên với điều kiện tháng và năm
    public function getTotalSalary($month = null, $year = null)
    {
        $query = "
            SELECT 
                SUM(l.TongLuong) AS TotalSalary
            FROM 
                luong l
            JOIN 
                nhanvien nv ON l.ID_NhanVien = nv.ID_NhanVien
            JOIN 
                cuahang ch ON nv.ID_CuaHang = ch.ID_CuaHang
            WHERE 1=1
        ";

        if ($month && $year) {
            $query .= " AND MONTH(l.start_date) = ? AND YEAR(l.start_date) = ?";
        }

        $stmt = $this->conn->prepare($query);

        if ($month && $year) {
            $stmt->bind_param("ss", $month, $year);
        }

        $stmt->execute();
        $result = $stmt->get_result();
        $total_salary = 0;
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $total_salary = $row['TotalSalary'];
        }
        return $total_salary;
    }

    // Phương thức thêm bản ghi vào bảng lương
    public function insertSalaryRecord($id_nhanvien, $tonggio_lam, $luongtheogio, $thuong, $tongluong, $start_date, $end_date)
    {
        $insert_query = "
            INSERT INTO `luong` (`ID_NhanVien`, `TongGioLam`, `LuongTheoGio`, `Thuong`, `TongLuong`, `start_date`, `end_date`)
            VALUES (?, ?, ?, ?, ?, ?, ?)
        ";

        $stmt = $this->conn->prepare($insert_query);
        $stmt->bind_param("iidddss", $id_nhanvien, $tonggio_lam, $luongtheogio, $thuong, $tongluong, $start_date, $end_date);

        if ($stmt->execute()) {
            return "Bản ghi đã được thêm thành công!";
        } else {
            return "Lỗi khi thêm bản ghi: " . $stmt->error;
        }
    }
}
