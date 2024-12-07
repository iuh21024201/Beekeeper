<?php
require_once __DIR__ . '/../model/mThongKeDoanhThu.php';

class CThongKeDoanhThu {
    public function getDoanhThu($filterType, $startDate = null, $endDate = null) {
        // Khởi tạo đối tượng MThongKeDoanhThu
        $p = new MThongKeDoanhThu();

        // Gọi phương thức getDoanhThu và truyền tham số lọc vào
        $tbl = $p->getDoanhThu($filterType, $startDate, $endDate);

        // Kiểm tra nếu có dữ liệu
        if ($tbl && count($tbl) > 0) {
            return $tbl;  // Trả về dữ liệu
        } else {
            return false;  // Không có dữ liệu
        }
    }
    public function getDoanhThu1CuaHangByCuaHang( $startDate = null, $endDate = null, $idCuaHang = null) {
        // Khởi tạo đối tượng MThongKeDoanhThu
        $p = new MThongKeDoanhThu();

        // Gọi phương thức getDoanhThu và truyền tham số lọc vào
        $tbl = $p->getDoanhThu1CuaHangByCuaHang($startDate, $endDate,$idCuaHang);

        // Kiểm tra nếu có dữ liệu
        if ($tbl && count($tbl) > 0) {
            return $tbl;  // Trả về dữ liệu
        } else {
            return false;  // Không có dữ liệu
        }
    }
    public function getDoanhThu1CuaHangByThoiGian( $startDate = null, $endDate = null, $idCuaHang = null) {
        // Khởi tạo đối tượng MThongKeDoanhThu
        $p = new MThongKeDoanhThu();

        // Gọi phương thức getDoanhThu và truyền tham số lọc vào
        $tbl = $p->getDoanhThu1CuaHangByThoiGian($startDate, $endDate,$idCuaHang);

        // Kiểm tra nếu có dữ liệu
        if ($tbl && count($tbl) > 0) {
            return $tbl;  // Trả về dữ liệu
        } else {
            return false;  // Không có dữ liệu
        }
    }
}
?>
