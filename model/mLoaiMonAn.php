<?php
    include_once("ketnoi.php");
    class modelLoaiMon{
        public function selectAllLoaiMon(){
            $p= new clsketnoi();
            $con= $p->moKetNoi(); 
            $truyvan="select * from loaimonan";
            $tbl =mysqli_query($con,$truyvan);
            $p ->dongKetNoi($con);
            return $tbl;
        }
    }
?>