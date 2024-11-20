<?php
require_once __DIR__ . '/../model/mMonAn.php';
require_once ('upload.php');

class controlMonAn {
    
    public function getAllMonAn() {
        $p = new modelMonAn();
        $kq = $p->selectAllMonAn();
        if (mysqli_num_rows($kq)) {
            return $kq;
        } else {
            return false;
        }
    }

    public function getAllMonAnByType($lm) {
        $p = new modelMonAn();
        $kq = $p->selectAllMonAnByType($lm);
        if (mysqli_num_rows($kq)) {
            return $kq;
        } else {
            return false;
        }
    }

    public function getAllMonAnByName($ten){
        $p = new modelMonAn();
        $kq = $p->selectAllMonAnByName($ten);
        if(mysqli_num_rows($kq) > 0){
            return $kq;
        } else {
            return false;
        }
    }

    public function getOneMonAn($maMonAn){
        $p = new modelMonAn();
        $kq = $p -> selectOneMonAn($maMonAn);
        if(mysqli_num_rows($kq)>0){
            return $kq;
        }else{
            return false;
        }
    }
    public function updateTinhTrangMonAn($maMonAn) {
        $p = new modelMonAn();
        $kq = $p->updateTinhTrangMonAn($maMonAn); // Call the model function to update status
    
        return $kq;
    }
    public function getOneChiTietMonAn($maMonAn){
        $p = new modelMonAn();
        $kq = $p -> selectOneChiTietMonAn($maMonAn);
        if(mysqli_num_rows($kq) > 0){
            $result = [];
            while ($r = mysqli_fetch_assoc($kq)) {
                $result[] = $r; // Lưu tất cả các chi tiết món ăn vào mảng
            }
            return $result; // Trả về mảng chứa tất cả chi tiết
        } else {
            return false;
        }
    }
    
    public function updateMonAn($maSP, $loaimon, $tenmon, $mota, $tongNguyenLieu, $gia, $fileHinh, $hinhAnh, $trangThai){
        if (isset($fileHinh["tmp_name"]) && $fileHinh["tmp_name"] != "") {
            $pu = new UploadAnh();
            $kq = $pu->uploadAnhMonAn($fileHinh, $tenmon, $hinhAnh);
            
            if (!$kq) {
                return false;  // Nếu upload ảnh thất bại, trả về false
            }
        }
        $p = new modelMonAn();
        $kq = $p -> updateMonAn($maSP, $loaimon, $tenmon, $mota, $tongNguyenLieu, $gia, $hinhAnh, $trangThai);
        return $kq;
    }

    public function updatechitietMonAn($id_chitietmonan,$maSP, $maNguyenLieu, $SoLuongNguyenLieu){
        $p = new modelMonAn();
        $kq = $p -> updatechitietMonAn($id_chitietmonan,$maSP, $maNguyenLieu, $SoLuongNguyenLieu);
        return $kq;
    }
}
?>
