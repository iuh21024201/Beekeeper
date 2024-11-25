<?php
include("../../model/m_lay_nhan_vien.php");
class cNhanVien{
    public function getIDNhanVien($idTaiKhoan){
        $p = new mMonAn();
        $tbl = $p->SelectIDNhanVien($idTaiKhoan);
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
?>