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
    }
?>