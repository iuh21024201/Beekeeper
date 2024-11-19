<?php
include("../../model/m_gui_yeu_cau.php");
class cMonAn{
    public function getAllMonAn($idCuaHang){
        $p = new mMonAn();
        $tbl = $p->SelectAllMonAn($idCuaHang);
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
    public function getInfoNguyenLieu($idMonAn, $soluong){
        $p = new mMonAn();
        $tbl = $p->SelectInfoNguyenLieu($idMonAn, $soluong);
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
    public function get1MonAn($idMonAn){
        $p = new mMonAn();
        $tbl = $p->Select1MonAn($idMonAn);
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
    public function addYeuCauNguyenLieu($idCuaHang, $idMonAn, $soLuong){
        $p = new mMonAn();
        $tbl = $p->addYC($idCuaHang, $idMonAn, $soLuong);
        if($tbl){
            if($tbl> 0){
                return $tbl;
            }else{
                return -1;
            }
        }else{
            return false;
        }
    }
}

?>