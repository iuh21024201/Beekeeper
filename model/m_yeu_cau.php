<?php
    include_once("ketnoi.php");
    class mYeuCau{
        public function SelectAllCHYeuCau(){
            $p = new clsketnoi();
            $conn = $p->moKetNoi();
            $conn->set_charset('utf8');
            if($conn){
                $str = "SELECT ch.ID_CuaHang, ch.TenCuaHang, yc.TrangThai, yc.ID_MonAn, ma.TenMonAn
                FROM cuahang ch 
                inner join danhsachyeucaubosungnguyenlieu yc on ch.ID_CuaHang = yc.ID_CuaHangNhan 
                inner join monan ma on ma.ID_MonAn = yc.ID_MonAn";
                $tbl = $conn->query($str);
                $p->dongKetNoi($conn);
                return $tbl;
            }else{
                return false;
            }
        }
        public function SelectAllYeuCau($idCuaHang,  $idMonAn){
            $p = new clsketnoi();
            $conn = $p->moKetNoi();
            $conn->set_charset('utf8');
            if ($conn) {
                $str = "SELECT ma.ID_MonAn, ma.TenMonAn, yc.SoLuong , yc.TrangThai, yc.ID_YeuCau
                        FROM danhsachyeucaubosungnguyenlieu yc 
                        INNER JOIN monan ma on yc.ID_MonAn = ma.ID_MonAn 
                        WHERE yc.ID_CuaHangNhan = $idCuaHang && yc.ID_MonAn = $idMonAn";
                $tbl = $conn->query($str);
        
                // Kiểm tra nếu truy vấn trả về kết quả hợp lệ
                if ($tbl) {
                    $p->dongKetNoi($conn);
                    return $tbl;
                } else {
                    // Nếu có lỗi trong truy vấn, trả về false hoặc xử lý lỗi
                    echo "Lỗi truy vấn: " . $conn->error;
                    $p->dongKetNoi($conn);
                    return false;
                }
            } else {
                // Nếu kết nối không thành công
                echo "Không thể kết nối đến cơ sở dữ liệu.";
                return false;
            }
        }
        
        public function SelectAllNL($ID_MonAn, $SoLuong){
            $p = new clsketnoi();
            $conn = $p->moKetNoi();
            $conn->set_charset('utf8');
            if($conn){
                $str = "SELECT nl.ID_NguyenLieu, ct.SoLuongNguyenLieu * $SoLuong AS SoLuongCanDung 
                FROM thucdon td JOIN chitietmonan ct ON td.ID_monan = ct.ID_monan 
                JOIN nguyenlieu nl ON ct.ID_nguyenlieu = nl.ID_nguyenlieu 
                WHERE td.ID_monan = $ID_MonAn
                GROUP BY nl.ID_NguyenLieu";
                $tbl = $conn->query($str);
                $p->dongKetNoi($conn);
                return $tbl;
            }else{
                return false;
            }
            
        }
        public function SelectAllCHConMonAn($idMonAn, $idCuaHang){
            $p = new clsketnoi();
            $conn = $p->moKetNoi();
            $conn->set_charset('utf8');
            if($conn){
                $str = "SELECT td.SoLuongTon, ch.TenCuaHang, ch.ID_CuaHang
                FROM thucdon td 
                inner join cuahang ch on td.ID_CuaHang = ch.ID_CuaHang 
                WHERE ch.ID_CuaHang != $idCuaHang && td.ID_MonAn = $idMonAn 
                GROUP by ch.TenCuaHang;";
                $tbl = $conn->query($str);
                $p->dongKetNoi($conn);
                return $tbl;
            }else{
                return false;
            }
            
        }

        public function insertCH_Gui($cuaHangGuiNL, $cuaHangNhanNL, $idMonAn, $SLT){
            $p = new clsketnoi();
            $conn = $p->moKetNoi();
            $conn->set_charset('utf8');
            if ($conn) {
                $str = "
                    UPDATE danhsachyeucaubosungnguyenlieu 
                    SET ID_CuaHangGui = $cuaHangGuiNL, TrangThai = 1 
                    WHERE ID_CuaHangNhan = $cuaHangNhanNL AND ID_MonAn = $idMonAn;
                    
                    UPDATE thucdon 
                    SET SoLuongTon = SoLuongTon + $SLT 
                    WHERE ID_CuaHang = $cuaHangNhanNL AND ID_MonAn = $idMonAn;
        
                    UPDATE thucdon 
                    SET SoLuongTon = SoLuongTon - $SLT 
                    WHERE ID_CuaHang = $cuaHangGuiNL AND ID_MonAn = $idMonAn;
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
        
        
        public function updateSLT_CTNL($idNguyenLieu, $SLT, $cuaHangNhanNL, $cuaHangGuiNL){
            $p = new clsketnoi();
            $conn = $p->moKetNoi();
            $conn->set_charset('utf8');
            if ($conn) {
                $str = "
                    UPDATE chitietnguyenlieu 
                    SET SoLuong = SoLuong + $SLT 
                    WHERE ID_CuaHang = $cuaHangNhanNL AND ID_NguyenLieu = $idNguyenLieu;
        
                    UPDATE chitietnguyenlieu 
                    SET SoLuong = SoLuong - $SLT 
                    WHERE ID_CuaHang = $cuaHangGuiNL AND ID_NguyenLieu = $idNguyenLieu;
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

        public function updateXoaYC($ID_YeuCau){
            $p = new clsketnoi();
            $conn = $p->moKetNoi();
            $conn->set_charset('utf8');
            if ($conn) {
                $str = "
                    UPDATE danhsachyeucaubosungnguyenlieu 
                    SET TrangThai = 2 
                    WHERE ID_YeuCau = $ID_YeuCau;
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