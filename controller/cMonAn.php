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

    public function insertMonAn($tenMon, $loaiMon, $gia, $hinhAnh, $moTa, $tinhTrang, $soLuongNL) {
        // Kiểm tra nếu hình ảnh có sẵn và tiến hành upload
        $hinh = ''; // Đặt giá trị mặc định cho biến $hinh
        if (is_array($hinhAnh) && isset($hinhAnh['tmp_name']) && $hinhAnh['tmp_name'] != "") {
            $pn = new uploadAnh();
            $hinh = $pn->uploadAnhMonAn($hinhAnh, $tenMon, $hinh); // Gọi phương thức upload ảnh
            if (!$hinh) {
                return false; // Nếu upload không thành công, trả về false
            }
        }

        // Chèn dữ liệu món ăn vào cơ sở dữ liệu
        $p = new modelMonAn();
        $kq = $p->insertMonAn($tenMon, $loaiMon, $gia, $hinh, $moTa, $tinhTrang, $soLuongNL);

        // Kiểm tra kết quả chèn
        return $kq;
    }

    public function insertIngredientsForProduct($productId, $nguyenLieu, $soLuongNguyenLieu) {
        $p = new modelMonAn();
        $kq = $p->insertIngredientsForProduct($productId, $nguyenLieu, $soLuongNguyenLieu);

        // Kiểm tra kết quả chèn nguyên liệu cho món ăn
        return $kq;
    }
}
?>
