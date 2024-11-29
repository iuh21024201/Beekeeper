<?php
    include_once("ketnoi.php");
    class mThucDon{
        public function selectCuaHang($idTaiKhoan){
            $p = new clsketnoi();
            $conn = $p->moKetNoi();
            $conn->set_charset('utf8');
            if($conn){
                $str = "SELECT ch.ID_CuaHang, ch.TenCuaHang FROM quanlycuahang ql INNER JOIN cuahang ch ON ch.ID_CuaHang = ql.ID_CuaHang WHERE ID_TaiKhoan = $idTaiKhoan";
                $tbl = $conn->query($str);
                $p->dongKetNoi($conn);
                return $tbl;
            }else{
                return false;
            }
        }

        public function selectNgayThucDon($idCuaHang){
            $p = new clsketnoi();
            $conn = $p->moKetNoi();
            $conn->set_charset('utf8');
            if($conn){
                $str = "SELECT ID_MonAn, NgayNhap FROM thucdon
                WHERE ID_CuaHang = $idCuaHang  GROUP BY ID_MonAn";
                $tbl = $conn->query($str);
                $p->dongKetNoi($conn);
                return $tbl;
            }else{
                return false;
            }
        }

        public function selectAllThucDon($idCuaHang){
            $p = new clsketnoi();
            $conn = $p->moKetNoi();
            $conn->set_charset('utf8');
            if($conn){
                $str = "SELECT ma.TenMonAn, ma.ID_MonAn, td.SoLuongTon, ma.TinhTrang FROM monan ma 
                INNER JOIN thucdon td ON ma.ID_MonAn = td.ID_MonAn
                INNER JOIN cuahang ch ON ch.ID_CuaHang = td.ID_CuaHang 
                WHERE ch.ID_CuaHang = $idCuaHang GROUP BY ID_MonAn";
                $tbl = $conn->query($str);
                $p->dongKetNoi($conn);
                return $tbl;
            }else{
                return false;
            }
        }

        public function updateSLT($idNguyenLieu, $soLuong, $idCuaHang) {
            $p = new clsketnoi();
            $conn = $p->moKetNoi();
            $conn->set_charset('utf8');
            
            if ($conn) {
                $str = "UPDATE chitietnguyenlieu 
                    SET NgayNhap = NOW() , SoLuong = $soLuong
                    WHERE ID_CuaHang = $idCuaHang AND ID_NguyenLieu = $idNguyenLieu;
                ";
                if ($conn->query($str)) {
                    return $conn->affected_rows; // Trả về số dòng bị ảnh hưởng
                } else {
                    return false; // Truy vấn thất bại
                }
                $p->dongKetNoi($conn);
            } else {
                return false; // Kết nối thất bại
            }
        }
        

        public function updateSLT_TD($idCuaHang, $idMonAn, $soLuong){
            $p = new clsketnoi();
            $conn = $p->moKetNoi();
            $conn->set_charset('utf8');
            $day = date('Y-m-d');
            if ($conn) {
                $str = "
                    UPDATE thucdon 
                    SET NgayNhap =NOW(), SoLuongTon =  $soLuong 
                    WHERE ID_CuaHang = $idCuaHang AND ID_MonAn = $idMonAn;
        
                ";
                if ($conn->multi_query($str)) {
                    // Trả về affected_rows
                    return $conn->affected_rows; 
                } else {
                    return false; // Truy vấn thất bại
                }
                $p->dongKetNoi($conn);
            } else {
                return false; // Kết nối thất bại
            }
        }

        public function resetSLT($idMonAn, $idCuaHang){
            $p = new clsketnoi();
            $conn = $p->moKetNoi();
            $conn->set_charset('utf8');
            if ($conn) {
                $str = "
                    UPDATE thucdon 
                    SET SoLuongTon = 0
                    WHERE ID_CuaHang = $idCuaHang AND ID_MonAn = $idMonAn;
        
                ";
                if ($conn->multi_query($str)) {
                    // Trả về affected_rows
                    return $conn->affected_rows; 
                } else {
                    return false; // Truy vấn thất bại
                }
                $p->dongKetNoi($conn);
            } else {
                return false; // Kết nối thất bại
            }
        }

        public function selectChiTietNL($ID_MonAn){
            $p = new clsketnoi();
            $conn = $p->moKetNoi();
            $conn->set_charset('utf8');
            if($conn){
                $str = "SELECT ID_NguyenLieu FROM chitietmonan WHERE ID_MonAn= $ID_MonAn";
                $tbl = $conn->query($str);
                $p->dongKetNoi($conn);
                return $tbl;
            }else{
                return false;
            }
        }

        public function resetSLNL($idNL,$idCuaHang){
            $p = new clsketnoi();
            $conn = $p->moKetNoi();
            $conn->set_charset('utf8');
            if ($conn) {
                $str = " UPDATE chitietnguyenlieu SET SoLuong = 0
                WHERE ID_CuaHang = $idCuaHang AND ID_NguyenLieu = $idNL;";
                if ($conn->multi_query($str)) {
                    // Trả về affected_rows
                    return $conn->affected_rows; 
                } else {
                    return false; // Truy vấn thất bại
                }
                $p->dongKetNoi($conn);
            } else {
                return false; // Kết nối thất bại
            }
        }
    }

?>