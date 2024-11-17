<?php
    require_once __DIR__ . '/../model/mNguyenLieu.php';
    class controlNguyenLieu{
        public function getAllNguyenLieu(){
            $p=new modelNguyenLieu();
            $tbl= $p-> selectAllNguyenLieu();
            if(mysqli_num_rows($tbl)){
                return $tbl;
            }else{
                return false;
            }
            
        }
        public function getAllNguyenLieuByCuaHang($lm) {
            $p = new modelNguyenLieu();
            $kq = $p->selectAllNguyenLieuByCuaHang($lm);
            if (mysqli_num_rows($kq)) {
                return $kq;
            } else {
                return false;
            }
        }
        public function getMotNguyenLieu($idNL){
            $p = new modelNguyenLieu();
            $kq = $p->layMotNguyenLieu($idNL);
            if (mysqli_num_rows($kq)) {
                return $kq;
            } else {
                return false;
            }
        }
    }
?>