<?php
    include("../../model/m_yeu_cau.php");
    class cYeuCau{
        public function getAllCHYeuCau(){
            $p = new mYeuCau();
            $tbl = $p->SelectAllCHYeuCau();
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
        public function getAllYeuCau($idCuaHang, $idMonAn){
            $p = new mYeuCau();
            $tbl = $p->SelectAllYeuCau($idCuaHang, $idMonAn);
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
        public function getAllNL($ID_MonAn, $SoLuong){
            $p = new mYeuCau();
            $tbl = $p->SelectAllNL($ID_MonAn, $SoLuong);
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
        public function getAllCHConMonAn($idMonAn, $idCuaHang){
            $p = new mYeuCau();
            $tbl = $p->SelectAllCHConMonAn($idMonAn, $idCuaHang);
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


        public function setCH_Gui($cuaHangGuiNL, $cuaHangNhanNL, $idMonAn, $SLT){
            $p = new mYeuCau();
            $affectedRows = $p->insertCH_Gui($cuaHangGuiNL, $cuaHangNhanNL, $idMonAn, $SLT);
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
        
        
        public function setSLT_CTNL($idNguyenLieu, $SLT, $cuaHangNhanNL, $cuaHangGuiNL){
            $p = new mYeuCau();
            $affectedRows = $p->updateSLT_CTNL($idNguyenLieu, $SLT, $cuaHangNhanNL, $cuaHangGuiNL);
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
        public function setXoaYC($ID_YeuCau){
            $p = new mYeuCau();
            $affectedRows = $p->updateXoaYC($ID_YeuCau);
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
        
        
    }
?>