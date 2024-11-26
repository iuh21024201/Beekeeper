<?php
    include("../../model/m_update_ban.php");
    class cUpdateBan{
        public function getBan($idCuaHang){
            $p = new mlayBan();
            $tbl = $p->selectBan($idCuaHang);
    
            if ($tbl) {
                if ($tbl->num_rows > 0) {
                    return $tbl;
                } else {
                    return -1;  // Không có dữ liệu
                }
            } else {
                return false;  // Kết nối thất bại hoặc lỗi truy vấn
            }
        }
        public function setStatusBan($idBan, $status){
            $p = new mlayBan();
            $tbl = $p->updateStatusBan($idBan, $status);
    
            if ($tbl) {
                if ($tbl->num_rows > 0) {
                    return $tbl;
                } else {
                    return -1;  // Không có dữ liệu
                }
            } else {
                return false;  // Kết nối thất bại hoặc lỗi truy vấn
            }
        }

    }
    class cLayCuaHang{
        public function getCuaHang($idTaiKhoan) {
            $p = new mlayBan();
            $tbl = $p->selectCuaHang($idTaiKhoan);
    
            if ($tbl) {
                if ($tbl->num_rows > 0) {
                    return $tbl;
                } else {
                    return -1;  // Không có dữ liệu
                }
            } else {
                return false;  // Kết nối thất bại hoặc lỗi truy vấn
            }
        }
    }

?>