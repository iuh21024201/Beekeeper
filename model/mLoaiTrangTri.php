<?php
    include_once("ketnoi.php");
    class MLoaiTrangTri{
        public function SelectAllTrangTri(){
            $p = new clsKetNoi();
            $con = $p->moketnoi();
            $con->set_charset('utf8');
            if($con){
                $str = "select * from loaitrangtri";
                $tbl = $con->query($str);
                $p->dongketnoi($con);
                return $tbl;
            }else{
                return false; //không thể kết nối csdl
            }
        }
        public function SelectDecorationById($id) {
            $p = new clsKetNoi();
            $con = $p->moketnoi();
            if($con){
                $str = "SELECT * FROM loaitrangtri WHERE ID_LoaiTrangTri = $id";
                $tbl = $con->query($str);
                $p->dongketnoi($con);
                return $tbl;
            }else{
                return false; //không thể kết nối csdl
            }
        }
    }  
?>