<?php
include_once("ketnoi.php");
class modelNguoiDung{
    public function select01NguoiDung($TenND,$MatKhau){
        $p=new clsketnoi();
        $con=$p->moKetNoi();
        $truyvan="select * from TaiKhoan where TenTaiKhoan='$TenND' and MatKhau='$MatKhau'";
        $ketqua=mysqli_query($con,$truyvan);
        $p->dongKetNoi($con);
        return $ketqua;
    }
    public function selectAllNguoiDung(){
        $p=new clsketnoi();
        $con=$p->moKetNoi();
        $truyvan="select * from TaiKhoan";
        $ketqua=mysqli_query($con,$truyvan);
        $p->dongKetNoi($con);
        return $ketqua;
    }
    public function selectOneNguoiDung($maND){ //ID_KhachHang
        $p=new clsketnoi();
        $con=$p->moKetNoi();
        $truyvan="select * from KhachHang where ID_TaiKhoan='$maND'";
        $ketqua=mysqli_query($con,$truyvan);
        $p->dongKetNoi($con);
        return $ketqua;
    }
    
    public function dangkytk($hoTen, $soDienThoai, $email, $pass, $diaChi) {
        $p = new clsketnoi();
        $con = $p->moKetNoi();
    
        // Step 0: Check if the email already exists in TaiKhoan
        $kiemTraEmail = "SELECT * FROM TaiKhoan WHERE TenTaiKhoan = N'$email'";
        $resultEmail = mysqli_query($con, $kiemTraEmail);
    
        if (mysqli_num_rows($resultEmail) > 0) {
            $p->dongKetNoi($con);
            return "email_ton_tai";
        }
    
        // Step 1: Insert into TaiKhoan table
        $truyvanTaiKhoan = "INSERT INTO TaiKhoan (TenTaiKhoan, MatKhau, PhanQuyen) VALUES (N'$email', N'$pass', 5)";
        $kqTaiKhoan = mysqli_query($con, $truyvanTaiKhoan);
    
        if ($kqTaiKhoan) {
            $idTaiKhoan = mysqli_insert_id($con);
    
            // Step 2: Insert into KhachHang table
            $truyvanKhachHang = "INSERT INTO KhachHang (ID_TaiKhoan, HoTen, SoDienThoai, Email, DiaChi) 
                                 VALUES ($idTaiKhoan, N'$hoTen', N'$soDienThoai', N'$email', N'$diaChi')";
            $kqKhachHang = mysqli_query($con, $truyvanKhachHang);
    
            $p->dongKetNoi($con);
            return $kqKhachHang;
        } else {
            $p->dongKetNoi($con);
            return false;
        }
    }
    

    public function selectCustomerIdByAccountId($idtaikhoan){
        $p=new clsketnoi();
        $con=$p->moKetNoi();
        $truyvan="SELECT ID_KhachHang FROM khachhang WHERE ID_TaiKhoan = $idtaikhoan ";
        $ketqua=mysqli_query($con,$truyvan);
        $p->dongKetNoi($con);
        return $ketqua;
    }
    public function selectSaleIdByAccountId($idnhanvien){
        $p=new clsketnoi();
        $con=$p->moKetNoi();
        $truyvan="SELECT ID_NhanVien FROM NhanVien WHERE ID_NhanVien = $idnhanvien ";
        $ketqua=mysqli_query($con,$truyvan);
        $p->dongKetNoi($con);
        return $ketqua;
    }
    public function updateNguoiDung($idKH, $hoTenMoi, $soDienThoaiMoi, $emailMoi, $diaChiMoi) {
        $p = new clsketnoi();
        // Truy vấn SQL để cập nhật thông tin khách hàng
        $truyvan = "UPDATE KhachHang 
                     SET HoTen = N'$hoTenMoi', 
                         SoDienThoai = '$soDienThoaiMoi', 
                         Email = '$emailMoi', 
                         DiaChi = N'$diaChiMoi' 
                     WHERE ID_KhachHang = $idKH";
        $con = $p->moKetNoi();
        $kq = mysqli_query($con, $truyvan);
        $p->dongKetNoi($con);
        return $kq;
    }
    
}
?>