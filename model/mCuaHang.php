<?php
    include_once("ketnoi.php");
    class MCuaHang{
        public function SelectAllStore(){
            $p = new clsKetNoi();
            $con = $p->moketnoi();
            $con->set_charset('utf8');
            if($con){
                $str = "select * from cuahang";
                $tblSP = $con->query($str);
                $p->dongketnoi($con);
                return $tblSP;
            }else{
                return false; //không thể kết nối csdl
            }
        }
        public function SelectStoreByID($id){
            $p = new clsKetNoi();
            $con = $p->moketnoi();
            $con->set_charset('utf8');
            if($con){
                $str = "select * from cuahang where ID_CuaHang='$id'";
                $tblSP = $con->query($str);
                $p->dongketnoi($con);
                return $tblSP;
            }else{
                return false; //không thể kết nối csdl
            }
        }
    }  
?>