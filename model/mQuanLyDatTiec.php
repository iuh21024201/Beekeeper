<?php
class mQuanLyDatTiec {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function getBookingsByStore($storeId) {
        $query = "SELECT * FROM DatTiec WHERE ID_CuaHang = :storeId";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':storeId', $storeId, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getBookingDetails($id, $storeId) {
        $query = "SELECT * FROM DatTiec WHERE ID = :id AND ID_CuaHang = :storeId";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->bindParam(':storeId', $storeId, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function deleteBooking($id, $storeId) {
        $query = "DELETE FROM DatTiec WHERE ID = :id AND ID_CuaHang = :storeId";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->bindParam(':storeId', $storeId, PDO::PARAM_INT);
        return $stmt->execute();
    }

    public function updateBooking($data, $storeId) {
        $query = "UPDATE DatTiec SET GioHen = :gioHen, ID_LoaiTrangTri = :trangTri, SoNguoi = :soNguoi, TongTien = :tongTien, TienCoc = :tienCoc, TienConLai = :tienConLai, GhiChu = :ghiChu WHERE ID = :id AND ID_CuaHang = :storeId";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':gioHen', $data['GioHen']);
        $stmt->bindParam(':trangTri', $data['ID_LoaiTrangTri']);
        $stmt->bindParam(':soNguoi', $data['SoNguoi']);
        $stmt->bindParam(':tongTien', $data['TongTien']);
        $stmt->bindParam(':tienCoc', $data['TienCoc']);
        $stmt->bindParam(':tienConLai', $data['TienConLai']);
        $stmt->bindParam(':ghiChu', $data['GhiChu']);
        $stmt->bindParam(':id', $data['ID']);
        $stmt->bindParam(':storeId', $storeId);
        return $stmt->execute();
    }
}
?>
