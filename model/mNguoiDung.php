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
    public function selectOneNguoiDung($maND){
        $p=new clsketnoi();
        $con=$p->moKetNoi();
        $truyvan="select * from TaiKhoan where id_TaiKhoan=$maND";
        $ketqua=mysqli_query($con,$truyvan);
        $p->dongKetNoi($con);
        return $ketqua;
    }
    public function dangkytk($tenND, $pass, $hoTen, $soDienThoai, $email, $diaChi) { // Dang ky KH
        $p = new clsketnoi();
        $con = $p->moKetNoi();
    
        // Step 1: Insert into TaiKhoan table
        $truyvanTaiKhoan = "INSERT INTO TaiKhoan (TenTaiKhoan, MatKhau, PhanQuyen) VALUES (N'$tenND', N'$pass', 5)";
        $kqTaiKhoan = mysqli_query($con, $truyvanTaiKhoan);
    
        if ($kqTaiKhoan) {
            // Get the ID of the newly inserted TaiKhoan
            $idTaiKhoan = mysqli_insert_id($con);
    
            // Step 2: Insert into KhachHang table using the new ID_TaiKhoan
            $truyvanKhachHang = "INSERT INTO KhachHang (ID_TaiKhoan, HoTen, SoDienThoai, Email, DiaChi) VALUES ($idTaiKhoan, N'$hoTen', N'$soDienThoai', N'$email', N'$diaChi')";
            $kqKhachHang = mysqli_query($con, $truyvanKhachHang);
    
            // Close the connection
            $p->dongKetNoi($con);
    
            // Return the result of the second query
            return $kqKhachHang;
        } else {
            // Close the connection if the first query fails
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
}
?>