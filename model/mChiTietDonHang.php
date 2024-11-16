<?php
    include_once("ketnoi.php");
    class modelCTDH{
        public function insertCTDH($idDH,$idMonAn, $soluong,$ghichu){
            $p= new clsketnoi();
            $con= $p->moKetNoi();
            $ghichu = mysqli_real_escape_string($con, $ghichu); 
            $truyvan="insert into `chitietdonhang`(ID_DonHang,ID_MonAn,SoLuong,GhiChu) values($idDH, $idMonAn, $soluong, '$ghichu')";
            $tbl =mysqli_query($con,$truyvan);
            $p ->dongKetNoi($con);
            return $tbl;
        }
        public function selectCTDHByOrderID($id) {
            $p = new clsketnoi();
            $con = $p->moKetNoi();
            $truyvan = "select * FROM `chitietdonhang` CT join donhang DH on CT.ID_DonHang = DH.ID_DonHang
                        join MonAn M on CT.ID_MonAn = M.ID_MonAn
                            where CT.ID_DonHang = $id";
            $tbl = mysqli_query($con, $truyvan);
            $p->dongKetNoi($con);
            return $tbl;
        }
    }
?>