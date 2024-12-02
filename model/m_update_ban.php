<?php
    include_once("ketnoi.php");
    class mlayBan{
        public function selectCuaHang($idTaiKhoan){
            $p = new clsketnoi();
            $conn = $p->moKetNoi();
            $conn->set_charset('utf8');
            if($conn){
                $str = "SELECT ch.ID_CuaHang, ch.TenCuaHang FROM cuahang as ch inner join nhanvien as nv on ch.ID_CuaHang = nv.ID_CuaHang where nv.ID_TaiKhoan= $idTaiKhoan";
                $tbl = $conn->query($str);
                $p->dongKetNoi($conn);
                return $tbl;
            }else{
                return false;
            }
        }
        public function selectBan($idCuaHang){
            $p = new clsketnoi();
            $conn = $p->moKetNoi();
            $conn->set_charset('utf8');
            if($conn){
                $str = "select ID_Ban, TenBan, TinhTrang from ban where ID_CuaHang = $idCuaHang ORDER BY TenBan";
                $tbl = $conn->query($str);
                $p->dongKetNoi($conn);
                return $tbl;
            }else{
                return false;
            }
        }
        public function updateStatusBan($idBan, $status){
            $p = new clsketnoi();
            $conn = $p->moKetNoi();
            $conn->set_charset('utf8');
            if($conn){
                $str = "UPDATE ban SET TinhTrang = $status WHERE ID_Ban = $idBan";
                $tbl = $conn->query($str);
                $p->dongKetNoi($conn);
                return $tbl;
            }else{
                return false;
            }
        }
    }
?>