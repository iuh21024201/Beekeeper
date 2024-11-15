<?php
    include_once("ketnoi.php");
    class MLoaiSanPham{
        public function SelectAllLSP(){
            $p = new clsKetNoi();
            $con = $p->moketnoi();
            $con->set_charset('utf8');
            if($con){
                $str = "select * from loaimonan";
                $tblSP = $con->query($str);
                $p->dongketnoi($con);
                return $tblSP;
            }else{
                return false; //không thể kết nối csdl
            }
        }
        public function SelectLSPByMaSP($sql){
            $p = new clsKetNoi();
            $con = $p->moketnoi();
            $con->set_charset('utf8');
            if($con){
                $str = "select * from loaimonan where ID_LoaiMon='$sql'";
                $tblSP = $con->query($str);
                $p->dongketnoi($con);
                return $tblSP;
            }else{
                return false;
            }
            
        }   
    }  
?>