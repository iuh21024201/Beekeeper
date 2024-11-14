<?php
    include_once("../../model/mLoaiSanPham.php");
    class cLoaiSanPham{
        public function getAllLSP(){
            $p = new MLoaiSanPham();
            $tblSP = $p->SelectAllLSP();
            if(!$tblSP){
                return -1;
            }else{
                if($tblSP->num_rows > 0){
                    return $tblSP;
                }else{
                    return 0; // không có dòng dữ liệu
                }
            }
        }
    }
?>