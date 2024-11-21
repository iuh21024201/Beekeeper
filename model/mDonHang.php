<?php
    include_once("ketnoi.php");
    class modelDH{
        public function selectDHByIDKH($id) {
            $p = new clsketnoi();
            $con = $p->moKetNoi();
            $truyvan = "select * FROM `donhang` where ID_KhachHang = $id";
            $tbl = mysqli_query($con, $truyvan);
            $p->dongKetNoi($con);
            return $tbl;
        }
        public function selectDHByID($id) {
            $p = new clsketnoi();
            $con = $p->moKetNoi();
            $truyvan = "select * FROM `donhang` DH join cuahang CH on DH.ID_CuaHang = CH.ID_CuaHang
                         where ID_DonHang = $id";
            $tbl = mysqli_query($con, $truyvan);
            $p->dongKetNoi($con);
            return $tbl;
        }
        public function insertDH($idCH,$idKH, $ngaydat,$diachi,$trangthai,$phuongthucthanhtoan){
            $p= new clsketnoi();
            $con= $p->moKetNoi(); 
            $truyvan="insert into `donhang`(ID_CuaHang,ID_KhachHang,NgayDat,DiaChiGiaoHang,TrangThai,PhuongThucThanhToan) 
                      VALUES($idCH, $idKH, '$ngaydat', '$diachi', '$trangthai', $phuongthucthanhtoan)";
            $tbl =mysqli_query($con,$truyvan);
            if ($tbl) {
                $lastId = mysqli_insert_id($con); // Lấy ID_DonHang vừa được tự động sinh
            } else {
                $lastId = false;
            }
            $p ->dongKetNoi($con);
            return $lastId;
        }
        public function deleteDH($id) {
            $p = new clsketnoi();
            $con = $p->moKetNoi();
            $truyvan = "DELETE FROM donhang WHERE ID_DonHang = $id";
            $tbl = mysqli_query($con, $truyvan);
            $p->dongKetNoi($con);
            return $tbl;
        }
        public function updateDH($madh, $anh) {
            $p = new clsketnoi();
            $truyvan = "UPDATE donhang SET AnhThanhToan = '$anh' WHERE ID_DonHang = $madh";
            $con = $p->moKetNoi();
            $kq = mysqli_query($con, $truyvan);
            $p->dongKetNoi($con);
            return $kq;
        }
        
    }
?>