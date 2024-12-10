<?php
include_once("ketnoi.php");
class modelMonAn {
    public function selectAllMonAn() {
        $p = new clsketnoi();
        $con = $p->moKetNoi();
        $truyvan = "SELECT * 
            FROM monan m 
            JOIN loaimonan lm ON m.id_loaimon = lm.id_loaimon 
            ORDER BY 
                CASE 
                    WHEN m.tinhtrang = 'Đang bán' THEN 1 
                    WHEN m.tinhtrang = 'Ngưng bán' THEN 2 
                    ELSE 3 
                END, 
                id_monan DESC";

        
        $kq = mysqli_query($con, $truyvan);
        
        $p->dongKetNoi($con);
        return $kq;  
    }
    public function selectAllMonAnByType($lm) {
        $p = new clsketnoi();
        $con = $p->moKetNoi();
        $truyvan = "SELECT * FROM monan m 
                    JOIN loaimonan lm ON m.id_loaimon = lm.id_loaimon 
                    WHERE lm.id_loaimon = $lm";
        
        $kq = mysqli_query($con, $truyvan);
    
        $p->dongKetNoi($con);
        return $kq;
    }
   
    public function selectAllMonAnByName($ten){
        $p = new clsketnoi();
        $truyvan = " SELECT * FROM monan m 
                    JOIN loaimonan lm ON m.id_loaimon = lm.id_loaimon 
                    WHERE m.TenMonAn like N'%$ten%'";
        $con = $p -> moKetNoi();
        $kq = mysqli_query($con, $truyvan);
        $p -> dongKetNoi($con);
        return $kq;
    }
    public function selectOneMonAn($maMonAn){
        $p = new clsketnoi();
        $truyvan = "SELECT * FROM monan m 
                    JOIN loaimonan lm ON m.id_loaimon = lm.id_loaimon 
                    WHERE id_monan =$maMonAn";
        $con = $p -> moKetNoi();
        $kq = mysqli_query($con, $truyvan);
        $p -> dongKetNoi($con);
        return $kq;
     }
    public function updateTinhTrangMonAn($maMonAn) {
        $p = new clsketnoi();
        $truyvan = "UPDATE monan SET tinhtrang = 1 WHERE id_monan = $maMonAn AND tinhtrang = 0";
        $con = $p->moKetNoi();
        $kq = mysqli_query($con, $truyvan);
        $p->dongKetNoi($con);
        return $kq;
    }
    public function selectOneChiTietMonAn($maMonAn) {
        $p = new clsketnoi();
        $truyvan = "SELECT *
                    FROM chitietmonan ctm
                    JOIN monan m ON ctm.id_monan = m.id_monan
                    JOIN nguyenlieu nl ON ctm.id_nguyenlieu = nl.id_nguyenlieu
                    WHERE ctm.id_monan = $maMonAn";
        $con = $p->moKetNoi();
        $kq = mysqli_query($con, $truyvan);
        $p->dongKetNoi($con);
        return $kq;
    }

    public function updateMonAn($maSP, $loaimon, $tenmon, $mota, $tongNguyenLieu, $gia, $hinhAnh, $trangThai){
        $p = new clsketNoi();
        $truyvan = "update monan set TenMonAn=N'$tenmon', Gia=$gia, HinhAnh='$hinhAnh', MoTa='$mota', TongNguyenLieu='$tongNguyenLieu' ,TinhTrang='$trangThai', ID_LoaiMon =$loaimon where ID_MonAn =$maSP ";
        $con = $p -> moKetNoi();
        $kq = mysqli_query($con, $truyvan);
        $p -> dongKetNoi($con);
        return $kq;
    }

    public function updatechitietMonAn($ingredientDetailIds,$maSP, $ingredientsNames, $ingredientsQuantities) {
        $p = new clsketNoi();
    $con = $p->moKetNoi();

    // Loop through each ingredient and update its quantity
    foreach ($ingredientsNames as $index => $maNguyenLieu) {
        $SoLuongNguyenLieu = $ingredientsQuantities[$index];
        $id_chitietmonan = $ingredientDetailIds[$index]; // Fetch ingredient detail ID

        // Check if both ingredient and quantity are valid
        if (!empty($maNguyenLieu) && !empty($SoLuongNguyenLieu)) {
            // Update ingredient quantity for the specified dish and ingredient ID
            $truyvan = "UPDATE chitietmonan 
                        SET SoLuongNguyenLieu = '$SoLuongNguyenLieu', ID_NguyenLieu = '$maNguyenLieu' 
                        WHERE id_chitietmonan = '$id_chitietmonan' and ID_MonAn = '$maSP'";

            $kq = mysqli_query($con, $truyvan);
            if (!$kq) {
                // Handle errors
                $p->dongKetNoi($con);
                return false;
            }
        }
    }

    $p->dongKetNoi($con);
    return true;
    }
    
}

?>