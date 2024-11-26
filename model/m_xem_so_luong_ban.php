<?php
    include_once("ketnoi.php");
    class Mban{
        // Ban
        public function SelectAllBan($cuahang){
            $p = new clsketnoi();
            $conn = $p->moKetNoi();
            $conn->set_charset('utf8');
            if($conn){
                $str = "select ID_Ban, TenBan, TinhTrang from ban where ID_CuaHang = $cuahang ORDER BY TenBan";
                $tbl = $conn->query($str);
                $p->dongKetNoi($conn);
                return $tbl;
            }else{
                return false;
            }
        }
        public function SelectAllBan_With_IDTK($idTaiKhoan){
            $p = new clsketnoi();
            $conn = $p->moKetNoi();
            $conn->set_charset('utf8');
            if($conn){
                $str = "SELECT TenBan, ID_Ban,  TinhTrang FROM quanlycuahang as ql INNER JOIN cuahang as ch ON ql.ID_CuaHang = ch.ID_CuaHang INNER JOIN ban as b ON ch.ID_CuaHang = b.ID_CuaHang WHERE ql.ID_TaiKhoan = $idTaiKhoan ORDER BY TenBan";
                $tbl = $conn->query($str);
                $p->dongKetNoi($conn);
                return $tbl;
            }else{
                return false;
            }
        }
        public function addBan($tenBan, $idCuaHang){
            $p = new clsketnoi();
            $conn = $p->moKetNoi();
            $conn->set_charset('utf8');
            if($conn){
                $str  = "INSERT INTO ban (TenBan, ID_CuaHang, TinhTrang) VALUES ('$tenBan', $idCuaHang, 0)";
                $tbl = $conn->query($str);
                $p->dongKetNoi($conn);
                return $tbl;
            }else{
                return false;
            }
        }
        public function deleteBan($idBan){
            $p = new clsketnoi();
            $conn = $p->moKetNoi();
            $conn->set_charset('utf8');
            if($conn){
                $str  = "DELETE FROM `ban` WHERE ID_Ban = $idBan";
                $tbl = $conn->query($str);
                $p->dongKetNoi($conn);
                return $tbl;
            }else{
                return false;
            }
        }
        // CuaHang
        public function selectAllCuaHang(){
            $p = new clsketnoi();
            $conn = $p->moKetNoi();
            $conn->set_charset('utf8');
            if($conn){
                $str = "SELECT ID_CuaHang, TenCuaHang FROM cuahang";
                $tbl = $conn->query($str);
                $p->dongKetNoi($conn);
                return $tbl;
            }else{
                return false;
            }
        }
        public function select1CuaHang($idTaiKhoan){
            $p = new clsketnoi();
            $conn = $p->moKetNoi();
            $conn->set_charset('utf8');
            if($conn){
                $str = "SELECT ch.ID_CuaHang, ch.TenCuaHang FROM cuahang as ch inner join quanlycuahang as ql on ch.ID_CuaHang = ql.ID_CuaHang where ID_TaiKhoan= $idTaiKhoan";
                $tbl = $conn->query($str);
                $p->dongKetNoi($conn);
                return $tbl;
            }else{
                return false;
            }
        }
    }
?>