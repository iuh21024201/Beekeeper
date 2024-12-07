<?php
    include_once("../../model/mDonTiec.php");
    class controlDonTiec{
        public function insertDonTiec($idKH, $idCH, $idTT,$giohen,$songuoi,$ghichu,$trangthai){
            $p = new modelDonTiec();
            $kq = $p -> insertDonTiec($idKH, $idCH, $idTT,$giohen,$songuoi,$ghichu,$trangthai);
            if($kq){
                return $kq;
            }else{
                return false;
            }
        }
        public function insertCTDT($idDatTiec,$idMonAn, $soluong){
            $p = new modelDonTiec();
            $kq = $p -> insertCTDT($idDatTiec,$idMonAn, $soluong);
            if($kq){
                return $kq;
            }else{
                return false;
            }
        }
    }

?>
                