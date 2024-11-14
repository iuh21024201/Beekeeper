<?php
    include("../../model/m_mon_moi.php");
    class cInfoMonMoi{
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
        public function statusChange($idMonMoi){
            $p = new mMonMoi();
            $tbl = $p->changeStatusTo1($idMonMoi);
            if($tbl){
                return $tbl;
            }else{
                return false;
            }
        }
        public function statusChange_1($idMonMoi){
            $p = new mMonMoi();
            $tbl = $p->changeStatusTo2($idMonMoi);
            if($tbl){
                return $tbl;
            }else{
                return false;
            }
        }
    }
?>