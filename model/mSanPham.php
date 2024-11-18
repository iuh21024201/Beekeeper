<?php
    include_once("ketnoi.php");
    class MSanPham{
        public function SelectAllSP(){
            $p = new clsKetNoi();
            $con = $p->moketnoi();
            $con->set_charset('utf8');
            if($con){
                $str = "select * from monan order by ID_MonAn desc";
                $tblSP = $con->query($str);
                $p->dongketnoi($con);
                return $tblSP;
            }else{
                return false; //không thể kết nối csdl
            }
        }
        public function SelectAllSPByCate($cate){
            $p = new clsKetNoi();
            $con = $p->moketnoi();
            $con->set_charset('utf8');
            if($con){
                $str = "select * from monan where ID_LoaiMon = '$cate'";
                $tblSP = $con->query($str);
                $p->dongketnoi($con);
                return $tblSP;
            }else{
                return false;
            }
            
        }
        public function SelectAllSPByStore($id){
            $p = new clsKetNoi();
            $con = $p->moketnoi();
            $con->set_charset('utf8');
            if($con){
                $str = "select * from thucdon T
                        join monan M on T.ID_MonAn = M.ID_MonAn where T.ID_CuaHang ='$id' ";
                $tblSP = $con->query($str);
                $p->dongketnoi($con);
                return $tblSP;
            }else{
                return false;
            }
            
        }
        public function SelectAllSPByName($name){
            $p = new clsKetNoi();
            $con = $p->moketnoi();
            $con->set_charset('utf8');
            if($con){
                $str = "select * from monan where TenMonAn like N'%$name%'";
                $tblSP = $con->query($str);
                $p->dongketnoi($con);
                return $tblSP;
            }else{
                return false;
            }
            
        }
        public function SelectAllSPChiTiet($id){
            $p = new clsKetNoi();
            $con = $p->moketnoi();
            $con->set_charset('utf8');
            if($con){
                $str = "select * from monan S join loaimonan L on S.ID_MonAn = L.ID_LoaiMon where ID_MonAn = '$id'";
                $tblSP = $con->query($str);
                $p->dongketnoi($con);
                return $tblSP;
            }else{
                return false;
            }
        }
        public function SelectAllSPByPrice($price) {
            $p = new clsKetNoi();
            $con = $p->moketnoi();
            $con->set_charset('utf8');
            if($con) {
                $str = "SELECT * FROM monan WHERE Gia <= $price";
                $result = $con->query($str);
                $p->dongketnoi($con);
                return $result;
            } else {
                return false;
            }
        }
        public function SelectCTSPByID($id){
            $p = new clsKetNoi();
            $con = $p->moketnoi();
            $con->set_charset('utf8');
            if($con){
                $str = "select * from monan M join loaimonan L on M.ID_LoaiMon = L.ID_LoaiMon where ID_MonAn = '$id'";
                $tblSP = $con->query($str);
                $p->dongketnoi($con);
                return $tblSP;
            }else{
                return false;
            }
            
        }
    
        public function SelectSPByID($id){
            $p = new clsKetNoi();
            $con = $p->moketnoi();
            $con->set_charset('utf8');
            if($con){
                $str = "select * from monan where ID_MonAn = '$id'";
                $tblSP = $con->query($str);
                $p->dongketnoi($con);
                return $tblSP;
            }else{
                return false;
            }
            
        }
    }
?>