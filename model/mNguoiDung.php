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
}
?>