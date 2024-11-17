<?php
    include_once("../../model/mChiTietDonHang.php");
    class controlCTDonHang{
        public function insertCTDH($idDH,$idMonAn, $soluong,$ghichu){
            $p = new modelCTDH();
            $kq = $p -> insertCTDH($idDH,$idMonAn, $soluong,$ghichu);
            if($kq){
                return $kq;
            }else{
                return false;
            }
        }
        public function getCTDHByOrderID($id){
            $p = new modelCTDH();
            $kq = $p -> selectCTDHByOrderID($id);
            if(mysqli_num_rows($kq)>0){
                return $kq;
            }else{
                return false;
            }
        }
        public function deleteCTDHByOrderID($id){
            $p = new modelCTDH();
            $kq = $p -> deleteCTDHByOrderID($id);
            if($kq){
                return $kq;
            }else{
                return false;
            }
        }
}
?>
