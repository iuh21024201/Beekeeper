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

        public function selectAllThucDon($idCuaHang){
            $p = new clsketnoi();
            $conn = $p->moKetNoi();
            $conn->set_charset('utf8');
            if($conn){
                $str = "SELECT ma.TenMonAn, ma.ID_MonAn, td.SoLuongTon, ma.TinhTrang FROM monan ma 
                INNER JOIN thucdon td ON ma.ID_MonAn = td.ID_MonAn
                INNER JOIN cuahang ch ON ch.ID_CuaHang = td.ID_CuaHang 
                WHERE ch.ID_CuaHang = $idCuaHang";
                $tbl = $conn->query($str);
                $p->dongKetNoi($conn);
                return $tbl;
            }else{
                return false;
            }
        }

        public function updateSLT($idNguyenLieu, $soLuong, $idCuaHang){
            $p = new clsketnoi();
            $conn = $p->moKetNoi();
            $conn->set_charset('utf8');
            if ($conn) {
                $str = "
                    UPDATE chitietnguyenlieu 
                    SET SoLuong = $soLuong 
                    WHERE ID_CuaHang = $idCuaHang AND ID_NguyenLieu = $idNguyenLieu;
        
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

        public function updateSLT_TD($idCuaHang, $idMonAn, $soLuong){
            $p = new clsketnoi();
            $conn = $p->moKetNoi();
            $conn->set_charset('utf8');
            if ($conn) {
                $str = "
                    UPDATE thucdon 
                    SET SoLuongTon = $soLuong 
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
    }

?>