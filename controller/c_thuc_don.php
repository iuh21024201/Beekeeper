<?php
    include("../../model/m_thuc_don.php");
    class cThucDon{
        public function getCuaHang($idTaiKhoan){
            $p = new mThucDon();
            $tbl = $p->selectCuaHang($idTaiKhoan);
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

        public function getAllThucDon($idCuaHang){
            $p = new mThucDon();
            $tbl = $p->selectAllThucDon($idCuaHang);
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

        public function setNL($idNguyenLieu, $soLuong, $idCuaHang){
            $p = new mThucDon();
            $affectedRows = $p->updateSLT($idNguyenLieu, $soLuong, $idCuaHang);
            if ($affectedRows !== false) {
                if ($affectedRows > 0) {
                    return true; // Thực hiện thành công
                } else {
                    return -1; // Không có dòng nào bị thay đổi
                }
            } else {
                return false; // Truy vấn thất bại
            }
        
        }

        public function setSLT_TD($idCuaHang, $idMonAn, $soLuong){
            $p = new mThucDon();
            $affectedRows = $p->updateSLT_TD($idCuaHang, $idMonAn, $soLuong);
            if ($affectedRows !== false) {
                if ($affectedRows > 0) {
                    return true; // Thực hiện thành công
                } else {
                    return -1; // Không có dòng nào bị thay đổi
                }
            } else {
                return false; // Truy vấn thất bại
            }
        }


        public function getNgayThucDon($idCuaHang){
            $p = new mThucDon();
            $tbl = $p->selectNgayThucDon($idCuaHang);
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

        public function setSLT0($idCuaHang){
            $p = new mThucDon();
            $affectedRows = $p->resetSLT($idCuaHang);
            if ($affectedRows !== false) {
                if ($affectedRows > 0) {
                    return true; // Thực hiện thành công
                } else {
                    return -1; // Không có dòng nào bị thay đổi
                }
            } else {
                return false; // Truy vấn thất bại
            }
        }

        public function getchitietNL($ID_MonAn){
            $p = new mThucDon();
            $tbl = $p->selectChiTietNL($ID_MonAn);
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

        public function setSL_NL0($idCuaHang){
            $p = new mThucDon();
            $affectedRows = $p->resetSLNL($idCuaHang);
            if ($affectedRows !== false) {
                if ($affectedRows > 0) {
                    return true; // Thực hiện thành công
                } else {
                    return -1; // Không có dòng nào bị thay đổi
                }
            } else {
                return false; // Truy vấn thất bại
            }
        }
        public function getThucDonByMonAnAndCuaHang($idMonAn, $idCH, $currentDate) {
            $p = new mThucDon();
            $tbl = $p->selectThucDonByMonAnAndCuaHang($idMonAn, $idCH, $currentDate);
            if ($tbl && $tbl->num_rows > 0) {
                return $tbl->fetch_assoc(); 
            } else {
                return null;
            }
        }
        public function updateSoLuongTon($idMonAn, $idCH, $soLuongBan, $currentDate) {
            $p = new mThucDon(); 
            return $p->updateSoLuongTonByMonAnAndCuaHang($idMonAn, $idCH, $soLuongBan, $currentDate);
        }
        public function increaseSoLuongTon($idMonAn, $idCH, $soLuong) {
            $p = new mThucDon(); 
            return $p->updateIncreaseSoLuongTon($idMonAn, $idCH, $soLuong);
        }
<<<<<<< HEAD
=======
        
>>>>>>> 1fc273ec1fdc3a8385118a7d7210127a0e339954
    }
?>