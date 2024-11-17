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
        public function selectAllNguyenLieuByCuaHang($txt) {
            $p = new clsketnoi();
            $con = $p->moKetNoi();
            if($con){
                $str = "SELECT * FROM nguyenlieu ngl
                        JOIN chitietnguyenlieu ct ON ngl.ID_NguyenLieu = ct.ID_NguyenLieu
                        WHERE ct.ID_CuaHang = $txt";
                $tbl = $con->query($str);
                $p->dongKetNoi($con);
                return $tbl;
            }else{
                return false;
            }
        }
        public function layMotNguyenLieu($idNL){
            $p = new clsketnoi();
            $con = $p->moKetNoi();
            if($con){
                $str = "SELECT * FROM nguyenlieu ngl
                        JOIN chitietnguyenlieu ct ON ngl.ID_NguyenLieu = ct.ID_NguyenLieu
                        WHERE ngl.ID_NguyenLieu = $idNL";
                $tbl = $con->query($str);
                $p->dongKetNoi($con);
                return $tbl;
            }else{
                return false;
            }
        }
    }
?>