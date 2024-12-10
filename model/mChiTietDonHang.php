<?php
    include_once("ketnoi.php");
    class modelCTDH{
        public function insertCTDH($idDH,$idMonAn, $soluong,$ghichu){
            $p= new clsketnoi();
            $con= $p->moKetNoi();
            $ghichu = mysqli_real_escape_string($con, $ghichu); 
            $truyvan="insert into `chitietdonhang`(ID_DonHang,ID_MonAn,SoLuong,GhiChu) values($idDH, $idMonAn, $soluong, '$ghichu')";
            $tbl =mysqli_query($con,$truyvan);
            $p ->dongKetNoi($con);
            return $tbl;
        }
        public function insertCTDHNV($idDH, $idMonAn, $soluong, $ghichu) {
            $p = new clsketnoi();
            $con = $p->moKetNoi();
        
            // Kiểm tra kết nối
            if (!$con) {
                die("Kết nối cơ sở dữ liệu thất bại: " . mysqli_connect_error());
            }
        
            // Xử lý dữ liệu đầu vào
            $idDH = intval($idDH);
            $idMonAn = intval($idMonAn);
            $soluong = intval($soluong);
            $ghichu = mysqli_real_escape_string($con, $ghichu);
        
            // Câu truy vấn
            $truyvan = "INSERT INTO `chitietdonhang` (ID_DonHang, ID_MonAn, SoLuong, GhiChu) 
                        VALUES ($idDH, $idMonAn, $soluong, '$ghichu')";
        
            // Thực thi truy vấn
            $tbl = mysqli_query($con, $truyvan);
        
            // Kiểm tra kết quả
            if (!$tbl) {
                error_log("Lỗi khi thêm chi tiết đơn hàng: " . mysqli_error($con)); // Ghi lỗi vào log
            }
        
            // Đóng kết nối
            $p->dongKetNoi($con);
        
            // Trả về kết quả
            return $tbl;
        }
  
        public function selectCTDHByOrderID($id) {
            $p = new clsketnoi();
            $con = $p->moKetNoi();
            $truyvan = "SELECT CT.GhiChu, CT.SoLuong,CT.ID_MonAn,M.Gia, M.TenMonAn 
                FROM chitietdonhang CT
                JOIN donhang DH ON CT.ID_DonHang = DH.ID_DonHang
                JOIN MonAn M ON CT.ID_MonAn = M.ID_MonAn
                WHERE CT.ID_DonHang = $id";
            $tbl = mysqli_query($con, $truyvan);
            $p->dongKetNoi($con);
            return $tbl;
        }
        public function deleteCTDHByOrderID($id) {
            $p = new clsketnoi();
            $con = $p->moKetNoi();
            $truyvan = "DELETE FROM chitietdonhang WHERE ID_DonHang = $id";
            $tbl = mysqli_query($con, $truyvan);
            $p->dongKetNoi($con);
            return $tbl;
        }
        public function TotalAmountByOrderId($id) {
            $p = new clsketnoi();
            $con = $p->moKetNoi();
            $truyvan = "SELECT SUM(ChiTietDonHang.SoLuong * MonAn.Gia) AS TongTien
                        FROM ChiTietDonHang 
                        JOIN MonAn ON ChiTietDonHang.ID_MonAn = MonAn.ID_MonAn
                        WHERE ChiTietDonHang.ID_DonHang = $id";
            $tbl = mysqli_query($con, $truyvan);
            $p->dongKetNoi($con);
            return $tbl;
        }
        public function selectCTDHForKitchen($id) {
            $p = new clsketnoi();
            $con = $p->moKetNoi();
            $truyvan = "SELECT c.ID_DonHang, m.TenMonAn, m.HinhAnh, c.SoLuong, c.Ghichu, 
                        GROUP_CONCAT(DISTINCT CONCAT(n.TenNguyenLieu, ' (', 
                        t.SoLuongNguyenLieu * c.SoLuong, 'x ',  n.DonViTinh, ')') SEPARATOR ', ') AS CongThuc
                        FROM ChiTietDonHang c
                        JOIN MonAn m ON c.ID_MonAn = m.ID_MonAn
                        JOIN chitietmonan t ON m.ID_MonAn = t.ID_MonAn
                        JOIN nguyenlieu n ON t.ID_NguyenLieu = n.ID_NguyenLieu
                        WHERE c.ID_DonHang = $id
                        GROUP BY c.ID_DonHang, m.TenMonAn"; 
            $tbl = mysqli_query($con, $truyvan);
            $p->dongKetNoi($con);
            return $tbl;
        }
    }
?>