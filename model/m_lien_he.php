<?php
    include_once("ketnoi.php");
    class mLienHe{
        public function selectInfo($idTaiKhoan){
            $p = new clsketnoi();
            $conn = $p->moKetNoi();
            $conn->set_charset('utf8');
            if($conn){
                $str = "SELECT ID_KhachHang FROM khachhang WHERE ID_TaiKhoan = $idTaiKhoan";
                $tbl = $conn->query($str);
                $p->dongKetNoi($conn);
                return $tbl;
            }else{
                return false;
            }
        }
    }

?>