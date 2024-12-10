<?php
    include_once("ketnoi.php");
    class mMonAn{
        public function SelectIDNhanVien($idTaiKhoan){
            $p = new clsketnoi();
            $conn = $p->moKetNoi();
            $conn->set_charset('utf8');
            if($conn){
                $str = "SELECT ID_NhanVien
                FROM nhanvien  
                WHERE ID_TaiKhoan = $idTaiKhoan";
                $tbl = $conn->query($str);
                $p->dongKetNoi($conn);
                return $tbl;
            }else{
                return false;
            }
        }
        public function Select01NhanVien($idTaiKhoan){
            $p = new clsketnoi();
            $conn = $p->moKetNoi();
            $conn->set_charset('utf8');
            if($conn){
                $str = "SELECT *
                FROM nhanvien  
                WHERE ID_TaiKhoan = $idTaiKhoan";
                $tbl = $conn->query($str);
                $p->dongKetNoi($conn);
                return $tbl;
            }else{
                return false;
            }
        }
    }
?>