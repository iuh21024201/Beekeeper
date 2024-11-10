<?php
    include_once("ketnoi.php");
    class modelNguyenLieu{
        public function selectAllNguyenLieu(){
            $p= new clsketnoi();
            $con= $p->moKetNoi(); 
            $truyvan="select * from nguyenlieu";
            $tbl =mysqli_query($con,$truyvan);
            $p ->dongKetNoi($con);
            return $tbl;
        }
    }
?>