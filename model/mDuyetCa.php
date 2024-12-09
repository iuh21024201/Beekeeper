<?php
class mDuyetCa {
    private $conn;

    public function __construct() {
        $servername = "localhost";
        $username = "root";
        $password = "";
        $database = "db_beekeeper";

        $this->conn = new mysqli($servername, $username, $password, $database);
        if ($this->conn->connect_error) {
            die("Connection failed: " . $this->conn->connect_error);
        }
    }

    public function getApprovedEmployees($day, $shift, $week, $storeId) {
        try {
            $query = "SELECT nv.ID_NhanVien, nv.HoTen 
                      FROM chamcong c
                      JOIN nhanvien nv ON c.ID_NhanVien = nv.ID_NhanVien
                      WHERE c.TrangThai = 'Lịch làm việc' 
                      AND c.Thu = ? 
                      AND c.Tuan = ? 
                      AND c.TenCa = ?
                      AND nv.ID_CuaHang = ?";
            
            $stmt = $this->conn->prepare($query);
            $stmt->bind_param("sisi", $day, $week, $shift, $storeId);
            $stmt->execute();
            $result = $stmt->get_result();
            
            $employees = [];
            while ($row = $result->fetch_assoc()) {
                $employees[] = $row;
            }
            return $employees;
        } catch (Exception $e) {
            error_log("Error in getApprovedEmployees: " . $e->getMessage());
            throw $e;
        }
    }

    public function getPendingEmployees($day, $shift, $week, $storeId) {
        try {
            $query = "SELECT nv.ID_NhanVien, nv.HoTen 
                      FROM chamcong c 
                      JOIN nhanvien nv ON c.ID_NhanVien = nv.ID_NhanVien
                      WHERE c.TrangThai = 'Đăng ký ca' 
                      AND c.Thu = ? 
                      AND c.Tuan = ? 
                      AND c.TenCa = ?
                      AND nv.ID_CuaHang = ?";
            
            $stmt = $this->conn->prepare($query);
            $stmt->bind_param("sisi", $day, $week, $shift, $storeId);
            $stmt->execute();
            $result = $stmt->get_result();
            
            $employees = [];
            while ($row = $result->fetch_assoc()) {
                $employees[] = $row;
            }
            return $employees;
        } catch (Exception $e) {
            error_log("Error in getPendingEmployees: " . $e->getMessage());
            throw $e;
        }
    }

    public function approveShift($employeeId, $day, $shift, $week, $storeId) {
        try {
            $query = "UPDATE chamcong c
                      JOIN nhanvien nv ON c.ID_NhanVien = nv.ID_NhanVien
                      SET c.TrangThai = 'Lịch làm việc' 
                      WHERE c.ID_NhanVien = ? 
                        AND c.Thu = ? 
                        AND c.Tuan = ? 
                        AND c.TenCa = ? 
                        AND c.TrangThai = 'Đăng ký ca'
                        AND nv.ID_CuaHang = ?";
            
            $stmt = $this->conn->prepare($query);
            $stmt->bind_param("isisi", $employeeId, $day, $week, $shift, $storeId);
            return $stmt->execute();
        } catch (Exception $e) {
            error_log("Error in approveShift: " . $e->getMessage());
            throw $e;
        }
    }
}

