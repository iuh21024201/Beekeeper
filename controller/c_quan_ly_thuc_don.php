<?php
    include("../../model/m_quan_ly_thuc_don.php");
    class cThucDon{
        public function getThucDon($cuahang){
            $p = new mThucDon();
            $tbl = $p->selectThucDon($cuahang);
            
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