<?php
    include("../../model/m_lien_he.php");
    class cLienHe{
        public function getInfo($idTaiKhoan){
            $p = new mLienHe();
            $tbl = $p->selectInfo($idTaiKhoan);
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