<?php
    include_once("ketnoi.php");
    class modelLoaiMon{
        public function selectAllLoaiMon(){
            $p= new clsketnoi();
            $con= $p->moKetNoi(); 
            $truyvan="select * from loaimonan";
            $tbl =mysqli_query($con,$truyvan);
            $p ->dongKetNoi($con);
            return $tbl;
        }

        public function selectOneLoaiMon($maLM){
            $p = new clsketnoi();
            $truyvan = "Select * from loaimonan where ID_LoaiMon = $maLM";
            $con = $p -> moKetNoi();
            $kq = mysqli_query($con, $truyvan);
            $p -> dongKetNoi($con);
            return $kq;
        }

        public function insertLoaiMon($tenLM, $trangThai){
            $p = new clsketnoi();
            $truyvan = "INSERT INTO loaimonan(TenLoaiMon, TrangThai) VALUES (N'$tenLM', '$trangThai')";
            $con = $p->moKetNoi();
            $kq = mysqli_query($con, $truyvan);
            $p->dongKetNoi($con);
            return $kq;
        }
        public function updateLoaiMon($maLM, $tenLM, $trangThai){
            $p = new clsketnoi();
            $truyvan = "UPDATE loaimonan SET TenLoaiMon = '$tenLM', TrangThai = '$trangThai' WHERE ID_LoaiMon = $maLM";
            $con = $p -> moKetNoi();
            $kq = mysqli_query($con, $truyvan);
            $p -> dongKetNoi($con);
            return $kq;
        }

        public function updateTinhTrangLoaiMon($maLoaiMon) {
            $p = new clsketnoi();
            
            // First, update the status of the category itself
            $truyvanLoaiMon = "UPDATE loaimonan SET TrangThai = 1 WHERE ID_LoaiMon = $maLoaiMon";
            $con = $p->moKetNoi();
            $kqLoaiMon = mysqli_query($con, $truyvanLoaiMon);
            
            if ($kqLoaiMon) {
                // After updating the category status, update the status of all dishes in that category
                $truyvanMonAn = "UPDATE monan SET TinhTrang  = 1 WHERE ID_LoaiMon = $maLoaiMon";
                $kqMonAn = mysqli_query($con, $truyvanMonAn);
            }
            
            $p->dongKetNoi($con);
            return $kqLoaiMon && $kqMonAn;
        }
        
    }
?>