<?php
    include("../../model/m_xem_so_luong_ban.php");
    class CBan{
        public function getAllBan($cuahang){
            $p = new Mban();
            $tbl = $p->SelectAllBan($cuahang);
            if($tbl){
                if($tbl->num_rows>0){
                    return $tbl;
                }else{
                    return -1;
                }
            }else{
                return false;
            }
        }
        public function getBan1CH($idTaiKhoan){
            $p = new Mban();
            $tbl = $p->SelectAllBan_With_IDTK($idTaiKhoan);
            
            if($tbl){
                if($tbl->num_rows>0){
                    return $tbl;
                }else{
                    return -1;
                }
            }else{
                return false;
            }
        }
        public function setBan($tenBan, $idCuaHang){
            $p = new Mban();
            $tbl = $p->addBan($tenBan, $idCuaHang);
    
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
        public function setXoaBan($idBan){
            $p = new Mban();
            $tbl = $p->deleteBan($idBan);
    
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
    class CCuaHang {
        public function getAllCuaHang() {
            $p = new Mban();
            $tbl = $p->selectAllCuaHang();
    
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
        public function get1CuaHang($idTaiKhoan) {
            $p = new Mban();
            $tbl = $p->select1CuaHang($idTaiKhoan);
    
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