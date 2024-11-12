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
    }
?>