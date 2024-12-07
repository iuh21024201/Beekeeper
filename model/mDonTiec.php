<?php
include_once("ketnoi.php");

class modelDonTiec {
    // Hàm thêm đơn tiệc
    public function insertDonTiec($idKH, $idCH, $idTT, $giohen, $songuoi, $ghichu, $trangthai) {
        $p = new clsketnoi();
        $con = $p->moKetNoi();
        $sql = "INSERT INTO dontiec (ID_KhachHang, ID_CuaHang, ID_LoaiTrangTri, GioHen, SoNguoi, GhiChu, TrangThai) 
                VALUES ('$idKH', '$idCH', '$idTT', '$giohen', '$songuoi', '$ghichu', '$trangthai')";
        $tbl = mysqli_query($con,$sql);
        if ($tbl) {
            $lastId = mysqli_insert_id($con); // Lấy ID_DonHang vừa được tự động sinh
        } else {
            $lastId = false;
        }
        $p ->dongKetNoi($con);
        return $lastId;
    }

    // Hàm thêm chi tiết đơn tiệc
    public function insertCTDT($idDatTiec, $idMonAn, $soluong) {
        $p = new clsketnoi();
        $con = $p->moKetNoi();
        $sql = "INSERT INTO chitietdattiec (ID_DatTiec, ID_MonAn, SoLuong) VALUES ($idDatTiec, $idMonAn, $soluong)";
        $tbl =mysqli_query($con,$sql);
            $p ->dongKetNoi($con);
            return $tbl;
    }
}
?>
