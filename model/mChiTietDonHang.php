<?php
    include_once("ketnoi.php");
    class modelCTDH{
        public function insertCTDH($idDH,$idMonAn, $soluong,$ghichu){
            $p= new clsketnoi();
            $con= $p->moKetNoi();
            $ghichu = mysqli_real_escape_string($con, $ghichu); 
            $truyvan="insert into `chitietdonhang`(ID_DonHang,ID_MonAn,SoLuong,GhiChu) values($idDH, $idMonAn, $soluong, '$ghichu')";
            $tbl =mysqli_query($con,$truyvan);
            $p ->dongKetNoi($con);
            return $tbl;
        }
        public function selectCTDHByOrderID($id) {
            $p = new clsketnoi();
            $con = $p->moKetNoi();
            $truyvan = "SELECT CT.GhiChu, CT.SoLuong,M.Gia, M.TenMonAn 
                FROM chitietdonhang CT
                JOIN donhang DH ON CT.ID_DonHang = DH.ID_DonHang
                JOIN MonAn M ON CT.ID_MonAn = M.ID_MonAn
                WHERE CT.ID_DonHang = $id";
            $tbl = mysqli_query($con, $truyvan);
            $p->dongKetNoi($con);
            return $tbl;
        }
        public function deleteCTDHByOrderID($id) {
            $p = new clsketnoi();
            $con = $p->moKetNoi();
            $truyvan = "DELETE FROM chitietdonhang WHERE ID_DonHang = $id";
            $tbl = mysqli_query($con, $truyvan);
            $p->dongKetNoi($con);
            return $tbl;
        }
        public function TotalAmountByOrderId($id) {
            $p = new clsketnoi();
            $con = $p->moKetNoi();
            $truyvan = "SELECT SUM(ChiTietDonHang.SoLuong * MonAn.Gia) AS TongTien
                        FROM ChiTietDonHang
                        JOIN MonAn ON ChiTietDonHang.ID_MonAn = MonAn.ID_MonAn
                        WHERE ChiTietDonHang.ID_DonHang = $id";
            $tbl = mysqli_query($con, $truyvan);
            $p->dongKetNoi($con);
            return $tbl;
        }
    }
?>