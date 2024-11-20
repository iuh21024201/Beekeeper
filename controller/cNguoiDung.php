<?php
include_once(__DIR__ . "/../model/mNguoiDung.php");

class controlNguoiDung{
    public function get01NguoiDung($TND, $MK){
        $MK =md5($MK);
        $p = new modelNguoiDung();
        $ketqua = $p->select01NguoiDung($TND, $MK);
    
        if (mysqli_num_rows($ketqua) > 0) {
            while ($r = mysqli_fetch_assoc($ketqua)) {
                $_SESSION["dn"] = $r["PhanQuyen"];
                $_SESSION["ID_TaiKhoan"] = $r["ID_TaiKhoan"];
                return $_SESSION["dn"]; // Trả về giá trị PhanQuyen
            }
        } else {
            return 0; // Trả về 0 nếu đăng nhập không thành công
        }
    }
    public function getOneNguoiDung($maND) {
        $p = new modelNguoiDung();
        $tbl = $p->selectOneNguoiDung($maND);

        if (mysqli_num_rows($tbl) > 0) {
            return $tbl;
        } else {
            return false;
        }
    }

    public function getAllNguoiDung() {
        $p = new modelNguoiDung();
        $tbl = $p->selectAllNguoiDung();

        if (mysqli_num_rows($tbl) > 0) {
            return $tbl;
        } else {
            return false;
        }
    }
    public function dangkytk($hoTen, $soDienThoai, $email, $pass, $diaChi) {
        // Instantiate the modelNguoiDung object
        $p = new modelNguoiDung();
    
        // Call the model's dangkytk function with all required parameters
        $kq = $p->dangkytk($hoTen, $soDienThoai, $email, $pass, $diaChi);
    
        // Return the result or false if the operation fails
        if ($kq) {
            return $kq;
        } else {
            return false;
        }
    }
    public function getCustomerIdByAccountId($idTaiKhoan) {
        $p = new modelNguoiDung();
        $tbl = $p->selectCustomerIdByAccountId($idTaiKhoan);
    
        if (mysqli_num_rows($tbl) > 0) {
            $row = mysqli_fetch_assoc($tbl);
            return $row['ID_KhachHang']; // Trả về giá trị ID_KhachHang
        } else {
            return false;
        }
    }
}
?>
