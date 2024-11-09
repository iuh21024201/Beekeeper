<?php
    require_once __DIR__ . '/../model/mLoaiMonAn.php';
    class controlLoaiMon{
        public function getAllLoaiMon(){
            $p=new modelLoaiMon();
            $tbl= $p-> selectAllLoaiMon();
            if(mysqli_num_rows($tbl)){
                return $tbl;
            }else{
                return false;
            }
            
        }
    }
?>