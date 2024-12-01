<?php
class mDuyetCa {
    private $conn;

    public function __construct() {
        $servername = "localhost";
        $username = "root";
        $password = "";
        $database = "db_beekeeper_7";

        $this->conn = new mysqli($servername, $username, $password, $database);
        if ($this->conn->connect_error) {
            die("Connection failed: " . $this->conn->connect_error);
        }
    }

    public function getApprovedEmployees($day, $shift, $week) {
        $query = "SELECT nv.ID_NhanVien, nv.HoTen 
                  FROM ca c
                  JOIN nhanvien nv ON c.ID_NhanVien = nv.ID_NhanVien
                  WHERE c.TrangThai = 'Lịch làm việc' 
                  AND c.Thu = ? 
                  AND c.Tuan = ? 
                  AND c.TenCa = ?";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("sis", $day, $week, $shift);
        $stmt->execute();
        $result = $stmt->get_result();
        
        $employees = [];
        while ($row = $result->fetch_assoc()) {
            $employees[] = $row;
        }
        return $employees;
    }

    public function getPendingEmployees($day, $shift, $week) {
        $query = "SELECT nv.ID_NhanVien, nv.HoTen 
                  FROM ca c 
                  JOIN nhanvien nv ON c.ID_NhanVien = nv.ID_NhanVien
                  WHERE c.TrangThai = 'Đăng ký ca' 
                  AND c.Thu = ? 
                  AND c.Tuan = ? 
                  AND c.TenCa = ?";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("sis", $day, $week, $shift);
        $stmt->execute();
        $result = $stmt->get_result();
        
        $employees = [];
        while ($row = $result->fetch_assoc()) {
            $employees[] = $row;
        }
        return $employees;
    }

    public function approveShift($employeeId, $day, $shift, $week) {
        $query = "UPDATE ca 
                  SET TrangThai = 'Lịch làm việc' 
                  WHERE ID_NhanVien = ? 
                    AND Thu = ? 
                    AND Tuan = ? 
                    AND TenCa = ? 
                    AND TrangThai = 'Đăng ký ca'";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("isis", $employeeId, $day, $week, $shift);
        return $stmt->execute();
    }
}