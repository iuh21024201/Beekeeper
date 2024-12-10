<?php
    include("../../model/m_mon_moi.php");
    class cMonMoi{
        public function getAllMonMoi(){
            $p = new mMonMoi();
            $tbl = $p->SelectAllMonMoi();
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
        public function getInfoMonMoi($idMonMoi){
            $p = new mMonMoi();
            $tbl = $p->selectInfoMonMoi($idMonMoi);
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
    class cNhanVien{
        public function getNV($idTaiKhoan){
            $p = new mNhanVien();
            $tbl = $p->selectNV($idTaiKhoan);
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