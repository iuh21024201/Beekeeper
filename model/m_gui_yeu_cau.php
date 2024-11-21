<?php
    include_once("ketnoi.php");
    class mMonAn{
        public function SelectAllMonAn($idCuaHang){
            $p = new clsketnoi();
            $conn = $p->moKetNoi();
            $conn->set_charset('utf8');
            if($conn){
                $str = "SELECT ma.ID_MonAn, ma.TenMonAn, td.SoLuongTon 
                FROM cuahang ch 
                INNER JOIN thucdon td ON ch.ID_CuaHang = td.ID_CuaHang 
                INNER JOIN monan ma ON td.ID_MonAn = ma.ID_MonAn 
                WHERE ch.ID_CuaHang = $idCuaHang";
                $tbl = $conn->query($str);
                $p->dongKetNoi($conn);
                return $tbl;
            }else{
                return false;
            }
        }
        public function Select1MonAn($idMonAn){
            $p = new clsketnoi();
            $conn = $p->moKetNoi();
            $conn->set_charset('utf8');
            if($conn){
                $str = "SELECT TenMonAn from monan where ID_MonAn = $idMonAn";
                $tbl = $conn->query($str);
                $p->dongKetNoi($conn);
                return $tbl;
            }else{
                return false;
            }
        }
        public function SelectInfoNguyenLieu($idMonAn, $soluong){
            $p = new clsketnoi();
            $conn = $p->moKetNoi();
            $conn->set_charset('utf8');
            if($conn){
                $str = "SELECT DISTINCT nl.ID_NguyenLieu, nl.TenNguyenLieu AS TenNguyenLieu, ct.SoLuongNguyenLieu * $soluong AS SoLuongCanDung 
                FROM thucdon td JOIN chitietmonan ct ON td.ID_monan = ct.ID_monan 
                JOIN nguyenlieu nl ON ct.ID_nguyenlieu = nl.ID_nguyenlieu 
                WHERE td.ID_monan = $idMonAn";
                $tbl = $conn->query($str);
                $p->dongKetNoi($conn);
                return $tbl;
            }else{
                return false;
            }
        }
        public function addYC($idCuaHang, $idMonAn, $soLuong){
            $p = new clsketnoi();
            $conn = $p->moKetNoi();
            $conn->set_charset('utf8');
            if($conn){
                $str = "INSERT INTO danhsachyeucaubosungnguyenlieu(ID_CuaHangNhan, ID_MonAn, TrangThai, SoLuong) 
                        VALUES ($idCuaHang, $idMonAn, 0, $soLuong)";
                $tbl = $conn->query($str);
                $p->dongKetNoi($conn);
                return 1;
            }else{
                return false;
            }
        }
    }
?>