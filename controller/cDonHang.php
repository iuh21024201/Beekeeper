<?php
    include_once("../../model/mDonHang.php");
    class controlDonHang{
        public function insertDH($idCH,$idKH, $ngaydat,$diachi,$trangthai,$phuongthucthanhtoan){
            $p = new modelDH();
            $kq = $p -> insertDH($idCH,$idKH, $ngaydat,$diachi,$trangthai,$phuongthucthanhtoan);
            if($kq){
                return $kq;
            }else{
                return false;
            }
        }
        public function getDHByIDKH($id){
            $p = new modelDH();
            $kq = $p -> selectDHByIDKH($id);
            if(mysqli_num_rows($kq)>0){
                return $kq;
            }else{
                return false;
            }
        }
        public function getDHByID($id){
            $p = new modelDH();
            $kq = $p -> selectDHByID($id);
            if(mysqli_num_rows($kq)>0){
                return $kq;
            }else{
                return false;
            }
        }
        public function deleteDH($id){
            $p = new modelDH();
            $kq = $p -> deleteDH($id);
            if($kq){
                return $kq;
            }else{
                return false;
            }
        }
}
?>