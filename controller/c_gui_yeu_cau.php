<?php
include("../../model/m_gui_yeu_cau.php");
class cMonAn{
    public function getAllMonAn(){
        $p = new mMonMoi();
        $tbl = $p->SelectAllMonAn();
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