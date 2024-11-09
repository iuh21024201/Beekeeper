<?php
include_once("ketnoi.php");
class modelMonAn {
    public function selectAllMonAn() {
        $p = new clsketnoi();
        $con = $p->moKetNoi();
        $truyvan = "SELECT * FROM monan m JOIN loaimonan lm ON m.id_loaimon = lm.id_loaimon ORDER BY id_monan DESC";
        
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
        $p = new clsketNoi();
        $truyvan = " SELECT * FROM monan m 
                    JOIN loaimonan lm ON m.id_loaimon = lm.id_loaimon 
                    WHERE m.TenMonAn like N'%$ten%'";
        $con = $p -> moKetNoi();
        $kq = mysqli_query($con, $truyvan);
        $p -> dongKetNoi($con);
        return $kq;
    }

    public function insertMonAn($tenMon, $loaiMon, $gia, $hinhAnh, $moTa, $tinhTrang, $soLuongNL)
    {
        // Kiểm tra các tham số đầu vào
        if (empty($tenMon) || empty($loaiMon) || empty($gia) || empty($hinhAnh) || empty($moTa) || empty($tinhTrang) || empty($soLuongNL)) {
            return false; // Nếu có tham số rỗng, trả về false
        }

        // Kết nối cơ sở dữ liệu
        $p = new clsketNoi();
        $con = $p->moKetNoi();

        // Thêm sản phẩm vào bảng monan
        $truyvan = "INSERT INTO monan (TenMonAn, ID_LoaiMon, Gia, HinhAnh, MoTa, TinhTrang, SoLuongNL) 
                    VALUES (N'$tenMon', $loaiMon, $gia, '$hinhAnh', '$moTa', '$tinhTrang', '$soLuongNL')";
        
        $kq = mysqli_query($con, $truyvan);

        // Đóng kết nối
        $p->dongKetNoi($con);

        return $kq;  // Trả về kết quả thêm sản phẩm
    }

    public function insertIngredientsForProduct($productId, $nguyenLieu, $soLuongNguyenLieu)
    {
        // Kết nối cơ sở dữ liệu
        $p = new clsketNoi();
        $con = $p->moKetNoi();

        // Lưu thông tin nguyên liệu vào bảng ChiTietMonAn
        for ($i = 0; $i < count($nguyenLieu); $i++) {
            $nguyenLieuId = $nguyenLieu[$i]; // ID nguyên liệu
            $soLuong = $soLuongNguyenLieu[$i]; // Số lượng nguyên liệu
            
            // Thêm chi tiết nguyên liệu vào bảng ChiTietMonAn
            $insertChiTietNguyenLieu = "INSERT INTO chitietmonan (ID_MonAn, ID_NguyenLieu, SoLuongNguyenLieu) 
                                        VALUES ('$productId', '$nguyenLieuId', '$soLuong')";
            mysqli_query($con, $insertChiTietNguyenLieu);
        }

        // Đóng kết nối
        $p->dongKetNoi($con);
    }
}

?>