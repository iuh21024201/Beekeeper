<?php
include_once("model/mNguoiDung.php");
<<<<<<< HEAD
class controlNguoiDung{
    public function get01NguoiDung($TND, $MK){
        $MK =md5($MK);
=======

class controlNguoiDung {
    public function get01NguoiDung($TND, $MK) {
        $MK = md5($MK);
>>>>>>> f92b05f38333899c9333d659fc85d6dd21780c10
        $p = new modelNguoiDung();
        $ketqua = $p->select01NguoiDung($TND, $MK);
    
        if (mysqli_num_rows($ketqua) > 0) {
            while ($r = mysqli_fetch_assoc($ketqua)) {
                $_SESSION["dn"] = $r["PhanQuyen"];
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

    public function dangkytk($tenND, $pass, $hoTen, $soDienThoai, $email, $diaChi) {
        // Instantiate the modelNguoiDung object
        $p = new modelNguoiDung();
    
        // Call the model's dangkytk function with all required parameters
        $kq = $p->dangkytk($tenND, $pass, $hoTen, $soDienThoai, $email, $diaChi);
    
        // Return the result or false if the operation fails
        if ($kq) {
            return $kq;
        } else {
            return false;
        }
    }
    
}
?>
