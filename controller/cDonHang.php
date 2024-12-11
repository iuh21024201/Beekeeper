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
        public function insertDHNV($idCH, $idKH, $idNV, $ngaydat, $diachi, $trangthai, $phuongthucthanhtoa){
            $p = new modelDH();
            $kq = $p -> insertDHNV($idCH, $idKH, $idNV, $ngaydat, $diachi, $trangthai, $phuongthucthanhtoa);
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
        public function updateDH($madh,$anh){
            $p = new modelDH();
            $kq = $p -> updateDH($madh,$anh);
            if($kq){
                return $kq;
            }else{
                return false;
            }
        }
        public function getOrdersByEmployeeAccount($id){
            $p = new modelDH();
            $kq = $p ->  selectOrdersByEmployeeAccount($id);
            if($kq){
                return $kq;
            }else{
                return false;
            }
        }
        public function updateOrderStatusToPaid($id){
            $p = new modelDH();
            $kq = $p -> updateOrderStatusToPaid($id);
            if($kq){
                return $kq;
            }else{
                return false;
            }
        }
        
        public function updateOrderStatusToCanceled($id){
            $p = new modelDH();
            $kq = $p -> updateOrderStatusToCanceled($id);
            if($kq){
                return $kq;
            }else{
                return false;
            }
        }
        public function updateOrderStatusToPrepare($id){
            $p = new modelDH();
            $kq = $p -> updateOrderStatusToPrepare($id);
            if($kq){
                return $kq;
            }else{
                return false;
            }
        }
        public function getDHByIDCuaHang($id){
            $p = new modelDH();
            $kq = $p -> selectDHByIDCuaHang($id);
            if(mysqli_num_rows($kq)>0){
                return $kq;
            }else{
                return false;
            }
        }
}
?>