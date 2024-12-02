<?php
    include("../../model/m_phan_hoi.php");
    class cPhanHoi{
        public function getAllPhanHoi(){
            $p = new mPhanHoi();
            $tbl = $p->selectAllPhanHoi();
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
        public function getPH($idFB){
            $p = new mPhanHoi();
            $tbl = $p->selectPH($idFB);
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