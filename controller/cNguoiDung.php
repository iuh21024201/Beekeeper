<?php
include_once(__DIR__ . "/../model/mNguoiDung.php");

class controlNguoiDung{
    public function get01NguoiDung($TND, $MK){
        $MK =md5($MK);
        $p = new modelNguoiDung();
        $ketqua = $p->select01NguoiDung($TND, $MK);
        $account = $p->selectAccountByUsernameAndPassword($TND, $MK);
    
        if (mysqli_num_rows($ketqua) > 0) {
            while ($r = mysqli_fetch_assoc($ketqua)) {
                $_SESSION["dn"] = $r["PhanQuyen"];
                $_SESSION["ID_TaiKhoan"] = $r["ID_TaiKhoan"];
                $_SESSION["ID_NhanVien"] = $account["ID_NhanVien"];
                return $_SESSION["dn"]; 
            }
        } else {
            echo"<script>alert('Đăng nhập thất bại!!!')</script>";
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
        $p = new modelNguoiDung();
        $kq = $p->dangkytk($hoTen, $soDienThoai, $email, $pass, $diaChi);
    
        if ($kq === "email_ton_tai") {
            return "email_ton_tai";
        } elseif ($kq) {
            return true;
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
    public function getSaleIdByAccountId($idNhanVien) {
        $p = new modelNguoiDung();
        $tbl = $p->selectSaleIdByAccountId($idNhanVien);
    
        if (mysqli_num_rows($tbl) > 0) {
            $row = mysqli_fetch_assoc($tbl);
            return $row['ID_NhanVien']; // Trả về giá trị ID_KhachHang
        } else {
            return false;
        }
    }
    public function updateNguoiDung($idKH, $hoTenMoi, $soDienThoaiMoi, $emailMoi, $diaChiMoi) {
        $p = new modelNguoiDung();
        $kq = $p->updateNguoiDung($idKH, $hoTenMoi, $soDienThoaiMoi, $emailMoi, $diaChiMoi);
        if ($kq) { // $kq will be true if the query was successful
            return true;
        } else {
            return false;
        }
    }
    
    
}
?>
