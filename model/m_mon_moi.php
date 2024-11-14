<?php
    include_once("ketnoi.php");
    class mMonMoi{
        public function SelectAllMonMoi(){
            $p = new clsketnoi();
            $conn = $p->moKetNoi();
            $conn->set_charset('utf8');
            if($conn){
                $str = "select * from danhsachdexuatmonmoi";
                $tbl = $conn->query($str);
                $p->dongKetNoi($conn);
                return $tbl;
            }else{
                return false;
            }
        }
        public function selectInfoMonMoi($idMonMoi){
            $p = new clsketnoi();
            $conn = $p->moKetNoi();
            $conn->set_charset('utf8');
            if($conn){
                $str = "select ds.TenMon, ds.Gia, ds.MoTa, n.HoTen, ds.NguyenLieu, ds.Ngay, ds.HinhAnh, ds.TrangThai from danhsachdexuatmonmoi as ds INNER join nhanvien as n on ds.ID_NhanVien = n.ID_NhanVien where ID_MonMoi ='$idMonMoi'";
                $tbl = $conn->query($str);
                $p->dongKetNoi($conn);
                return $tbl;
            }else{
                return false;
            }
        }
        public function changeStatusTo1($idMonMoi)
        {
            $p = new clsketnoi();
            $conn = $p->moKetNoi();
            $conn->set_charset('utf8');
            if($conn){
                $str = "UPDATE danhsachdexuatmonmoi SET TrangThai= 1 WHERE ID_MonMoi = '$idMonMoi'";
                $tbl = $conn->query($str);
                $p->dongKetNoi($conn);
                return 1;
            }else{
                return false;
            }
        }
        public function changeStatusTo2($idMonMoi)
        {
            $p = new clsketnoi();
            $conn = $p->moKetNoi();
            $conn->set_charset('utf8');
            if($conn){
                $str = "UPDATE danhsachdexuatmonmoi SET TrangThai= 2 WHERE ID_MonMoi = '$idMonMoi'";
                $tbl = $conn->query($str);
                $p->dongKetNoi($conn);
                return 1;
            }else{
                return false;
            }
        }
    }
?>