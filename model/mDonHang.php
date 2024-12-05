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
        public function selectOrdersByEmployeeAccount($id) {
            $p = new clsketnoi();
            $truyvan = "SELECT  donhang.ID_DonHang, donhang.ID_CuaHang, donhang.NgayDat, donhang.TrangThai,donhang.PhuongThucThanhToan, donhang.DiaChiGiaoHang, donhang.AnhThanhToan,
                        SUM(ct.SoLuong * ma.Gia) AS TongTien
                        FROM donhang 
                        JOIN chitietdonhang ct ON donhang.ID_DonHang = ct.ID_DonHang
                        JOIN monan ma ON ct.ID_MonAn = ma.ID_MonAn
                        JOIN nhanvien ON donhang.ID_CuaHang = nhanvien.ID_CuaHang
                        JOIN taikhoan ON nhanvien.ID_TaiKhoan = taikhoan.ID_TaiKhoan
                        WHERE taikhoan.ID_TaiKhoan = '$id' AND donhang.TrangThai = 'Đặt thành công'
                        GROUP BY donhang.ID_DonHang
                        ";
            $con = $p->moKetNoi();
            $kq = mysqli_query($con, $truyvan);
            $p->dongKetNoi($con);
            return $kq;
        }
        public function updateOrderStatusToPaid($id) {
            $p = new clsketnoi();
            $truyvan = "UPDATE donhang SET TrangThai = 'Đã thanh toán' WHERE ID_DonHang = '$id'";
            $con = $p->moKetNoi();
            $kq = mysqli_query($con, $truyvan);
            $p->dongKetNoi($con);
            return $kq;
        }
        public function updateOrderStatusToCanceled($id) {
            $p = new clsketnoi();
            $truyvan = "UPDATE donhang SET TrangThai = 'Đã hủy' WHERE ID_DonHang = '$id'";
            $con = $p->moKetNoi();
            $kq = mysqli_query($con, $truyvan);
            $p->dongKetNoi($con);
            return $kq;
        }
        public function updateOrderStatusToPrepare($id) {
            $p = new clsketnoi();
            $truyvan = "UPDATE donhang SET TrangThai = 'Đang chế biến' WHERE ID_DonHang = '$id'";
            $con = $p->moKetNoi();
            $kq = mysqli_query($con, $truyvan);
            $p->dongKetNoi($con);
            return $kq;
        }
        
    }
?>