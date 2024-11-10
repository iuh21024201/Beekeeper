<?php
include_once("mNguoiDung.php");
class controlNguoiDung{
    public function get01NguoiDung($TND, $MK){
        $MK =md5($MK);
        $p = new modelNguoiDung();
        $ketqua = $p-> select01NguoiDung($TND,$MK);
        if(mysqli_num_rows($ketqua)>0){
            while($r = mysqli_fetch_assoc($ketqua)){
                $_SESSION["dn"] = $r["PhanQuyen"];
            }
            if($_SESSION["dn"] == 1){                                   // Quan li chuoi
                echo"<script>alert('Đăng nhập thành công')</script>";
                header("refresh:0;url='index.php'");
            }elseif($_SESSION["dn"] == 2){                              // Quan li cua hang
                echo"<script>alert('Đăng nhập thành công')</script>";
                header("refresh:0;url='index.php'");
            }elseif($_SESSION["dn"] == 3){                              // Nhan vien ban hang
                echo"<script>alert('Đăng nhập thành công')</script>";
                header("refresh:0;url='index.php'");
            }elseif($_SESSION["dn"] == 4){                              // Nhan vien bep
                echo"<script>alert('Đăng nhập thành công')</script>";
                header("refresh:0;url='index.php'");
            }elseif($_SESSION["dn"] == 5){                              // Khach hang
                echo"<script>alert('Đăng nhập thành công')</script>";
                header("refresh:0;url='index.php'");
            }elseif($_SESSION["dn"] == 6){
                echo"<script>alert('Đăng nhập thành công')</script>";
                header("refresh:0;url='index.php'");
            }
        }else{
            echo"<script>alert('Sai thông tin dăng nhập')</script>";
            header("refresh:0;url='index.php'");
        }
    }
    public function getOneNguoiDung($maND){ 
        $p=new modelNguoiDung();
        $tbl = $p->selectOneNguoiDung($maND);
        if(mysqli_num_rows($tbl)>0){
            return $tbl;
        }else{
            return false;
        }
    }
    public function getAllNguoiDung(){ 
        $p=new modelNguoiDung();
        $tbl = $p->selectAllNguoiDung();
        if(mysqli_num_rows($tbl)>0){
            return $tbl;
        }else{
            return false;
        }
    }
}
?>